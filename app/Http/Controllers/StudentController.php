<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Enrollee;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Post;
use App\Models\Files;
use App\Models\Education;
use App\Models\EnrolleeFile;
use App\Models\EnrolleeQrcode;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Assignment;
use App\Models\AssignmentFile;
use App\Models\TurnIn;
use App\Models\TurnInFile;
use App\Models\TurnInLink;
use App\Models\StudentGrade;
use App\Models\StudentAttendance;
use App\Models\Attendance;
use App\Models\Comment;

use App\Http\Controllers\NotificationSendController;

use Barryvdh\DomPDF\Facade\Pdf;

// Mailing
use App\Mail\Enrollment as EnrollmentMail;
use Illuminate\Support\Facades\Mail;

// file
use Symfony\Component\HttpFoundation\File\File;

class StudentController extends Controller
{
    public function enrolled_course()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $enrollee = Enrollee::where('user_id', $user_id)
            ->whereHas('batch', function($query) {
                $query->whereNull('completed_at');
            })
            ->with('enrollee_files')
            ->orderBy('created_at')
            ->first();

        if ($enrollee) {
            $course = $enrollee->course;
            $batch = $enrollee->batch;
            $posts = $batch ? $batch->post()->withCount('comments')->get() : '';
            $files = collect(); // Initialize an empty collection for files
            $instructor = collect();


            // Retrieve files for each post
            if($posts){
                $instructor = $instructor->merge($batch->instructor);
                foreach ($posts as $post) {
                    $post->formatted_created_at = Carbon::parse($post->created_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s');
                    $files = $files->merge($post->files);

                }
            }

            // dd($posts);
            return view('student.enrolled_course', compact('enrollee', 'course', 'batch', 'posts', 'files'));
        } else {
            $enrollee = Enrollee::where('user_id', $user_id)
            ->with('enrollee_files')
            ->orderBy('created_at')
            ->first();
            if($enrollee){
                // dd($enrollee);
                return view('student.enrolled_course', compact('enrollee'));
            }
            return redirect()->back()->with(['status' => 'info', 'message'=>'You are not currently enrolled in, or previously enrolled in, any program or course.']);
        }
    }

    public function enrolled_course_assignment()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $enrollee = Enrollee::where('user_id', $user_id)
            ->whereHas('batch', function($query) {
                $query->whereNull('completed_at');
            })->first();

        if ($enrollee) {
            $batch = Batch::with(['unit_of_competency.lesson.assignment' => function ($q) use($enrollee){
                $q->with(['turn_ins' => function ($q) use($enrollee){
                    $q->where('enrollee_id', $enrollee->id);
                }]);
            }, 'course'])->where('id', $enrollee->batch_id)->first();

            return view('student.enrolled_course_assignments', compact('enrollee', 'batch'));
        } else {
            return redirect()->route('home');
        }
    }

    public function enrolled_course_attendance(){
        $user = auth()->user();
        $user_id = $user->id;
        $enrollee = Enrollee::where('user_id', $user_id)
            ->whereHas('batch', function($query) {
                $query->whereNull('completed_at');
            })->first();

        $attendance_records = Attendance::where('batch_id', $enrollee->batch_id)
        ->with(['student_attendance' => function ($q) use($enrollee){
            $q->where('enrollee_id', $enrollee->id);
        }])
        ->get();
        // $student_attendance = StudentAttendance::whereHas('enrollee', function ($query) use ($enrollee) {
        //     $query->where('id', $enrollee->id);
        // })->get();

        // $attendance_records->map( function ($record) use ($student_attendance) {
        //     $record->student_attendance = $student_attendance->where('attendance_id', $record->id)->values();
        //     return $record;
        // });

        // dd($enrollee->id);    
        return view('student.enrolled_course_attendance', compact('attendance_records', 'enrollee'));
        
    }

    // Enrollment
    public function enroll($id)
    {
        $enrollee = Enrollee::where('user_id', auth()->user()->id)
        ->where('course_id', $id)
        ->with('enrollee_files')
        ->first();
        if ($enrollee) {
            $requiredCredentials = ['id_picture', 'valid_id_front', 'valid_id_back', 'diploma_tor', 'birth_certificate'];

            // Check if the user has uploaded all required credentials
            $uploadedCredentials = $enrollee->enrollee_files->pluck('credential_type')->toArray();

            $allCredentialsUploaded = !array_diff($requiredCredentials, $uploadedCredentials);

            $hasSubmitted = '';
            if ($allCredentialsUploaded) {
                
                $hasSubmitted = EnrolleeFile::where('enrollee_id', $enrollee->id)
                ->whereNotNull('submitted')
                ->first();
                
                $status = '';
                if($hasSubmitted){
                    if($hasSubmitted->batch == null || $hasSubmitted->batch->completed != null){
                        // Finished the course already
                        $status = 'completed';
                        $course_name = $hasSubmitted->enrollee->course->name;
                        return view('student.already_enrolled', compact('status', 'course_name'));
                    }
                    else{
                        if($hasSubmitted->batch_id == null){
                            if(!$hasSubmitted){
                                // redirect to passing of requirements
                                $enrollee = encrypt($enrollee->id);
                                return $this->enroll_requirements($enrollee);
                            }else{
                                // waitlisted
                                $status = 'waitlisted';
                                return $this->enrolled_course();
                            }
                        }
                        else{
                            // direct to ekonek
                            return $this->enrolled_course();
                        }
                    }
                }            
            }else{
                $enrollee = encrypt($enrollee->id);
                return $this->enroll_requirements($enrollee);
            }
            
        }
            return view('student.enroll', compact('id'));
            
    }

    public function enroll_save(Request $request)
    {   
        // dd($request->all());
        $data = $request->all();
        $data['user_id'] = decrypt($request->user_id);
        $data['course_id'] = decrypt($request->course_id);
        $data['birth_date'] = date('Y-m-d', strtotime($request->birth_date));
        $data['preferred_finish'] = date('Y-m-d', strtotime($request->preferred_finish));
        $data['preferred_start'] = date('Y-m-d', strtotime($request->preferred_start));
        $data['height'] = str_replace(' cm', '', $request->height);
        $data['weight'] = str_replace(' kg', '', $request->weight);
        $data['street'] = ucwords(strtolower($request->street));
        $data['citizenship'] = ucwords(strtolower($request->citizenship));
        $data['birth_place'] = ucwords(strtolower($request->birth_place));
        $data['religion'] = ucwords(strtolower($request->religion));

        $hasBatchId = Enrollee::where('user_id', $data['user_id'])
        ->where('course_id', $data['course_id'])
        ->whereNotNull('batch_id')
        ->first();
        
        if ($hasBatchId) {
            return response()->json(['enrolled' => true]);
            // return redirect()->route('already_enrolled');
        } else {
            Enrollee::updateOrCreate(
                [
                    'user_id' => $data['user_id'],
                    'course_id' => $data['course_id'],
                ],
                $data,
            );

            $enrollee = Enrollee::where('user_id', $data['user_id'])
                ->where('course_id', $data['course_id'])
                ->first();
            $enrollee_id = $enrollee->id;

            foreach ($request->education as $education) {
                $edu = new Education();
                $edu->enrollee_id = $enrollee->id;
                $edu->school_name = ucwords(strtolower($education['schoolName']));
                $edu->educational_level = $education['educationLevel'];
                $edu->school_year = $education['schoolYear'];
                $edu->degree = $education['degree'];
                $edu->minor = $education['minor'];
                $edu->major = $education['major'];
                $edu->units_earned = $education['unitsEarned'];
                $edu->honors_received = $education['honorsReceived'];
                $edu->save();
            }

            $data = [
                "name" => auth()->user()->fname.' '.auth()->user()->lname,
                "course_name" => Course::where('id', $data['course_id'])->pluck('name')->first()
            ];

            Mail::to(auth()->user()->email)->send(new EnrollmentMail($data));
            return response()->json(['id'=>encrypt($enrollee->id)]);
            // return redirect()->route('enroll_requirements', compact('enrollee'));
        }
    }

    public function enroll_requirements($enrollee)
    {
        // $enrollee = Enrollee::where('id', decrypt($enrollee))->first();
        $id_picture = EnrolleeFile::where('enrollee_id', decrypt($enrollee))->where('credential_type', 'id_picture')->first();
        $valid_id_front = EnrolleeFile::where('enrollee_id', decrypt($enrollee))->where('credential_type', 'valid_id_front')->first();
        $valid_id_back = EnrolleeFile::where('enrollee_id', decrypt($enrollee))->where('credential_type', 'valid_id_back')->first();
        $diploma_tor = EnrolleeFile::where('enrollee_id', decrypt($enrollee))->where('credential_type', 'diploma_tor')->first();
        $birth_certificate = EnrolleeFile::where('enrollee_id', decrypt($enrollee))->where('credential_type', 'birth_certificate')->first();
        return view('student.enroll_requirements', compact('enrollee', 'id_picture', 'valid_id_front', 'valid_id_back', 'diploma_tor', 'birth_certificate'));
    }

    public function upload_requirement(Request $request){
        $attachments = $request->file($request->credential_type);
        $course_id = decrypt($request->course_id);
        $enrollee_id = decrypt($request->enrollee_id);

        if($request->has($request->credential_type)){
            $fileName = time(). '_' .  str_replace(' ', '_', $attachments->getClientOriginalName());
            $folder = uniqid('ass', true);
            $filePath = $attachments
            ->storeAs('enrollee_files/'. $course_id . '/' . $enrollee_id . '/' . $request->credential_type .'/' . $folder, $fileName, 'public'); // Change 'uploads' to your desired directory
                
            // Get file type
            $fileType = $attachments->getClientMimeType();
                    
            // $temp_assignment = new TempTurnIn();
            $enrollee_file = new EnrolleeFile();
            $enrollee_file->enrollee_id = $enrollee_id;
            $enrollee_file->credential_type = $request->credential_type;
            $enrollee_file->folder = $folder;
            $enrollee_file->filename = $fileName;
            $enrollee_file->file_type = $fileType;
            $enrollee_file->submitted = null;
            $enrollee_file->save();   
            return $folder;
        }
    }

    public function revert_requirement(Request $request) {
        $file = EnrolleeFile::where('folder', $request->getContent())->first();
        $enrollee_id = $file->enrollee_id;
        $enrollee = Enrollee::where('id', $enrollee_id)->first();

        if ($file) {
            $path = 'enrollee_files/'.$enrollee->course_id . '/' . $enrollee_id . '/'. $file->credential_type .'/' . $file->folder .'/' . $file->filename;
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

    public function get_requirement($enrollee_id, $type){
        $file = EnrolleeFile::where('enrollee_id', decrypt($enrollee_id) )
        ->where('credential_type', $type)
        ->get();
        $enrollee = Enrollee::where('id', $file[0]->enrollee_id)->first();
        $file[0]->path = asset('storage/enrollee_files/'. $enrollee->course_id . '/' . $enrollee->id . '/' . 'id_pic/' . $file[0]->folder.'/'. $file[0]->filename, 'public');

        if($file){
            return response()->json($file);
        }

        return response()->json('no file');        
    }

    public function load_requirement($enrollee_id, $type, $source) {
        $file = EnrolleeFile::where('id', $source)
        ->get();
        $enrollee = Enrollee::where('id', $file[0]->enrollee_id)->first();
        $path = new File(Storage::path('enrollee_files/'. $enrollee->course_id . '/' . $enrollee->id . '/' . $type .'/' . $file[0]->folder.'/'. $file[0]->filename));
        $headers = [
            // 'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="'.$file[0]->filename.'"',
        ];
        if($file){
            return response()->file($path, $headers);
        }

        return response()->json('no file');   
    }

    public function delete_requirement($enrollee_id, $type, $source){
        $file = EnrolleeFile::where('id', $source)
        ->first();       
        
        $enrollee = Enrollee::where('id', $file->enrollee_id)->first();
        
        if ($file) {
            $path = 'enrollee_files/'. $enrollee->course_id . '/' . $enrollee->id . '/' . $type .'/' . $file->folder.'/'. $file->filename;
            
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                Log::info('Directory deleted: ' . $path);

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


    public function already_enrolled()
    {
        return view('student.already_enrolled');
    }

    public function check_user_requirements(Request $request){
        $requiredCredentials = ['valid_id_front', 'valid_id_back',  'birth_certificate', 'diploma_tor', 'id_picture'];

        $userHasAllCredentials = EnrolleeFile::where('enrollee_id', decrypt($request->enrollee_id))
        ->whereIn('credential_type', $requiredCredentials)
        ->select('enrollee_id')
        ->groupBy('enrollee_id')
        ->havingRaw('COUNT(DISTINCT credential_type) = ?', [count($requiredCredentials)])
        ->exists();

        // dd($userHasAllCredentials);

        return response()->json(['completed' => $userHasAllCredentials]);
    }
    
    public function enroll_requirements_save(Request $request)
    {
        $requiredCredentials = ['valid_id_front', 'valid_id_back',  'birth_certificate', 'diploma_tor', 'id_picture'];

        $userHasAllCredentials = EnrolleeFile::where('enrollee_id', decrypt($request->enrollee_id))
        ->whereIn('credential_type', $requiredCredentials)
        ->select('enrollee_id')
        ->groupBy('enrollee_id')
        ->havingRaw('COUNT(DISTINCT credential_type) = ?', [count($requiredCredentials)])
        ->exists();
        
        if(!$userHasAllCredentials){
            return redirect()->back()->with(['error' => 'incomplete']);
        }else{
            EnrolleeFile::where('enrollee_id', decrypt($request->enrollee_id))
            ->update(['submitted' => Carbon::now()]);
        }
    
        return redirect()->route('home');
        
    }
    
    public function course_completed()
    {
        $user = auth()->user();
        $completed = Enrollee::where('user_id', $user->id)
            ->whereHas('batch', function($query) {
                $query->whereNotNull('completed_at');
            })
            ->with(['course', 'batch'])
            ->get();

        $enrollee = Enrollee::where('user_id', $user->id)
            ->with('enrollee_files')
            ->orderBy('created_at')
            ->first();
        
        foreach ($completed as $e) {
            $e->has_passed = $e->hasPassedCourse();
            $e->overall_rating = $e->getOverallRating();
        }
        // dd($enrollee->hasPassedCourse());
            // dd($completed);
        return view('student.course_completed', compact('completed', 'enrollee'));
    }

    public function message($id)
    {
        $user = User::where('id', $id)->get();
        $userId1 = auth()->user()->id;
        $userId2 = $id;
        
        $conversation = Conversation::where(function ($query) use ($userId1, $userId2) {
            $query->where('user1_id', $userId1)->where('user2_id', $userId2);
        })
            ->orWhere(function ($query) use ($userId1, $userId2) {
                $query->where('user1_id', $userId2)->where('user2_id', $userId1);
            })
            ->first();

        if ($conversation) {
            $messages = $conversation->messages->reverse();
            return view('student.message', compact('user', 'conversation', 'messages'));
        } else {
            return view('student.message', compact('user', 'conversation'));
        }
    }

    public function message_list()
    {
        // $users = User::whereNot('id', auth()->user()->id)->get();

        $currentUserId = auth()->user()->id;

        $users = DB::select("SELECT DISTINCT *, users.id
        FROM users
        JOIN conversations ON users.id = conversations.user1_id OR users.id = conversations.user2_id
        WHERE (? IN (conversations.user1_id, conversations.user2_id)) AND users.id != ?",
            [$currentUserId, $currentUserId],
        );

        $all_users = User::whereNot('id', auth()->user()->id)->orderBy('fname')->orderBy('lname')->orderBy('role')->get();

        // print_r('<pre>');
        // print_r($users);
        return view('student.message_list', compact('users', 'all_users'));
    }

    public function send_message(Request $request)
    {
        // Validate the request data
        $validatedData = $request->all();

        // // Determine the conversation participants' IDs
        $userId1 = $validatedData['user1_id'];
        $userId2 = $validatedData['user2_id'];

        // Find or create the conversation
        $conversation = Conversation::where(function ($query) use ($userId1, $userId2) {
            $query->where('user1_id', $userId1)->where('user2_id', $userId2);
        })
            ->orWhere(function ($query) use ($userId1, $userId2) {
                $query->where('user1_id', $userId2)->where('user2_id', $userId1);
            })
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => $userId1,
                'user2_id' => $userId2,
            ]);
        }

        // // Create a new message instance
        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->sender_id = $userId1;
        $message->message_content = $validatedData['message_content'];
        // // Save the message
        $message->save();

        $receiver_name = User::where('id', $userId1)->first()->fname;
        $token = User::whereNotNull('device_token')->where('id', $userId2)->pluck('device_token')->all();

        $body = $message->message_content;
        if (strlen($message->message_content) > 40) {
            $body = substr($message->message_content, 0, 40) . "...";
        }

        NotificationSendController::sendAppNotification($token, $receiver_name, $body, null);
        // NotificationSendController::sendSmsNotification('09911354287', $body);

        // dd(route('message', $userId2));
        return response()->json(['message' => $token]);
    }

    public function get_messages($id)
    {
        $user = User::where('id', $id)->get();
        $userId1 = auth()->user()->id;
        $userId2 = $id;

        $conversation = Conversation::where(function ($query) use ($userId1, $userId2) {
            $query->where('user1_id', $userId1)->where('user2_id', $userId2);
        })
            ->orWhere(function ($query) use ($userId1, $userId2) {
                $query->where('user1_id', $userId2)->where('user2_id', $userId1);
            })
            ->first();

        if($conversation){
            $messages = $conversation->messages->reverse();
            return response()->json(['message' => $messages]);
        }
        
        return response()->json(['conversation' => $conversation]);

    }
    
    public function view_assignment($id){
        $user = auth()->user();
        $user_id = $user->id;
        $enrollee = Enrollee::where('user_id', $user_id)
            ->whereHas('batch', function($query) {
                $query->whereNull('completed_at');
            })->first();

        $course = $enrollee->course;
        $batch = $enrollee->batch;

        $assignment = Assignment::where('id', $id)->first();
        $student_grade = StudentGrade::where('assignment_id', $assignment->id)->where('enrollee_id', $enrollee->id)->first();
        return view('student.view_assignment', compact('enrollee', 'course','batch', 'assignment', 'student_grade'));
    }

    public function turn_in_files(Request $request) {
        $enrollee = Enrollee::where('user_id', auth()->user()->id)
            ->whereHas('batch', function($query) {
                $query->whereNull('completed_at');
            })
            ->first();

        $turn_in = TurnIn::where('assignment_id', $request->assignment_id)
        ->where('enrollee_id', $enrollee->id)
        ->first();

        if(!$turn_in){
            $turn_in = new TurnIn();
            $turn_in->assignment_id = $request->assignment_id;
            $turn_in->enrollee_id = $enrollee->id;
            $turn_in->save();
        }

        $attachments = $request->file('turn_in_attachments');

        foreach ($attachments as $attachments) {
            if($request->has('turn_in_attachments')){
                $fileName = time(). '_' . $enrollee->id . '_' . str_replace(' ', '_', $attachments->getClientOriginalName());
                $folder = uniqid('ass', true);
                $filePath = $attachments
                ->storeAs('assignments/'.$request->batch_id . '/' . $request->assignment_id . '/'. $enrollee->id .'/' . $folder, $fileName, 'public'); // Change 'uploads' to your desired directory
                    
                // Get file type
                $fileType = $attachments->getClientMimeType();
                        
                // $temp_assignment = new TempTurnIn();
                $temp_assignment = new TurnInFile();
                $temp_assignment->turn_in_id = $turn_in->id;
                $temp_assignment->folder = $folder;
                $temp_assignment->filename = $fileName;
                $temp_assignment->file_type = $fileType;
                $temp_assignment->save();   
                return $folder;
            }
        }
            
        return '';
    }

    public function get_files($assignment_id){
        $enrollee = Enrollee::where('user_id', auth()->user()->id)
            ->whereHas('batch', function($query) {
                $query->whereNull('completed_at');
            })
            ->first();

        $turn_in = TurnIn::where('enrollee_id', $enrollee->id)
        ->where('assignment_id', $assignment_id)
        ->first();

        if($turn_in){
            $files = TurnInFile::where('turn_in_id', $turn_in->id)
            ->get();

            $links = TurnInLink::where('turn_in_id', $turn_in->id)->get();

            return response()->json(['files' => $files, 'links' =>$links]);
        }

        return response()->json(['files' => 'no files', 'links' => 'no links']);
    }
    
    public function load_files($batch_id, $assignment_id, $file_id){
        $file = TurnInFile::where('id', $file_id)->first();
        $turn_in = TurnIn::find($file->turn_in_id);
        
        if ($file) {
            $filePath = new File(Storage::path('assignments/'.$batch_id .'/' . $turn_in->assignment_id.'/'. $turn_in->enrollee_id .'/'.  $file->folder.'/'. $file->filename));
            $headers = [
                'Content-Disposition' => 'inline; filename="'.$file->filename.'"',
            ];
            return response()->file($filePath, $headers);
            // return response()->json($enrollee->id);
        }

        return response()->json('no file');
    }
    
    public function delete_file($batch_id, $assignment_id, $id){
        // dd($batch_id. $assignment_id. $id);
        $file = TurnInFile::where('id', $id)->first();
        $turn_in = TurnIn::find($file->turn_in_id);
        
        if ($file) {
            $path = '/assignments'.'/'.$batch_id .'/' . $assignment_id.'/'. $turn_in->enrollee_id .'/'.  $file->folder.'/'. $file->filename;
            
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
    
    public function revert(Request $request){
        // return $request->getContent();
        $file = TurnInFile::where('folder', $request->getContent())->first();
        $turn_in = TurnIn::find($file->turn_in_id);
        $batch_id = Enrollee::where('id',  $turn_in->enrollee_id)->pluck('batch_id')->first();
        
        if ($file) {
            $path = '/assignments'.'/'.$batch_id .'/' . $turn_in->assignment_id.'/'. $turn_in->enrollee_id .'/'.  $file->folder.'/'. $file->filename;
            
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

    public function turn_in_status(Request $request) {
        $enrollee = Enrollee::where('user_id', auth()->user()->id)
            ->whereHas('batch', function ($query) {
                $query->whereNull('completed_at');
            })
            ->first();
        
        $turn_in = TurnIn::where('assignment_id', $request->assignment_id)
            ->where('enrollee_id', $enrollee->id)
            ->first();
    
        $assignment = Assignment::find($request->assignment_id);
        $currentDateTime = Carbon::now();
        $currentDate = Carbon::today(); 
        
        $dueDateTime = null;
        if ($assignment->due_date && $assignment->due_hour) {
            $dueDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $assignment->due_date . ' ' . $assignment->due_hour);
        }
    
        $isClosed = $assignment->closed || ($dueDateTime && $currentDateTime->gt($dueDateTime) && $assignment->closing);
        
        if ($turn_in) {
            $isLate = ($turn_in->turned_in_date && $dueDateTime && $dueDateTime->lt(Carbon::parse($turn_in->turned_in_date)));
            if ($turn_in->turned_in) {
                return response()->json([
                    'status' => 'completed',
                    'assignment' => $isClosed ? 'closed' : 'open',
                    'late' => $isLate
                ]);
            } else {
                return response()->json([
                    'status' => 'pending',
                    'assignment' => $isClosed ? 'closed' : 'open',
                    'late' => $isLate
                ]);
            }
        } else {
            return response()->json([
                'status' => 'pending', 
                'assignment' => $isClosed ? 'closed' : 'open',
            ]);
        }
    }
    
    public function assignment_action(Request $request){
        $enrollee = Enrollee::where('user_id', auth()->user()->id)
            ->whereHas('batch', function($query) {
                $query->whereNull('completed_at');
            })
            ->first();
        
        $currentDate = Carbon::today();     
        $current = Carbon::now();     
        $assignment = Assignment::find($request->assignment_id);
        $turn_in = TurnIn::where('assignment_id', $assignment->id)
        ->where('enrollee_id', $enrollee->id)
        ->first();
        
        if (!$assignment->closing) {
            // If the assignment is not closing, check turn-in and return.
            $this->check_turn_in($request, $turn_in, $assignment, $enrollee->id);
            return response()->json(['action' => 'done']);
        }
        
        // Handle assignments with due dates.
        if ($assignment->due_date) {
            $dueDate = Carbon::createFromFormat('Y-m-d', $assignment->due_date);
            $dueHour = Carbon::createFromFormat('H:i:s', $assignment->due_hour);
        
            // Check if the current date is before or on the due date.
            if ($currentDate->lt($dueDate)) {
                // Before the due date, allow turn-in.
                $this->check_turn_in($request, $turn_in, $assignment, $enrollee->id);
                return response()->json(['action' => 'done']);
            }
        
            if ($currentDate->eq($dueDate)) {
                // On the due date, check the time.
                if ($current->lte($dueHour)) {
                    // Allow turn-in if it's before the due hour.
                    $this->check_turn_in($request, $turn_in, $assignment, $enrollee->id);
                    return response()->json(['action' => 'done']);
                }
        
                // After the due hour, assignment is closed.
                return response()->json(['assignment_status' => 'closed']);
            }
        
            // After the due date, assignment is closed.
            return response()->json(['assignment_status' => 'closed']);
        }
        
        // If no due date, allow turn-in.
        $this->check_turn_in($request, $turn_in, $assignment, $enrollee->id);
        return response()->json(['action' => 'done']);
    }

    public function upload_links(Request $request){
        $enrollee = Enrollee::where('user_id', auth()->user()->id)
            ->whereHas('batch', function($query) {
                $query->whereNull('completed_at');
            })
            ->first();

        $turn_in = TurnIn::where('assignment_id', $request->assignment_id)
        ->where('enrollee_id', $enrollee->id)
        ->first();

        DB::beginTransaction();

        try {
            if(!$turn_in){
                $turn_in = new TurnIn();
                $turn_in->assignment_id = $request->assignment_id;
                $turn_in->enrollee_id = $enrollee->id;
                $turn_in->save();
            }

            $links = $request->links;
            $error_links = 0;

            TurnInLink::where('turn_in_id', $turn_in->id)->delete();
            
            foreach ($links as $link) {
                if (!preg_match('/^https?:\/\//', $link['url'])) {
                    $link['url'] = 'https://' . $link['url'];
                }
            
                // Validate the link to check if it's a valid URL
                if (!filter_var($link['url'], FILTER_VALIDATE_URL)) {
                    $error_links++; // Increment the counter if the link is invalid
                    continue; // Skip this invalid link and move to the next
                }
                // Save the valid link to the database

                TurnInLink::create([
                    'turn_in_id' => $turn_in->id,
                    'link' => $link['url'],
                ]);
            }

            DB::commit();

            if ($error_links > 0) {
                return response()->json(['status' => 'warning', 'message' => "$error_links invalid links were skipped."]);
            } else {
                return response()->json(['status' => 'success', 'message' => 'All links saved successfully!']);
            }
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction in case of an error
    
            return response()->json(['status'=>'error', 'message' => 'Something went wrong: ' . $e->getMessage()]);
        }
        
    }

    private function check_turn_in($request, $turn_in, $assignment, $enrollee_id){
        if($turn_in){
            if(!$turn_in->turned_in){
                $turn_in->turned_in = true;

            }else{
                $turn_in->turned_in = false;
            }
            $turn_in->turned_in_date = Carbon::now();
            $turn_in->save();
        }else{
                $data = [
                    'assignment_id' => $request->assignment_id,
                    'enrollee_id' => $enrollee_id,
                    'turned_in' => true,
                    'turned_in_date' => Carbon::now()
                ];
                TurnIn::create($data);
            return response()->json(['created'=>'new turn in']);
        }
    }

    public function id_card($id){
        return view('student.id_card');
    }
    
    public function show_id_card(){
        $enrollee = Enrollee::where('user_id', auth()->user()->id)
        ->whereNotNull('batch_id')
        ->whereHas('batch', function($query) {
            $query->whereNull('completed_at')
            ->with('course');
        })
        ->with(['user', 'enrollee_files', ])
        ->first();

        $qr_code = EnrolleeQrcode::where('enrollee_id', $enrollee->id)->first();
        $id_path = $enrollee->enrollee_files->where('credential_type', 'id_picture') ->first(); 
        // dd($id_path);

        // $id_pic_path = asset('storage/enrollee_files/'. $enrollee->course_id . '/'. $enrollee->id .'/id_picture'.'/' . $id_pic->folder . '/'. $id_pic->filename, 'public');

        // $html = view('idcard', compact('id_pic_url', 'qr_code'))->render();
        // $qr_code_image = 'data:image/png;base64,' . base64_encode($qr_code->qr_code);

        $data = ['title' => 'Laravel PDF Example',
        'qr_code' => $qr_code,
        'batch' => $enrollee->course->code.'-'.$enrollee->batch->name,
        'id_path' => $id_path, 
        ];
        $pdf = Pdf::loadView('idcard', $data);
        $pdf->setPaper('A5');
    
        // Stream the PDF content to the browser
        return $pdf->stream($enrollee->user->lname.'_ID.pdf');
        
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

    public function enrollment(){
        $enrollments = Enrollee::where('user_id', auth()->user()->id)
        ->with(['course', 'batch', 'user', 'enrollee_files_submitted', 'enrollee_education'])
        ->orderBy('created_at')
        ->withTrashed()
        ->get();

        $enrollee = Enrollee::where('user_id', auth()->user()->id)
        ->with('enrollee_files')
        ->orderBy('created_at')
        ->first();

        return view('student.enrollment', compact('enrollments', 'enrollee'));
    }

    public function cancel_enrollment(Request $request){
        $enrollment = Enrollee::where('id', $request->enrollee_id)->first();

        if($enrollment){
            if($enrollment->delete()){
                return redirect()->back()->with(['status' => 'success', 'message' => 'Enrollment has been successfully cancelled']);
            }
            return redirect()->back()->with(['status' => 'error', 'message' => 'An error occurred while attempting to cancel the enrollment. Please try again later.']);
        }
        return redirect()->back()->with(['status' => 'error', 'message' => 'Enrollment not found. Please check the enrollment details and try again.']);

    }
}
