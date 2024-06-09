<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\Batch;
use App\Models\Post;
use App\Models\User;
use App\Models\Enrollee;
use App\Models\Files;
use App\Models\Assignment;
use App\Models\AssignmentFile;
use App\Models\TempAssignment;
use App\Models\TurnInFile;
use App\Models\Lesson;
use App\Models\StudentGrade;
use App\Models\StudentAttendance;
use App\Models\Attendance;

class InstructorController extends Controller
{
    public function batch_list(){
        $user = auth()->user();
        $batch = $user->batch()->get();

        return view('instructor.batch_list', compact('batch'));
    }

    public function batch_posts($id){
        $user = auth()->user();
        $batch = Batch::findOrFail(decrypt($id));
        $posts = $batch->post;
        $course = $batch->course;
        $lessons = $batch->lesson;

        $files = collect(); 

        foreach ($posts as $post) {
            $files = $files->merge($post->files);
        }

        return view('instructor.batch_posts', compact('batch', 'posts', 'files', 'lessons'));
    }

    public function batch_assignments($batch_id){
        $batch = Batch::find($batch_id);
        $assignments = Assignment::where('batch_id', $batch_id)->get();
        $lessons = $batch->lesson;

        return view('instructor.batch_assignments', compact('batch', 'assignments', 'lessons'));
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
        $students = Enrollee::whereNull('completed_at')
        ->where('batch_id', $batch->id)
        ->get();
        return view('instructor.review_turn_ins', compact('assignment', 'batch', 'students'));
    }

    public function list_turn_ins($assignment_id, Request $request){
        $sort = 'lname';
        $sort_by = 'users.'.$sort;

        if($request->query('sort')){
            $sort = $request->query('sort');

            if($sort == 'lname' || $sort == 'fname'){
                $sort_by = 'users.'.$sort;
            }elseif($sort == 'turned_in'){
                $sort_by = 'turn_ins.'.$sort;
            }
        }

        $assignment = Assignment::find($assignment_id);
        $batch = Batch::find($assignment->batch_id);
        $students = Enrollee::leftJoin('users', 'enrollees.user_id', '=', 'users.id')
        ->leftJoin('turn_ins', function($join) use ($assignment) {
            $join->on('enrollees.user_id', '=', 'turn_ins.user_id')
                ->where('turn_ins.assignment_id', '=', $assignment->id);
        })
        ->leftJoin('student_grades', function($join) use ($assignment) {
            $join->on('enrollees.id', '=', 'student_grades.enrollee_id')
                ->where('student_grades.assignment_id', '=', $assignment->id);
        })
        ->where('enrollees.batch_id', $assignment->batch_id)
        ->whereNull('enrollees.completed_at')
        // ->select('enrollees.id as enrollee_id','enrollees.*', 'student_grades.*', 'users.*', DB::raw('IFNULL(turn_ins.id, 0) AS turn_in_id'), DB::raw('IFNULL(student_grades.id, 0) AS student_grades_id'))
        ->select('enrollees.id as enrollee_id','enrollees.*', 'student_grades.grade as grade', 'users.*', DB::raw('IFNULL(turn_ins.id, 0) AS turn_in_id'), DB::raw('IFNULL(student_grades.id, 0) AS student_grades_id'))
        ->orderBy($sort_by)
        ->get();

        $turn_in_files = TurnInFile::join('turn_ins', 'turn_in_files.turn_in_id', '=', 'turn_ins.id')
        ->where('turn_ins.assignment_id', $assignment->id)
        ->select('turn_ins.*', 'turn_in_files.*', 'turn_in_files.id as turn_in_files')
        ->get();
        
        // dd($turn_in_files);

        // foreach($students as $student)
        //     dd($student->grades->where('enrollee_id', $student->id)->first());
        return view('instructor.list_turn_ins', compact('assignment', 'batch', 'students', 'turn_in_files', 'sort'));
    }

    public function post(Request $request){

        $message = $request->input('message');
        $post = new Post();
        $post->batch_id = $request->input('batch_id');
        $post->description = $message;
        $post->save();

        $files = $request->file('file');

        if($files){
                foreach ($files as $file) {
                    $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    $filePath = $file->storeAs('uploads', $fileName, 'public'); // Change 'uploads' to your desired directory

                    // Get file type
                    $fileType = $file->getClientMimeType();
                        
                    $fileEntry = new Files();
                    $fileEntry->post_id = $post->id; // Assuming you have $postId available
                    $fileEntry->path = $filePath;
                    $fileEntry->file_type = $fileType;
                    $fileEntry->save();
                    print_r($post->id);
                }
            }
            

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Form submitted successfully.');
    }

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
        
        if($assignment_details['due_date'] != null){
            $assignment_details['due_date'] = date('Y-m-d', strtotime($assignment_details['due_date']));
        }

        $assignment_details['closing'] = $request->input('closing') ? 1 : 0;
        $assignment_details['points'] = $request->max_point;
        $assignment_details['lesson_id'] = $request->lesson;

        if($request->assignment_id != null){
            $assignment = Assignment::where('id', $request->assignment_id)->first();
        }else{
            $assignment = new Assignment();
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
        return redirect()->back()->with('success', 'Assigned successfully.');;
    }

    public function get_assignment_files($batch_id) {
        $temp_assignment = TempAssignment::where('batch_id',$batch_id)
        ->get();
        
        if($temp_assignment){
            return response()->json($temp_assignment);
        }

        return response()->json('no turn in yet');
    }

    public function load_assignment_files($batch_id,  $file_id){
        $file = AssignmentFile::where('id', $file_id)->first();
        
        if ($file) {
            $filePath = public_path('storage/assignments/' . $batch_id . '/' . 'temp/'. $file->folder .'/'. $file->filename);
            return response()->file($filePath);
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

    public function get_uploaded_assignment_files($assignment_id){
        $files = AssignmentFile::where('assignment_id',$assignment_id)->get();
        
        if($files){
            return response()->json($files);
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
        $assignment = Assignment::find($request->input('assignment_id'));
        $assignment->closed = !$assignment->closed;

        if($assignment->closing == true && $assignment->closed == false){
            $assignment->closing = false;
        }
        $assignment->save();

        return response()->json(['status' => 'success', 'available' => $assignment->available]);
    }

    public function add_lesson(Request $request) {
        $lessons = new Lesson();
        $lessons->batch_id = $request->batch_id;
        $lessons->title = $request->lesson;
        $lessons->save();
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
        $lesson = Lesson::where('id', $request->id)->first();
        $lesson->title = $request->title;
        $lesson->save();

        return response()->json(['status' => 'success', 'i' => $lesson]);

    }

    public function delete_lesson($lesson_id){
        $record = Lesson::where('id', $lesson_id)->first();
        $record->delete();

        return response()->json(['message' => $record]);
    }

    //Grading
    public function update_grade(Request $request){
        $student_grade = StudentGrade::where('enrollee_id', $request->enrollee_id)
        ->where('assignment_id', $request->assignment_id)
        ->where('batch_id', $request->batch_id)
        ->first();

        // dd($request);

        if($request->grade != 0 && $request->grade != null){
            if(!$student_grade){
                $student_grade = new StudentGrade();
                $student_grade->batch_id = $request->batch_id;
                $student_grade->assignment_id = $request->assignment_id;
                $student_grade->enrollee_id = $request->enrollee_id;
                $student_grade->grade = $request->grade;
                $student_grade->type = 'auto';
                $student_grade->save();
                return response()->json(['status' => 'update grade working']);
            }elseif($student_grade){
                $student_grade->grade = $request->grade;
                $student_grade->save();
            }
        }elseif($request->grade == null || $request->grade == 0){
            if($student_grade){
                $student_grade->delete();
            }
        }
        // return response()->json(['status' => $request->grade]);
        // dd($request->grade);
        
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
        $record = Attendance::where('id', $request->id)->first();
        $students = StudentAttendance::where('attendance_id', $record->id)->get();
        $enrollee = collect();
        $user = collect();

        foreach($students as $student){
            $enrollee = $enrollee->merge($student->enrollee);
            $user = $user->merge($student->enrollee->user);
        }

        // dd($students);
        $data;
        $i = 0;
        foreach ($students as $student) {
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
}
