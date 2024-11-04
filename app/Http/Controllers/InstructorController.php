<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Post;
use App\Models\User;
use App\Models\Enrollee;
use App\Models\Files;
use App\Models\Assignment;
use App\Models\AssignmentFile;
use App\Models\TempAssignment;
use App\Models\TempFile;
use App\Models\TurnInFile;
use App\Models\TurnIn;
use App\Models\Lesson;
use App\Models\UnitOfCompetency;
use App\Models\StudentGrade;
use App\Models\StudentAttendance;
use App\Models\Attendance;
use App\Models\Instructor;
use App\Models\Comment;
use App\Http\Controllers\NotificationSendController;

// Mailing
use App\Mail\Assignment as AssignmentMail;
use Illuminate\Support\Facades\Mail;

// File
use Symfony\Component\HttpFoundation\File\File;

class InstructorController extends Controller
{
    // Batch List
    public function batch_list(){
        $batch = Instructor::with(['batches' => function($query){
            $query->whereNull( 'deleted_at')
                ->with(['course' => function ($course) {
                    $course->select(['id', 'code', 'name', 'folder', 'filename'])->whereNull('deleted_at');
                }]);
        }])
        ->where('user_id', auth()->user()->id)->first();

        

        // dd($batch);

        return view('instructor.batch_list', compact('batch'));
    }

    public function get_batch_info(Request $request){
        $batch = Batch::where('id', $request->batch_id)
        ->with(['enrollee' => function($query){
            $query->select('id', 'batch_id', 'user_id')
                ->whereNull('deleted_at')
                ->whereHas('user', function($userQuery) {
                    $userQuery->whereNull('deleted_at');
                })
                ->with(['user' => function($user){
                    $user->select(['id','fname', 'mname', 'lname', 'email', 'created_at']);
                }]);
        }])->first();

        if($batch){
            return response()->json(['status' => 'success', 'batch' => $batch]);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Batch not found']);
    }

    public function close_batch(Request $request){
        $batch = Batch::where('id', $request->batch_id)->whereNull('completed_at')->first();

        if($batch){
            $batch->completed_at = Carbon::now();
            
            if($batch->update()){
                return response()->json(['status' => 'success', 'message' => "Batch: {$batch->course->name}-{$batch->name} Closed", 'date' => $batch->completed_at]);
            }

            return response()->json(['status' => 'error', 'message' => 'Batch did not update']);
        }
        return response()->json(['status' => 'error', 'message' => 'Batch not found']);
    }

    public function batch_assignments($batch_id){
        // $batch = Batch::find($batch_id);
        $assignments = Assignment::where('batch_id', $batch_id)->get();

        // dd($assignments);
        // $course = $batch->course;
        $batch = Batch::with('unit_of_competency.lesson.assignment')->where('id', $batch_id)->first();
        
        // Get all lessons
        $all_lessons = Course::findOrFail($batch->course->id)
        ->batches()
        ->join('unit_of_competencies', 'batches.id', '=', 'unit_of_competencies.batch_id')
        ->join('lessons', 'unit_of_competencies.id', '=', 'lessons.unit_of_competency_id')
        ->select('lessons.title')
        ->distinct()
        ->get()
        ->groupBy(function($item) {
            return strtolower($item->title);
        })
        ->map(function($items) {
            return $items->first()->title; 
        })
        ->values(); 

        // Get all UC
        $all_ucs = Course::findOrFail($batch->course->id)
            ->batches()
            ->join('unit_of_competencies', 'batches.id', '=', 'unit_of_competencies.batch_id')
            ->select('unit_of_competencies.title')
            ->distinct()
            ->get()
            ->groupBy(function($item) {
                return strtolower($item->title);
            })
            ->map(function($items) {
                return $items->first()->title; 
            })
            ->values(); 

        // dd($all_ucs);

        $temp_files = TempAssignment::where('batch_id',$batch_id)->get();
            // dd($batch);
        return view('instructor.batch_assignments', compact('batch', 'assignments', 'all_lessons', 'all_ucs', 'temp_files'));
    }

    public function batch_attendance($batch_id){
        $batch = Batch::find($batch_id);
        $attendances = Attendance::where('batch_id', $batch_id)->get();
        $batch_students = $batch->enrollee;
        $students = $batch_students->sortBy(function($batch_student) {
            return $batch_student->user->lname;
        });
        // dd($students);
        return view('instructor.batch_attendance', compact('batch', 'attendances', 'students'));
    }

    //Replaced by list_turn_ins
    public function review_turn_ins($assignment_id){
        $assignment = Assignment::find($assignment_id);
        $batch = Batch::find($assignment->batch_id);
        $students = Enrollee::whereHas('batch', function($query) {
            $query->whereNull('completed_at');
        })
        ->where('batch_id', $batch->id)
        ->get();
        return view('instructor.review_turn_ins', compact('assignment', 'batch', 'students'));
    }

    public function list_turn_ins($assignment_id){
        $assignment = Assignment::where('id', $assignment_id)->first();
        $batch = Batch::with('unit_of_competency.lesson.assignment.assignment_files')->where('id', $assignment->batch_id)->first();

        $students = Enrollee::where('batch_id', $batch->id)
        ->with([
            'enrollee_turn_in' => function ($q) use($assignment_id) {
                $q->where('assignment_id', $assignment_id)
                ->with(['turn_in_files', 'turn_in_links']);
            }, // Get turn-in files directly related to the enrollee's turn-ins
            'user', 
            'enrollee_grades' => function ($q) use($assignment_id) {
                $q->where('assignment_id', $assignment_id);
            }
         ])
        ->get();

        // dd($students);
        
        // $turn_ins = TurnIn::whereIn('enrollee_id', $students->pluck('id')->filter())
        // ->where('assignment_id', $assignment_id)->get();
        // $turn_in_files = TurnInFile::whereIn('turn_in_id', $turn_ins->pluck('id')->filter())->get();
        
        // $student_grades = StudentGrade::whereIn('enrollee_id', $students->pluck('id')->filter())
        // ->where('assignment_id', $assignment_id)->get();

        // $turn_ins->map(function ($turn_in) use ($turn_in_files) {
        //     $turn_in->turn_in_files = $turn_in_files->where('turn_in_id', $turn_in->id)->values();
        //     return $turn_in;
        // });

        // $students->map(function ($student) use ($turn_ins, $student_grades) {
        //     $student->turn_ins = $turn_ins->where('enrollee_id', $student->id)->values();
        //     $student->grades = $student_grades->where('enrollee_id', $student->id)->values();
        //     return $student;
        // });

        // $turn_ins = TurnIn::where('assignment_id', $assignment_id)->get();
        // $user = collect();
        // $files = collect();
        // $grade = collect();

        // foreach($students as $student){
        //     $user = $user->merge([$student->user]);
        // }
        $assignment->unit_of_competency_id = $assignment->lesson->unit_of_competency_id;

        return view('instructor.list_turn_ins', compact('assignment', 'batch', 'students' ,'assignment'));
    }

    // Information Recording
    public function record_instructor(Request $request){
        $user = User::find(auth()->user()->id);

        if($user){
            $instructor = Instructor::where('user_id', $user->id)->first();
            $instructor->sex = $request->sex;
            $instructor->street = $request->street;
            $instructor->barangay = $request->barangay;
            $instructor->city = $request->city;
            $instructor->province = $request->province;
            $instructor->region = $request->region;
            $instructor->submitted = Carbon::now();
            $instructor->update();
            
            if($instructor)
                return back()->with(['status' => 'success','message' => ($user->sex == 'male' ? 'Mr. ' : 'Ms.').$user->lname.', your information successfully saved.', 'title' => 'Welcome to LSI eKonek']);
            
            return back()->with(['status' => 'error','message' => 'Error saving your informaation. Please try again.']);
        }else{
            return back()->with(['status' => 'error','message' => 'User not found']);
        }
    }

    public function upload_instructor_picture(Request $request){
        $attachments = $request->file($request->credential_type);
        $user = User::find(auth()->user()->id);
        // dd($attachments);
        if($request->has($request->credential_type)){
            $fileName = time(). '_' .  str_replace(' ', '_', $attachments->getClientOriginalName());
            $folder = uniqid('ass', true);
            $filePath = $attachments
            ->storeAs('instructor_files/'. $user->id .'/'.$folder , $fileName, 'public'); // Change 'uploads' to your desired directory
                
            // Get file type
            $fileType = $attachments->getClientMimeType();
                    
            // $temp_assignment = new TempTurnIn();
            $enrollee_file = Instructor::where('user_id', $user->id)->first();
            if(!$enrollee_file){
                $enrollee_file = new Instructor();
                $enrollee_file->user_id = $user->id;
                $enrollee_file->folder = $folder;
                $enrollee_file->id_picture = $fileName;
                $enrollee_file->save();
            }else{
                $enrollee_file->user_id = $user->id;
                $enrollee_file->folder = $folder;
                $enrollee_file->id_picture = $fileName;
                $enrollee_file->update();
            }
            return $folder;
        }
    }

    public function revert_instructor_picture(Request $request) {
        $instructor = Instructor::where('folder', $request->getContent())->first();
        $instructor_id = $instructor->id;

        if ($instructor) {
            $path = 'instructor_files/'. $instructor->user_id .'/'.$instructor->folder .'/' . $instructor->id_picture;
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                return response()->json(['error' => 'File does not exist'], 404);
            }

            $directoryPath = dirname($path);

            if (count(Storage::allFiles($directoryPath)) === 0) {
                Storage::deleteDirectory($directoryPath);
            }
            $instructor->folder = null;
            $instructor->id_picture = null;
            $instructor->update();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['error' => 'File not found'], 404);
    }

    public function load_instructor_picture($source) {
        $instructor = Instructor::where('id', $source)->first();
        $path = new File(Storage::path('instructor_files/'. $instructor->user_id.'/'.$instructor->folder.'/'. $instructor->id_picture));
        $headers = [
            // 'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="'.$instructor->id_picture.'"',
        ];
        if($instructor){
            return response()->file($path, $headers);
        }

        return response()->json('no file');   
    }

    public function delete_instructor_picture($source){
        $instructor = Instructor::where('id', $source)->first();
        
        if ($instructor) {
            $path = 'instructor_files/'. $instructor->user_id.'/'.$instructor->folder.'/'. $instructor->id_picture;
            
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                return response()->json(['error' => 'File does not exist'], 404);
            }

            $directoryPath = dirname($path);

            if (count(Storage::allFiles($directoryPath)) === 0) {
                Storage::deleteDirectory($directoryPath);
            }
            $instructor->folder = null;
            $instructor->id_picture = null;
            $instructor->update();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['error' => 'File not found'], 404);
    }

    // Posting
    public function batch_posts($id){
        $user = auth()->user();
        $batch = Batch::findOrFail(decrypt($id));
        $posts = $batch->post()->withCount('comments')->get();
        $course = $batch->course;
        // $lessons = $batch->lesson;

        $files = collect(); 

        foreach ($posts as $post) {
            $post->formatted_created_at = Carbon::parse($post->created_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s');
            $files = $files->merge($post->files);
        }

        $temp_files = TempFile::where('batch_id', $batch->id)->get();

        // dd($posts);

        return view('instructor.batch_posts', compact('batch', 'posts', 'files', 'temp_files'));
    }

    public function post(Request $request){

        $message = $request->input('message');
        $post_id = $request->post_id;
        $Messagecontent = strip_tags(html_entity_decode($message));

        // dd($Messagecontent);
        if($Messagecontent == ''){
            $message = null;
        }

        if(!$post_id){
            $post = new Post();
            $post->batch_id = $request->input('batch_id');
            $post->description = $message;
            $post->save();
            $statusMessage = ['status' => 'success', 'message' => 'The post has been uploaded successfully.', 'title' => 'Post Upload'];
        }else{
            $post = Post::find($post_id);
            $post->description = $message;
            $post->touch();
            $statusMessage = ['status' => 'success', 'message' => 'The post has been updated successfully.', 'title' => 'Post Update'];

        }

        $files = $request->file;
        $uploadedFileIds = array();
        if($files){
            foreach ($files as $file) {
                $query = TempFile::query();
                if(is_numeric($file))
                    $temp_file = $query->find($file);
                else
                    $temp_file = $query->where('folder', $file)->first();

                
                if($temp_file){
                    Storage::copy(
                        'uploads/'. $request->batch_id .'/'.'temp/' . $file . '/' . $temp_file->filename,
                        'uploads/' . $request->batch_id . '/' . $post->id . '/' . $temp_file->filename
                    );
                    
                    $fileEntry = new Files();
                    $fileEntry->post_id = $post->id; // Assuming you have $postId available
                    $fileEntry->folder = $temp_file->folder;
                    $fileEntry->filename = $temp_file->filename;
                    $fileEntry->file_type = $temp_file->file_type;
                    $fileEntry->save();
                    array_push($uploadedFileIds, $fileEntry->id);

                    $file_path = 'uploads/'. $request->batch_id .'/'.'temp/' . $file . '/' . $temp_file->filename;
                    $directory = dirname($file_path);
                    Storage::delete($file_path);
                    Storage::deleteDirectory($directory);
                    
                    $temp_file->delete();
                }else{
                    // $file = Files::where('folder', $file)->first();
                    array_push($uploadedFileIds, $file);
                }
            }
            
            
            $currentFileIds = Files::where('post_id', $post->id)->pluck('id')->toArray();
            $fileIdsToDelete = array_diff($currentFileIds, $uploadedFileIds);

            if (!empty($fileIdsToDelete)) {
                Files::whereIn('id', $fileIdsToDelete)->delete();
            }
        }

        return back()->with($statusMessage);

    }

    public function upload_temp_post_files(Request $request){
        // return $request->file('filepond');
        $attachments = $request->file('file');
        foreach ($attachments as $attachment) {
            if($request->has('file')){
                $fileName = time(). '_' . auth()->user()->id . '_' . str_replace(' ', '_', $attachment->getClientOriginalName());
                $folder = uniqid('ass', true);
                $filePath = $attachment->storeAs('uploads/'. $request->batch_id .'/'.'temp/' . $folder, $fileName, 'public'); // Change 'uploads' to your desired directory
                    
                // Get file type
                $fileType = $attachment->getClientMimeType();
                        
                $temp_file = new TempFile();
                $temp_file->batch_id = $request->batch_id;
                $temp_file->folder = $folder;
                $temp_file->filename = $fileName;
                $temp_file->file_type = $fileType;
                $temp_file->save();   
                return $folder;
            }
        }
        
    }

    public function revert_post_files(Request $request){
        $file = TempFile::where('folder', $request->getContent())->first();
        
        if ($file) {
            $path = 'uploads/'. $file->batch_id .'/'.'temp/' . $file->folder.'/' . $file->filename;
            
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                return response()->json(['error' => 'File does not exist'], 404);
            }

            $directoryPath = dirname($path);

            if (count(Storage::allFiles($directoryPath)) === 0) {
                Storage::deleteDirectory($directoryPath);
            }
            $file->delete();
            return response()->json(['success' => $path]);
        }
    
        return response()->json(['error' => 'File not found'], 404);
    }

    public function load_post_files($action, $batch_id, $source) {
        $batch = Batch::where('id', decrypt($batch_id))->first();

        if($action == 'create'){
            $file = TempFile::where('id', $source)->first();

            if($file){
                $path = public_path('storage/uploads/'. $batch->id . '/' . 'temp/' . $file->folder .'/' . $file->filename);
                $headers = [
                    'Content-Disposition' => 'inline; filename="'.$file->filename.'"',
                ];
                return response()->file($path, $headers);
            }
        }else{

            $file = Files::where('id', $source)->first();

            if($file){
                $path = new File(Storage::path('uploads/'. $batch->id . '/' . $file->post_id  .'/' . $file->filename));
                $headers = [
                    'Content-Disposition' => 'inline; filename="'.$file->filename.'"',
                ];
                return response()->file($path, $headers);
            }
        }
        
        return response()->json('no file');   
        // dd($source);
    }

    public function delete_post_files($batch_id, $id){        
        $file = TempFile::find($id);        
        
        if ($file) {
            $path = 'uploads/'. decrypt($batch_id) . '/' . 'temp/' . $file->folder .'/' . $file->filename;
            
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                return response()->json(['error' => 'File does not exist'], 404);
            }

            $directoryPath = dirname($path);

            if (count(Storage::allFiles($directoryPath)) === 0) {
                Storage::deleteDirectory($directoryPath);
            }
            $file->delete();
            return response()->json(['success' => true]);
        }
        
        // Removal of uploaded files
        $file = Files::find($id);  

        if($file){
            return response()->json(['success temporary remove' => true]);
        }
        
        // if($file){
        //     $path = 'uploads/'. decrypt($batch_id) . '/' . $file->post_id .'/' . $file->filename;
            
        //     if (Storage::exists($path)) {
        //         Storage::delete($path);
        //     } else {
        //         return response()->json(['error' => 'File does not exist'], 404);
        //     }

        //     $directoryPath = dirname($path);

        //     if (count(Storage::allFiles($directoryPath)) === 0) {
        //         Storage::deleteDirectory($directoryPath);
        //     }
        //     $file->delete();
        //     return response()->json(['success' => true]);
        // }
        
        return response()->json(['error' => 'File not found'], 404);
    }

    public function delete_post(Request $request){
        $post_id = $request->post_id;
        $post = Post::find($post_id);

        if($post){
            $post->delete();
            return back()->with(['status' => 'success', 'message' => 'The post has been deleted successfully.', 'title' => 'Post Deletion']);
        }else{
            return back()->with(['status' => 'error', 'message' => 'There was an error deleting the post.', 'title' => 'Post Deletion Error']);
        }

    }

    // Assignment File Upload (FilePond)
    public function temp_upload_assignment(Request $request){
        // dd($request);
        $attachments = $request->file('assignment_files');

        foreach ($attachments as $attachments) {
            if($request->has('assignment_files')){
                $fileName = time(). '_' . auth()->user()->id . '_' . str_replace(' ', '_', $attachments->getClientOriginalName());
                $folder = uniqid('ass', true);
                $filePath = $attachments->storeAs('assignments/'. $request->batch_id .'/'.'temp/' . $folder, $fileName, 'public'); // Change 'uploads' to your desired directory
                    
                // Get file type
                $fileType = $attachments->getClientMimeType();
                        
                $temp_assignment = new TempAssignment();
                $temp_assignment->batch_id = $request->batch_id;
                $temp_assignment->folder = $folder;
                $temp_assignment->filename = $fileName;
                $temp_assignment->file_type = $fileType;
                $temp_assignment->save();   
                return $folder;
            }
        }
            
        return '';
    }
    
    public function post_assignment(Request $request){
        $assignment_details = $request->only([
            'batch_id',
            'title',
            'description',
            'due_date',
            'due_hour',
        ]);
        
        if(!isset($request->set_due)){
            $assignment_details['due_date'] = null;
            $assignment_details['closing'] = 0;

            // dd('Hello');
        }else{
            $assignment_details['due_date'] = date('Y-m-d', strtotime($assignment_details['due_date']));
            $assignment_details['closing'] = $request->input('closing') ? 1 : 0;

        }

        $assignment_details['points'] = $request->max_point;
        
        if($request->lesson != null){
            $assignment_details['lesson_id'] = $request->lesson;
        }else{
            $uc = UnitOfCompetency::where('batch_id', $request->batch_id)->first();
            if(!$uc){
                $uc = new UnitOfCompetency();
                $uc->batch_id = $request->batch_id;
                $uc->title = $request->batch_id;
                $uc->save();

                $lesson = new Lesson();
                $lesson->unit_of_competency_id = $uc->id;
                $lesson->title = $uc->id;
                $lesson->save();
            }else{
                $lesson = Lesson::where('unit_of_competency_id', $uc->id)->first();
            }

            $assignment_details['lesson_id'] = $lesson->id;        
        }

        $batch_id = $request->batch_id;
        $batch_name = Batch::where('id', $batch_id)->select('course_id', 'name')->first();

        if($request->assignment_id != null){
            $assignment = Assignment::where('id', $request->assignment_id)->first();
            $subject = 'Assignment Updated';
            $batch = $batch_name->course->code.'-'.$batch_name->name.' | Assignment Updated';
        }else{
            $assignment = new Assignment();
            $subject = 'New Assignment Posted';
            $batch = $batch_name->course->code.'-'.$batch_name->name.' | New Assignment Posted';
        }

        $assignment->fill($assignment_details);
        $assignment->save();
        
        // dd($temp_assignment);
        if($request->assignment_files){
            foreach($request->assignment_files as $folder){
                if(!is_numeric($folder)){
                    $temp_assignment = TempAssignment::where('folder', $folder)->first();
                    // Storage::copy('assignments/temp/' . $temp_assignment->folder . '/'. $temp_assignment->filename, 'assignments/'.$request->batch_id.'/'. $assignment->id .'/'. $temp_assignment->filename  );
                    
                    Storage::copy(
                        'assignments/'. $request->batch_id .'/'.'temp/' . $folder . '/' . $temp_assignment->filename,
                        'assignments/' . $request->batch_id . '/' . $assignment->id . '/' . 'assignment_files/' . $temp_assignment->filename
                    );
                    
                    // $filePath = $folder->storeAs('assignment/'.$request->batch_id.'/', $fileName, 'public'); // Change 'uploads' to your desired directory
                            
                    $fileEntry = new AssignmentFile();
                    $fileEntry->assignment_id = $assignment->id; // Assuming you have $postId available
                    // $fileEntry->path = 'assignments/' . $request->batch_id . '/' . $assignment->id . '/' . 'assignment_files/' . $temp_assignment->filename;
                    $fileEntry->folder = $temp_assignment->folder;
                    $fileEntry->filename = $temp_assignment->filename;
                    $fileEntry->file_type = $temp_assignment->file_type;
                    $fileEntry->save();

                    Storage::deleteDirectory('assignments/'. $request->batch_id .'/'.'temp/' . $temp_assignment->folder);
                    $temp_assignment->delete();
                }
            }
        }

        $enrollees = Enrollee::where('batch_id', $request->batch_id)
        ->with(['user'])->get();
        $title = $assignment->title;
        $instruction = $assignment->description;

        // Collect all device tokens into an array
        // $deviceTokens = [];
        // foreach ($enrollees as $enrollee) {
        //     foreach ($enrollee->user->device_tokens as $deviceToken) {
        //         $deviceTokens[] = $deviceToken->device_token; // Assuming 'token' is the field name in device_tokens
        //     }
        // }

        $emails = [];
        foreach ($enrollees as $enrollee) {
            $emails[] = $enrollee->user->email;
        }

        // dd($emails);
        $data = [
            'subject' => $subject,
            'batch' => $batch,
            'title' => $title,
            'link' => route('view_assignment', ['id' => $assignment->id])
        ];
        Mail::to($emails)->send(new AssignmentMail($data));
        
        // if (!empty($deviceTokens)) {
        //     // dd($deviceTokens);
        //     NotificationSendController::sendAppNotification($deviceTokens, $title, $body, null);
        // } else {
        //     return response()->json(['message' => 'No device tokens found for this batch.'], 404);
        // }


        return redirect()->back()->with('success', 'Assigned successfully.');;
    }

    public function delete_assignment(Request $request){
        $assignment = Assignment::find($request->assignment_id);
        
        if($assignment){
            $assignment->delete();
            $batch_id = $assignment->batch_id;
            $assignments = Assignment::where('batch_id', $batch_id)->get();
            // $course = $batch->course;
            $batch = Batch::with('unit_of_competency.lesson.assignment')->where('id', $batch_id)->first();
            
            // Get all lessons
            $all_lessons = Course::findOrFail($batch->course->id)
            ->batches()
            ->join('unit_of_competencies', 'batches.id', '=', 'unit_of_competencies.batch_id')
            ->join('lessons', 'unit_of_competencies.id', '=', 'lessons.unit_of_competency_id')
            ->select('lessons.title')
            ->distinct()
            ->get()
            ->groupBy(function($item) {
                return strtolower($item->title);
            })
            ->map(function($items) {
                return $items->first()->title; 
            })
            ->values(); 
    
            // Get all UC
            $all_ucs = Course::findOrFail($batch->course->id)
                ->batches()
                ->join('unit_of_competencies', 'batches.id', '=', 'unit_of_competencies.batch_id')
                ->select('unit_of_competencies.title')
                ->distinct()
                ->get()
                ->groupBy(function($item) {
                    return strtolower($item->title);
                })
                ->map(function($items) {
                    return $items->first()->title; 
                })
                ->values(); 
    
            // dd($all_lessons);
    
            $temp_files = TempAssignment::where('batch_id',$batch_id)->get();
                // dd($batch);
                $notif = [
                    'status' => 'success',
                    'message' => 'Assignment deleted successfully'
                ];
            return redirect()->route('batch_assignments', ['batch_id' => $assignment->batch_id])->with($notif);
        }
        $notif = [
            'status' => 'error',
            'message' => 'Assignment not found'
        ];
        return back()->with($notif);
            
    }

    public function get_assignment_files($batch_id) {
        $temp_assignment = TempAssignment::where('batch_id',$batch_id)
        ->get();
        
        if($temp_assignment){
            return response()->json($temp_assignment);
        }

        return response()->json('no turn in yet');
    }

    public function load_assignment_files($batch_id,  $source){
        $file = TempAssignment::where('id', $source)->first();
        
        if ($file) {
            $filePath = new File(Storage::path('assignments/' . $batch_id . '/' . 'temp/'. $file->folder .'/'. $file->filename));
            $headers = [
                'Content-Disposition' => 'inline; filename="'.$file->filename.'"',
            ];
            return response()->file($filePath, $headers);
        }

        return response()->json($file);
    }

    public function revert_assignment_file(Request $request){
        $file = TempAssignment::where('folder', $request->getContent())->first();
        // $turn_in = TurnIn::find($file->turn_in_id);
        // $assignment = Assignment::find($turn_in->assignment_id);  
        
        if ($file) {
            $path = 'assignments/'. $file->batch_id .'/'.'temp/' . $file->folder.'/' . $file->filename;
            
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                // Log::info('Directory deleted: ' . $path);

                return response()->json(['error' => 'File does not exist'], 404);
            }

            $directoryPath = dirname($path);

            if (count(Storage::allFiles($directoryPath)) === 0) {
                Storage::deleteDirectory($directoryPath);
            }
            $file->delete();
            return response()->json(['success' => $path]);
        }
    
        return response()->json(['error' => 'File not found'], 404);
    }

    public function delete_assignment_file($batch_id, $id){        
        $file = TempAssignment::find($id);        
        
        if ($file) {
            $path = 'assignments/'. $file->batch_id .'/'.'temp/' . $file->folder.'/' . $file->filename;
            
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                return response()->json(['error' => 'File does not exist'], 404);
            }

            $directoryPath = dirname($path);

            if (count(Storage::allFiles($directoryPath)) === 0) {
                Storage::deleteDirectory($directoryPath);
            }
            $file->delete();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['error' => 'File not found'], 404);
    }

    public function get_assignment($id){
        $assignment = Assignment::find($id);
        if($assignment->due_date != null){
            $assignment->due_date = Carbon::createFromFormat('Y-m-d', $assignment->due_date)->format('m/d/Y');
        }
        return response()->json($assignment);
    }

    public function get_uploaded_assignment_files($assignment_id, $file_id){
        $file = AssignmentFile::where('id',$file_id)->first();
        
        if($file){
            $filePath = public_path('storage/assignments/' . $file->assignment->batch_id . '/'. $assignment_id .'/' . 'assignment_files/'. $file->filename);
            $headers = [
                'Content-Disposition' => 'inline; filename="'.$file->filename.'"',
            ];
            return response()->file($filePath, $headers);
        }

        return response()->json('no turn in yet');
    }

    public function delete_uploaded_assignment_file($assignment_id, $id){        
        $file = AssignmentFile::find($id);  
        $assignment = Assignment::where('id', $assignment_id)->first();      
        
        if ($file) {
            $path = 'assignments/'. $assignment->batch_id . '/' . $assignment_id . '/'.'assignment_files/' . $file->filename;
            
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                return response()->json(['error' => 'File does not exist'], 404);
            }

            $directoryPath = dirname($path);

            if (count(Storage::allFiles($directoryPath)) === 0) {
                Storage::deleteDirectory($directoryPath);
            }
            $file->delete();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['error' => 'File not found'], 404);
    }

    public function edit_assignment(Request $request){
        
    }

    public function assignment_toggle(Request $request){
        $assignment = Assignment::where('id',$request->input('assignment_id'))->first();
        $assignment->closed = !$assignment->closed;

        if($assignment->closing == true && $assignment->closed == false){
            $assignment->closing = false;
        }
        $assignment->save();

        return response()->json(['status' => 'success', 'available' => !$assignment->closed]);
    }

    // Lesson
    public function add_lesson(Request $request) {
        $batch = Batch::findOrFail($request->batch_id);
        $course_structure = $batch->course->structure;
        $lessons = new Lesson();

        if($course_structure == "big"){
            $lessons->unit_of_competency_id = $request->uc_id;
        }else{
            $uc = UnitOfCompetency::where('batch_id', $batch->id)->first();

            if(!$uc){
                $uc = new UnitOfCompetency();
                $uc->batch_id = $batch->id;
                $uc->title = $batch->id;
                $uc->save();
            }

            $lessons->unit_of_competency_id = $uc->id;
        } 

        $lessons->title = $request->lesson_title;
        $lessons->save();

        if($lessons){
            return back()->with(['status' => 'success', 'message' => 'The lesson '.$lessons->title.' has been added.' , 'title' => 'Add Lesson']);
        }

        return back()->with(['status' => 'error', 'message' => 'Unable to add the lesson '.$lessons->title.'. Please try again later.' , 'title' => 'Add Lesson']);
    }

    public function get_lessons(Request $request){
        $lessons = Lesson::where('batch_id', $request->batch_id)->get();
        $lessons = [
            'lessons' => $lessons,
            'lesson_count' => $lessons->count()
        ]; 
        return response()->json($lessons);
    }

    public function edit_lesson(Request $request){
        $lesson = Lesson::where('id', $request->lesson_id)->first();
        $lesson->title = $request->new_lesson_name;
        $lesson->save();

        if($lesson){
            return back()->with(['status' => 'success', 'message' => 'The lesson title has been successfully updated to: '.$lesson->title, 'title' => 'Change Lesson Name']);
        }

        return back()->with(['status' => 'error', 'message' => 'An error occurred while updating the lesson title. The title '.$lesson->title.' was not applied.','title' => 'Change Lesson Name']);

    }

    public function delete_lesson(Request $request){
        $record = Lesson::where('id', $request->lesson_id)->first();
        $record->delete();

        if($record){
            return back()->with(['status' => 'success', 'message' => 'The lesson '.$record->title.' has been deleted.' , 'title' => 'Delete Lesson']);
        }

        return back()->with(['status' => 'error', 'message' => 'Unable to delete the lesson '.$record->title.'. Please try again later.' , 'title' => 'Delete Lesson']);

    }

    // Unit of Competency
    public function add_uc(Request $request){
        $uc = new UnitOfCompetency();
        $uc->batch_id = $request->batch_id;
        $uc->title = $request->uc_title;
        $uc->save();

        if($uc){
            return back()->with(['status' => 'success', 'message' => $uc->title.' has been added.' , 'title' => 'Add Unit of Competency']);
        }

        return back()->with(['status' => 'error', 'message' => 'Unable to add '.$uc->title.'. Please try again later.' , 'title' => 'Add Unit of Competency']);
    }

    public function delete_uc(Request $request){
        $record = UnitOfCompetency::where('id', $request->uc_id)->first();
        $record->delete();

        if($record){
            return back()->with(['status' => 'success', 'message' => $record->title.' has been deleted.' , 'title' => 'Delete Unit of Competency']);
        }

        return back()->with(['status' => 'error', 'message' => 'Unable to delete '.$record->title.'. Please try again later.' , 'title' => 'Delete Unit of Competency']);

    }

    public function edit_uc(Request $request){
        $lesson = UnitOfCompetency::where('id', $request->uc_id)->first();
        $lesson->title = $request->new_uc_title;
        $lesson->save();

        if($lesson){
            return back()->with(['status' => 'success', 'message' => 'The lesson title has been successfully updated to: '.$lesson->title, 'title' => 'Change Lesson Name']);
        }

        return back()->with(['status' => 'error', 'message' => 'An error occurred while updating the lesson title. The title '.$lesson->title.' was not applied.','title' => 'Change Lesson Name']);

    }

    //Grading
    public function update_grade(Request $request){
        $student_grade = StudentGrade::where('enrollee_id', $request->enrollee_id)
        ->where('assignment_id', $request->assignment_id)
        ->where('batch_id', $request->batch_id)
        ->first();


        if($request->grade != 0 && $request->grade != null){
            if(!$student_grade){
                $student_grade = new StudentGrade();
                $student_grade->batch_id = $request->batch_id;
                $student_grade->assignment_id = $request->assignment_id;
                $student_grade->enrollee_id = $request->enrollee_id;
                $student_grade->grade = $request->grade;
                $student_grade->remark = $request->remark;
                $student_grade->save();
            }elseif($student_grade){
                $student_grade->grade = $request->grade;
                $student_grade->remark = $request->remark;
                $student_grade->save();
            }

        }elseif($request->grade == null || $request->grade == 0){
            if($student_grade){
                $student_grade->update(["grade" => 0, "remark" => $request->remark]);
            }
        }
        $trainee_name = Enrollee::where('id', $request->enrollee_id)->select(['id', 'user_id'])->with(['user:id,lname,fname'])->first();
        return response()->json(['status' => 'success', 'trainee' => $trainee_name, 'student_grade' => $student_grade]);

        // return response()->json(['status' => $request->grade]);
        // dd($request->grade);

        $user = collect();
        $user = $user->merge($student_grade->enrollee);
        $batch = Batch::where('id', $student_grade->batch_id)->first();
    }

    //Attendance
    public function save_attendance(Request $request) {
        // return response()->json($request->all());
        if($request->selected_id){
            $attendance = Attendance::where('id', $request->selected_id)->first();

            foreach($request->students as $student){
                $student_attendance = StudentAttendance::where('attendance_id', $attendance->id)
                ->where('enrollee_id', $student['id'])
                ->first();

                if ($student_attendance->status !== $student['status']) {
                    $student_attendance->status = $student['status'];
                    $student_attendance->save();
                }
            }

            return response()->json($attendance);
        }

        $attendance = new Attendance();
        $attendance->date = Carbon::parse($request->date);
        $attendance->batch_id = $request->batch_id;
        $attendance->mode = $request->mode;
        $attendance->save();

        foreach($request->students as $student){
            $student_attendance = new StudentAttendance();
            $student_attendance->attendance_id = $attendance->id;
            $student_attendance->enrollee_id = $student['id'];
            $student_attendance->status = $student['status'];
            $student_attendance->save();
        }
        return response()->json($attendance);
    }

    public function get_attendance_data(Request $request){
        $record = Attendance::where('id', $request->id)
        ->with('student_attendances')
        ->first();
        // dd($record);
        $data = null;
        $i = 0;
        foreach ($record->student_attendances as $student) {
            $i++;
            $data[$i] = [
                'id' => $student->enrollee_id,
                'first_name' => $student->enrollee->user->fname,
                'last_name' => $student->enrollee->user->lname,
                'status' => $student->status,
                'isChecked' => false
            ];
        }

        return response()->json($data);
    }

    public function comments($batch_id, $post_id){
        $batch = Batch::where('id', $batch_id)
        ->with([ 'only_post'=> function ($query) use ($post_id) {
            $query->where('id', $post_id)->with(['comments' => function ($q){
                $q->with(['user' => function ($q) {
                    $q->with([
                        'instructor_info','enrollee.enrollee_files'
                    ]);                    
                }]);
            }, 'files']);
        }])->first();

        $batch->only_post->formatted_created_at = Carbon::parse($batch->only_post->created_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s');
        
        if ($batch && $batch->only_post) {
            foreach ($batch->only_post->comments as $comment) {
                $comment->formatted_created_at = Carbon::parse($comment->created_at)
                    ->timezone('Asia/Manila')
                    ->format('Y-m-d H:i:s');
            }
        }

        return view('student.comments', compact('batch'));
    }


    public function add_comment(Request $request){
        $comment_text = $request->comment;

        $post = Post::where('id', $request->post_id)->first();

        if ($post) {
            $comment = new Comment();
            $comment->comment = $comment_text;
            $comment->post_id = $post->id;
            $comment->user_id = auth()->user()->id;
            $comment->save();

            if ($comment) {
                return back()->with(['status' => 'success', 'message' => 'Comment posted succesfully']);
            }else{
                return back()->with(['status' => 'error', 'message' => 'Error posting a comment']);
            }
        }else{
            return back()->with(['status'=> 'error', 'message' => 'Post does not exist']);
        }
    }

}
