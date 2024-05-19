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
use App\Models\EnrolleeFiles;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Assignment;
use App\Models\AssignmentFile;
use App\Models\TurnIn;
use App\Models\TurnInFile;

use App\Http\Controllers\NotificationSendController;

class StudentController extends Controller
{
    public function enrolled_course()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $enrollee = Enrollee::where('user_id', $user_id)->first();
        if ($enrollee) {
            $course = $enrollee->course;
            $batch = $enrollee->batch;
            $posts = $batch->post;
            $files = collect(); // Initialize an empty collection for files

            // Retrieve files for each post
            foreach ($posts as $post) {
                $files = $files->merge($post->files);
            }
            // print_r('<pre>');
            // print_r($user_id);

            return view('student.enrolled_course', compact('enrollee', 'course', 'batch', 'posts', 'files'));
        } else {
            return redirect()->route('home');
        }
    }

    public function enrolled_course_assignment()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $enrollee = Enrollee::where('user_id', $user_id)->first();
        if ($enrollee) {
            $course = $enrollee->course;
            $batch = $enrollee->batch;
            $assignments = $batch->assignment;
            $files = collect(); // Initialize an empty collection for files

            // Retrieve files for each post
            foreach ($assignments as $assignment) {
                $files = $files->merge($assignment->assignment_files);
            }
            // print_r('<pre>');
            // print_r($user_id);
            // dd($files);
            return view('student.enrolled_course_assignments', compact('enrollee', 'course', 'batch', 'assignments', 'files'));
        } else {
            return redirect()->route('home');
        }
    }

    public function enroll($id)
    {
        $hasBatchId = Enrollee::where('user_id', auth()->user()->id)
            ->where('course_id', $id)
            ->whereNotNull('batch_id')
            ->first();

        $enrollee = Enrollee::where('user_id', auth()->user()->id)
        ->where('course_id', $id)
        ->first();

        if (isset($enrollee->id)) {
            $hasRequirements = EnrolleeFiles::where('enrollee_id', $enrollee->id)->exists();
        }

        if ($enrollee) {
            if (!$hasRequirements) {
                return view('student.enroll_requirements', compact('enrollee'));
            } else {
                return view('student.already_enrolled');
            }
        } else {
            return view('student.enroll');
        }
    }

    public function enroll_save(Request $request)
    {
        $data = $request->all();
        $data['birth_date'] = date('Y-m-d', strtotime($request->birth_date));
        $data['preferred_finish'] = date('Y-m-d', strtotime($request->preferred_finish));
        $data['preferred_start'] = date('Y-m-d', strtotime($request->preferred_start));
        $data['height'] = str_replace(' kg', '', $request->height);
        $data['weight'] = str_replace(' cm', '', $request->weight);
        $data['region'] = $request->region_name;
        $data['province'] = $request->province_name;
        $data['district'] = $request->district_name;
        $data['city'] = $request->city_name;
        $data['barangay'] = $request->barangay_name;

        // $data = $request->validate([
        //     'user_id' => 'required',
        //     'course_id' => 'required',
        //     'region' => 'required',
        //     'province' => 'required',
        //     'district' => 'required',
        //     'city' => 'required',
        //     'barangay' => 'required',
        //     'street' => 'required',
        //     'zip' => 'required',
        //     'sex' => 'required',
        //     'civil_status' => 'required',
        //     'employment_type' => 'required',
        //     'employment_status' => 'required',
        //     'birth_date' => 'required',
        //     'birth_place' => 'required',
        //     'citizenship' => 'required',
        //     'religion' => 'required',
        //     'height' => 'required',
        //     'weight' => 'required',
        //     'blood_type' => 'required',
        //     'sss' => 'required',
        //     'gsis' => 'required',
        //     'tin' => 'required',
        //     'disting_marks' => 'required',
        //     'preferred_schedule' => 'required',
        //     'preferred_start' => 'required',
        //     'preferred_finish',
        // ]);
        
        $hasBatchId = Enrollee::where('user_id', $data['user_id'])
        ->where('course_id', $data['course_id'])
        ->whereNotNull('batch_id')
        ->first();
        
        if ($hasBatchId) {
            return redirect()->route('already_enrolled');
        } else {
            Enrollee::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'course_id' => $request->course_id,
                ],
                $data,
            );

            $enrollee = Enrollee::where('user_id', $request->user_id)
                ->where('course_id', $request->course_id)
                ->first();
            $enrollee_id = $enrollee->id;

            $numberOfEduc = 0;
            foreach ($data as $key => $value) {
                $parts = explode('_', $key);

                if (count($parts) === 2 && $parts[0] === 'schoolName') {
                    $numberOfEduc++;
                }
            }

            for ($i = 1; $i <= $numberOfEduc; $i++) {
                $edu = [];
                foreach ($data as $key => $value) {
                    $parts = explode('_', $key);

                    if ($parts[0] === 'schoolName' && $parts[1] == $i) {
                        $edu['school_name'] = $value;
                    } elseif ($parts[0] === 'educationLevel' && $parts[1] == $i) {
                        $edu['educational_level'] = $value;
                    } elseif ($parts[0] === 'schoolYear' && $parts[1] == $i) {
                        $edu['school_year'] = $value;
                    }
                    // print_r('<pre>');
                    // print_r($edu);

                    if (array_key_exists('educational_level', $edu)) {
                        if ($edu['educational_level'] === 'Tertiary') {
                            if ($parts[0] === 'degree' && $parts[1] == $i) {
                                $edu['degree'] = $value;
                            } elseif ($parts[0] === 'minor' && $parts[1] == $i) {
                                $edu['minor'] = $value;
                            } elseif ($parts[0] === 'major' && $parts[1] == $i) {
                                $edu['major'] = $value;
                            } elseif ($parts[0] === 'unitsEarned' && $parts[1] == $i) {
                                $edu['units_earned'] = $value;
                            } elseif ($parts[0] === 'honorsReceived' && $parts[1] == $i) {
                                $edu['honors_received'] = $value;
                            }
                        }
                    }
                }
                $edu['enrollee_id'] = $enrollee_id;

                Education::create($edu);
            }

            return redirect()->route('enroll_requirements', compact('enrollee'));
        }
    }

    public function enroll_requirements($enrollee)
    {
        return view('student.enroll_requirements', compact('enrollee'));
    }

    public function already_enrolled()
    {
        return view('student.already_enrolled');
    }
    
    public function enroll_requirements_save(Request $request)
    {
        $request->all();
        $directory = 'enrollee_files/' . $request->enrollee_id;
        $path = [];
        foreach (['valid_id', 'diploma_tor', 'birth_certificate', 'id_picture'] as $name) {
            $file = $request->file($name);
            $extension = $file->getClientOriginalExtension();
            $path[$name] = $file->storeAs($directory, $name . '_' . $request->enrollee_id . '.' . $extension, 'public');
        }

        // print_r('<pre>');
        // print_r($request->enrollee_id);

        $enrollee_files = new EnrolleeFiles();
        $enrollee_files->enrollee_id = $request->enrollee_id;
        $enrollee_files->valid_id = $path['valid_id'];
        $enrollee_files->birth_certificate = $path['birth_certificate'];
        $enrollee_files->diploma_tor = $path['diploma_tor'];
        $enrollee_files->id_picture = $path['id_picture'];
        // Add any additional information you want to store
        $enrollee_files->save();

        return redirect()->route('home');
    }

    public function course_completed()
    {
        $user = auth()->user();
        $completed = Enrollee::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->get();
            
        return view('student.course_completed', compact('completed'));
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

        $receiver_name = User::where('id', $userId2)->first();
        $token = User::whereNotNull('device_token')->pluck('device_token')->all();

        $body = $message->message_content;
        if (strlen($message->message_content) > 40) {
            $body = substr($message->message_content, 0, 40) . "...";
        }

        NotificationSendController::sendNotification($token, $receiver_name, $body);

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

        $messages = $conversation->messages->reverse();
        return response()->json(['message' => $messages]);
    }
    
    public function view_assignment($id){
        $user = auth()->user();
        $user_id = $user->id;
        $enrollee = Enrollee::where('user_id', $user_id)->first();
        $course = $enrollee->course;
        $batch = $enrollee->batch;

        $assignment = Assignment::where('id', $id)->first();
        return view('student.view_assignment', compact('enrollee', 'course','batch', 'assignment'));
    }

    public function turn_in_files(Request $request) {
        $turn_in = TurnIn::where('assignment_id', $request->assignment_id)
        ->where('user_id', auth()->user()->id)
        ->first();

        if(!$turn_in){
            $turn_in = new TurnIn();
            $turn_in->assignment_id = $request->assignment_id;
            $turn_in->user_id = auth()->user()->id;
            $turn_in->save();
        }

        $attachments = $request->file('turn_in_attachments');

        foreach ($attachments as $attachments) {
            if($request->has('turn_in_attachments')){
                $fileName = time(). '_' . auth()->user()->id . '_' . str_replace(' ', '_', $attachments->getClientOriginalName());
                $folder = uniqid('ass', true);
                $filePath = $attachments
                ->storeAs('assignments/'.$request->batch_id . '/' . $request->assignment_id . '/'. auth()->user()->id .'/' . $folder, $fileName, 'public'); // Change 'uploads' to your desired directory
                    
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

    public function turn_in_links(){
        //to do
    }

    public function get_files($assignment_id){
        $turn_in = TurnIn::where('user_id', auth()->user()->id)
        ->where('assignment_id', $assignment_id)
        ->first();

        if($turn_in){
            $files = TurnInFile::where('turn_in_id', $turn_in->id)
            ->get();

            return response()->json($files);
        }

        return response()->json('no turn in yet');
        
    }
    
    public function load_files($batch_id, $assignment_id, $file_id){
        $file = TurnInFile::where('id', $file_id)->first();
        
        if ($file) {
            $filePath = public_path('storage/assignments/'.$batch_id .'/' . $file->assignment_id.'/'. auth()->user()->id .'/'.  $file->folder.'/'. $file->filename);
            return response()->file($filePath);
        }

        return response()->json($file);
    }
    
    public function delete_file($batch_id, $assignment_id, $id){
        // dd($batch_id. $assignment_id. $id);
        $turn_in = TurnIn::where('assignment_id',$assignment_id)
        ->where('user_id', auth()->user()->id)
        ->first();
        
        $file = TurnInFile::where('turn_in_id',$turn_in->id)
        ->where('id', $id)->first();        
        
        if ($file) {
            $path = '/assignments'.'/'.$batch_id .'/' . $turn_in->assignment_id.'/'. auth()->user()->id .'/'.  $file->folder.'/'. $file->filename;
            
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
    
    public function revert(Request $request){
        $file = TurnInFile::where('folder', $request->getContent())->first();
        $turn_in = TurnIn::find($file->turn_in_id);
        $assignment = Assignment::find($turn_in->assignment_id);  
        
        if ($file) {
            $path = '/assignments'.'/'.$assignment->batch_id .'/' . $turn_in->assignment_id.'/'. auth()->user()->id .'/'.  $file->folder.'/'. $file->filename;
            
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

    public function turn_in_status(Request $request){
        $turn_in = TurnIn::where('assignment_id', $request->assignment_id)
        ->where('user_id', auth()->user()->id)
        ->first();

        $assignment = Assignment::find($request->assignment_id);
        if($turn_in){
            if(!$assignment->closed){
                if($turn_in->turned_in){
                    return response()->json(['status'=>'completed', 'assignment' => 'open']);
                }
                else{
                    return response()->json(['status'=>'pending', 'assignment' => 'open']);
                }
            }else{
                if($turn_in->turned_in){
                    return response()->json(['status'=>'completed', 'assignment' => 'closed']);
                }
                else{
                    return response()->json(['status'=>'pending', 'assignment' => 'closed']);
                }
            }
        }else{
            if(!$assignment->closed){
                return response()->json(['status'=>'pending', 'assignment' => 'open']);
            }else{
                return response()->json(['status'=>'pending', 'assignment' => 'closed']);
            }
        }
    }
    
    public function assignment_action(Request $request){
        $currentDate = Carbon::today();     
        $current = Carbon::now();     
        $assignment = Assignment::find($request->assignment_id);
        $turn_in = TurnIn::where('assignment_id', $assignment->id)
        ->where('user_id', auth()->user()->id)
        ->first();
        // dd($assignment);

        if($assignment->due_date != null){
            if(($currentDate)->lte(Carbon::createFromFormat('Y-m-d', $assignment->due_date))){
                if(($currentDate)->eq(Carbon::createFromFormat('Y-m-d', $assignment->due_date))){
                    if($current->lte(Carbon::createFromFormat('H:i:s',  $assignment->due_hour))){
                        $this->check_turn_in($request, $turn_in, $assignment);                        
                        return response()->json(['action'=>'done']);

                    }else{
                        return response()->json(['assignment_status'=>'closed']);
                    }
                }elseif (($currentDate)->lessThan(Carbon::createFromFormat('Y-m-d', $assignment->due_date))){
                    $this->check_turn_in($request, $turn_in, $assignment);
                    return response()->json(['action'=>'done']);

                }else{
                    return response()->json(['assignment_status'=>'closed']);
                }
            }else{
                return response()->json(['now'=> $current, 'today'=>Carbon::today()]);

            }
        }else{
            $this->check_turn_in($request, $turn_in, $assignment);
        }
        
    }

    private function check_turn_in($request, $turn_in, $assignment){
        if($turn_in){
            if(!$turn_in->turned_in){
            $turn_in->turned_in = true;
            $turn_in->save();
            }else{
                $turn_in->turned_in = false;
                $turn_in->save();
            }
        }else{
            $data = [
                'assignment_id' => $request->assignment_id,
                'user_id' => auth()->user()->id,
                'turned_in' => true,
                'turned_in_date' => Carbon::now()
            ];
            TurnIn::create($data);
            return response()->json(['created'=>'new turn in']);
        }
    }
}
