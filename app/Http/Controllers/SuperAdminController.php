<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

use Zxing\QrReader;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Enrollee;
use App\Models\EnrolleeFile;
use App\Models\EnrolleeQrcode;
use App\Models\Batch;
use App\Models\Files;
use App\Models\Post;
use App\Models\StudentAttendance;
use App\Models\Attendance;
use App\Models\TempCourseImage;
use App\Models\UnitOfCompetency;
use App\Models\User;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Models\UserSession;
use App\Models\Instructor;
use App\Models\CourseDefault;
use App\Models\CourseIdTemplate;
use App\Models\Orientation;

use App\Notifications\EnrollmentStatus;

use App\Traits\DecryptionTrait;

class SuperAdminController extends Controller
{
    use DecryptionTrait;

    public function website(){
        return view('website');
    }

    // View Courses
    public function courses_offers(){
        // dump(Course::all());
        $course = Course::with(['course_category', 'course_id_template'])->withCount(['enrollees' => function($query){
            $query->whereHas('user', function ($q){
                $q->whereNull('deleted_at');
            })->whereNull(['deleted_at', 'batch_id']);
        }, 
        'batches' => function($query){
            $query->whereNull(['deleted_at', 'completed_at']);
        }])
        ->get();
        
        $course_default = CourseDefault::all();
        $category = CourseCategory::all();
        $temp_image = TempCourseImage::first();
        return view('courses', [ 'courses' => $course, 'categories' => $category, 'temp_image' => $temp_image,'course_defaults' => $course_default ]);
    }

    // add Course Category
    public function add_course_category(Request $request){
        $category = new CourseCategory();
        $category->name = $request->new_category;
        
        if($category->save()){
            return response()->json(['status' => 'success', 'category' => $category]);
        }
        return response()->json(['status' => 'error', 'message' => 'Adding course category failed']);
    }

    // edit course category
    public function edit_course_category(Request $request){
        $category = CourseCategory::where('id', $request->category_id)->first();
        $category->name = $request->category_name;
        if($category->save()){
            return response()->json(['status' => 'success', 'category' => $category]);
        }
    }

    public function delete_course_category(Request $request){
        $category = CourseCategory::where('id', $request->category_id)->first();
        if($category->delete()){
            return response()->json(['status' => 'success', 'category' => $category]);
        }
    }

    // Update / Save Course
    public function add_course(Request $request){
        $data = $request->except(['_token', 'course_id', 'image', 'edit']);
        // dd($request->course_id);
        $data['course_category_id'] = $data['category'];
        unset($data["category"]);

        $temp_image = TempCourseImage::where('folder', $request->image)->first();
        $path = '';
        if($temp_image){
            // dd($temp_image);
            $data['folder'] = $temp_image->folder;
            $data['filename'] = $temp_image->filename;

            $path = 'website/course_image/temp/' . $temp_image->folder .'/'. $temp_image->filename;
        }

        // dd($);
        if($request->course_id != null){
            $course = Course::where('id', $request->course_id)->first();

            if($request->image != $course->folder){
                $current_image_path = 'website/course_image/' . $course->id . '/' . $course->folder .'/'. $course->filename;
    
                if (Storage::exists($current_image_path)) {
                    Storage::delete($current_image_path);
                    $directory = dirname($current_image_path);
                    Storage::deleteDirectory($directory);
                }            

                if($path){
                    $destination = 'website/course_image/'. $course->id .'/' . $data['folder'] .'/'.$data['filename'];

                    if (Storage::exists($path)) {
                        
                        Storage::copy(
                            $path, $destination
                        );
                    
                        Storage::delete($path);
                        $directory = dirname($path);
                        Storage::deleteDirectory($directory);
                    }

                    $temp_image->delete();

                }
            }

            if($course){
                $course->update($data);
            }
            
        }else{
            $course = Course::create($data);
            // dd($course->id);
            if($temp_image){
                $destination = 'website/course_image/'. $course->id .'/' . $data['folder'] .'/'.$data['filename'];
                
                if (Storage::exists($path)) {
                    
                    Storage::copy(
                        $path, $destination
                    );
                    
                    Storage::delete($path);
                    $directory = dirname($path);
                    Storage::deleteDirectory($directory);
                }
                
                $temp_image->delete();
                
            }
        }
            
        return redirect()->route('courses');
    }

    // Upload Course Image
    public function upload_course_image(Request $request){
        $attachment = $request->image;
        if($attachment){
            $filename = time(). '_' . str_replace(' ', '_', $attachment->getClientOriginalName());
            $folder = uniqid('ass', true);
            $filePath = $attachment->storeAs('website/course_image/temp/' . $folder, $filename, 'public'); // Change 'uploads' to your desired directory
                
            $fileType = $attachment->getClientMimeType();
                    
            $temp_file = TempCourseImage::first();

            if($temp_file){
                $path = 'website/course_image/temp/' . $temp_file->folder .'/'. $temp_file->filename;
                
                if (Storage::exists($path)) {
                    Storage::delete($path);
                    $directory = dirname($path);
                    Storage::deleteDirectory($directory);
                }

                $temp_file->delete();
            }
            else{
                $temp_file = new TempCourseImage();
            }

            $temp_file->folder = $folder;
            $temp_file->filename = $filename;
            $temp_file->save();   
            return $folder;

        }

        return json(['error' => 'File not found']);
        
    }

    // Revert Course Image
    public function revert_course_image(Request $request){
        $file = TempCourseImage::where('folder', $request->getContent())->first();
        
        if ($file) {
            $path = 'website/course_image/temp/' . $file->folder .'/'. $file->filename;
            
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

    // Load Course Image
    public function load_course_image($action, $source) {
        // dd($action);
        if($action == 'create'){
            $file = TempCourseImage::where('id', $source)->first();

            if($file){
                $path = storage_path("app/public/website/course_image/temp/{$file->folder}/{$file->filename}");
                
            }
        }else{

            $course = Course::where('id', $source)->first();

            if($course){
                $path = storage_path("app/public/website/course_image/{$course->id}/{$course->folder}/{$course->filename}");
            }
        }

        if (isset($path) && file_exists($path)) {
            $headers = [
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ];
            // Use the file's last modified time as a cache buster
            $cacheBuster = filemtime($path);
            return response()->file($path, $headers)->setEtag($cacheBuster);
        }
        
        return response()->json('no file');   
        // dd($source);
    }

    // Delete Course Image
    public function delete_course_image($action, $file_id){   
        if($action == 'create'){
            $file = TempCourseImage::find($file_id);        
            
            if ($file) {
                $path = 'website/course_image/temp/' . $file->folder .'/'. $file->filename;
                
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
        }
        else{
            $file = Course::find($file_id);  
    
            if($file){
                return response()->json(['success temporary remove' => true]);
            }
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    // Delete Course
    public function delete_course(Request $request){
        
        if(Hash::check($request->password, auth()->user()->password)){
            $course = Course::findOrFail($request->course_id);
            
            if(!$course){
                return response()->json(['isConfirmed' => false, 'message' => 'Course not found'], 404);
            }
            // dd($course);
            $course->delete();
            
            return response()->json(['isConfirmed' => true, 'message' => 'Course deleted successfully', 'course' => $course->name], 200);
        }
        return response()->json(['isConfirmed' => false, 'message' => 'Password incorrect'], 403);

    }

    // Edit Course
    public function edit_course($id){
        $course = Course::find($id);
        return response()->json($course);
    }

    // Enable/Disable Course Enrollment
    public function course_toggle(Request $request)
    {
        $course = Course::find($request->input('course_id'));
        $course->available = !$course->available;
        $course->save();

        return response()->json(['status' => 'success', 'available' => $course->available]);
    }

    // Feature Toggle for Course
    public function feature_toggle(Request $request) {
        $course = Course::find($request->input('course_id'));
        $course->featured = !$course->featured;
        $course->save();

        return response()->json(['status' => 'success', 'featured' => $course->featured]);
    }

    // Load the default ID Template
    public function load_default_id($source) {
        $file = CourseDefault::where('id', $source)->first();

        if($file){
            $path = storage_path("app/public/website/id_template/default/{$file->filename}");
        }

        if (isset($path) && file_exists($path)) {
            $headers = [
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ];
            // Use the file's last modified time as a cache buster
            $cacheBuster = filemtime($path);
            return response()->file($path, $headers)->setEtag($cacheBuster);
        }
        
        return response()->json('no file');   
        // dd($source);
    }

    // Upload default ID
    public function upload_default_id(Request $request){
        $attachment = $request->file('image');
        if($attachment){
            $filename = "default_id_template.".$attachment->getClientOriginalExtension();
            
            $currentFile = CourseDefault::where('purpose', 'id_template')->first();
            
            if($currentFile){
                $path = 'website/id_template/default/' . $currentFile->filename;
                
                if (Storage::exists($path)) {
                    Storage::delete($path);
                    $directory = dirname($path);
                    Storage::deleteDirectory($directory);
                }
                
                $currentFile->delete();
            }
            else{
                $currentFile = new CourseDefault();
                $currentFile->purpose = "id_template";
            }
            
            $filePath = $attachment->storeAs('website/id_template/default',$filename, 'public'); // Change 'uploads' to your desired directory
            $currentFile->filename = $filename;
            $currentFile->save();   
            return $filename;

        }

        return json(['error' => 'File not found']);
        
    }
    
    // Revert Default ID
    public function revert_default_id(Request $request){
        return response()->json(['success' => 'File temporary deleted']);
    }
    
    // Delete Default ID
    public function delete_default_id(Request $request){
        return response()->json(['success' => 'File temporary deleted']);
    }

    // Load the ID_template Template
    public function load_id_template($source) {
        $file = CourseIdTemplate::where('id', $source)->first();
        $path = "";

        if($file){
            $path = public_path('storage/website/id_template/'.$file->course_id.'/'.$file->folder.'/' . $file->filename);
        }
        if (isset($path) && file_exists($path)) {
            $headers = [
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ];
            // Use the file's last modified time as a cache buster
            $cacheBuster = filemtime($path);
            return response()->file($path, $headers)->setEtag($cacheBuster);
        }
        
        return response()->json('no file');   
        // dd($source);
    }

    // Upload ID_template
    public function upload_id_template(Request $request){
        $attachment = $request->file('image');
        if($attachment){
            $filename = "id_template.".$attachment->getClientOriginalExtension();
            $folder = uniqid('id', true);
            
            $currentFile = CourseIdTemplate::where('course_id', $request->course_id)->first();

            
            if($currentFile){
                $path = 'website/id_template/'.$request->course_id.'/'.$currentFile->folder.'/' . $currentFile->filename;
                
                if (Storage::exists($path)) {
                    Storage::delete($path);
                    $directory = dirname($path);
                    Storage::deleteDirectory($directory);
                }
            }else{
                $currentFile = new CourseIdTemplate();
                $currentFile->course_id =  $request->course_id;
            }
            
            $filePath = $attachment->storeAs('website/id_template/'.$request->course_id.'/'.$folder, $filename, 'public'); // Change 'uploads' to your desired directory
            
            $currentFile->folder = $folder;
            $currentFile->filename = $filename;
            $currentFile->save();   
            return $folder;

        }

        return response()->json(['error' => 'File not found']);
        
    }
    
    // Revert ID_template
    public function revert_id_template(Request $request){
        return response()->json(['success' => 'File temporary deleted']);
    }
    
    // Delete ID_template
    public function delete_id_template(Request $request){
        return response()->json(['success' => 'File temporary deleted']);
    }

    // See Enrollees per Course
    public function enrollees($id, $page = 1)
    {
        $course = Course::where('id', $id)->with('batches')->withCount('enrollees')->first();
        // dd($course);
        return view('enrollees', compact('course', 'page'));
    }

    public function load_more_enrollees($id, $page) {
        $perPage = 20; 
        $cacheKey = "course-enrollees-page-{$id}-{$page}";
    
        $enrollees = Cache::remember($cacheKey, 60, function () use ($id, $perPage, $page) {
            $offset = ($page - 1) * $perPage; // Calculate offset
            
            return Enrollee::select(['id', 'employment_status', 'employment_type', 'user_id', 'course_id', 'preferred_schedule', 'preferred_start', 'preferred_finish'])
                ->where('course_id', $id)
                ->whereNull('batch_id')
                ->whereNotIn('user_id', function ($subQuery) use ($id) {
                    $subQuery->select('user_id')
                            ->from('enrollees')
                            ->where('course_id', '!=', $id)
                            ->whereNotNull('batch_id');
                })
                ->whereNull('deleted_at')
                ->whereHas('user', function($query){
                    $query->whereNull('deleted_at');
                })
                ->with([
                    'user',
                    'enrollee_files_submitted' => function ($query) {
                        $query->select(['id', 'enrollee_id', 'credential_type']);
                    }
                ])
                ->skip($offset)
                ->take($perPage)
                ->get();
        });
    
        return response()->json($enrollees);
    }
    

    // Remove Enrollee
    public function remove_enrollee(Request $request){
        $enrollee = Enrollee::find($request->enrollee_id);
        $enrollee->delete();

        if($enrollee)
            return response()->json(['status' => 'success', 'message' => "Enrollee {$enrollee->user->fname} {$enrollee->user->lname} has been successfully removed.", 'title' => 'Enrollee Removal']);
        
            return response()->json(['status' => 'error', 'message' => "Failed to remove {$enrollee->user->fname} {$enrollee->user->lname} in the enrollee list. Please try again.", 'title' => 'Enrollee Removal']);
    }

    public function show_diploma($id){
        $diploma = EnrolleeFile::where('id', $id)
        ->with(['enrollee.course'])
        ->first();
        if($diploma){
            return view('view_enrollee_file', compact('diploma'));
        }

        return redirect()->back()->with(['status' => 'error', 'message' =>'File not found']);
    }

    public function create_new_batch(Request $request)
    {
        // Fetch all batches for the given course, including soft-deleted ones
        $batches = Batch::where('course_id', $request->course_id)->get();

        // Get the current year and extract the last 2 digits
        $year = date('y'); // 'y' gives the last two digits of the year

        // Initialize the maximum number and a flag to check if it's from a soft-deleted batch
        $maxNumber = 0;

        foreach ($batches as $batch) {
            // Extract the batch number (after the '_') from the name
            $parts = explode('_', $batch->name);

            // Check if the batch belongs to the current year
            if ($parts[0] == $year) {
                $number = intval($parts[1]); // Convert the batch number part to an integer

                // Check if this number is greater than the current max
                if ($number > $maxNumber) {
                    $maxNumber = $number;
                }
            }
        }

        // Increment the number, starting at 1 if no batches exist for the current year
        $newNumber = $maxNumber + 1;

        // Format the new batch name
        $newBatchName = $year . '_' . $newNumber;

        // Create and save the new batch
        $new_batch = new Batch();
        $new_batch->name = $newBatchName;
        $new_batch->course_id = $request->course_id;
        $new_batch->save();

        $new_batch->enrollee_count = 0;

        // Return a JSON response
        if ($new_batch) {
            return response()->json([
                'status' => 'success',
                'message' => 'Batch created successfully, ' . $new_batch->course->code . '-' . $new_batch->name,
                'title' => 'Create New Batch',
                'new_batch' => $new_batch
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'New batch cannot be created. Try again later',
            'title' => 'Create New Batch'
        ]);
    }

    public function get_course_batches(Request $request){
        $course = Course::where('id', $request->course_id)
        ->with(['batches' => function ($query){
            $query->whereNull(['deleted_at', 'completed_at'])
                ->with('orientation')
                ->withCount(['enrollee' => function($enrollee){
                    $enrollee->whereNull('deleted_at');
                }]);
        }])
        ->first();

        if($course){
            return response()->json(['status' => 'success', 'course' => $course]);
        }

        return response()->json(['status' => 'error', 'message' => 'Course not found']);
    }

    public function get_batch_data(Request $request){
        $batch = Batch::where('id', $request->batch_id)
        ->with(['enrollee' => function($query){
            $query->select('id', 'batch_id', 'user_id')->whereNull('deleted_at')
                ->whereHas('user', function($userQuery) {
                    $userQuery->whereNull('deleted_at');
                })
                ->with(['user' => function($user){
                    $user->whereNull('deleted_at');
                }]);
        }, 'instructor', 'instructor.user'])->first();

        if($batch){
            return response()->json(['status' => 'success', 'batch' => $batch]);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Batch not found']);
    }

    public function unassign_instructor(Request $request) {
        $batch = Batch::where('id', $request->batch_id)->first();
        
        if ($batch) {
            $batch->instructor_id = null;

            if($batch->update()){
                return response()->json(['status' => 'success']);
            }
            
            return response()->json(['status' => 'error', 'message' => 'Instructor did not removed']);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Batch not found']);
    }

    public function get_all_instructors(Request $request) {
        $instructors = Instructor::whereHas('user', function($query){
            $query->whereNull('deleted_at');
        })
        ->with('user')
        ->get();
        
        return response()->json(['instructors' => $instructors]);
        
    }

    public function assign_instructor(Request $request){
        $batch = Batch::where('id', $request->batch_id)->first();
        if($batch){
            $instructor = Instructor::where('id', $request->instructor_id)->with('user')->first();

            if($instructor){
                $batch->instructor_id = $instructor->id;
                if($batch->update()){
                    return response()->json(['status' => 'success', 'instructor' => $instructor]);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Instructor not found']);
                }
            }
            return response()->json(['status' => 'error', 'message' => 'Instructor not assigned']);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Batch not found']);
    }


    public function get_user_records(Request $request){
        $user = User::with([
            'enrollee',
            'enrollee.course',
            'enrollee.batch', 
            'enrollee.enrollee_files_submitted',
            'user_session'
            ])
            ->where('id', $request->user_id)
            ->first();

        if ($user) {
            return response()->json(['user_records' => $user]);
        }

        return response()->json(['error' => 'User cannot be found'], 404);
    }

    public function delete_batch(Request $request) {
        $batch = Batch::where('id', $request->batch_id)->first();
        $batch->delete();

        if($batch){
            return back()->with(['status' => 'success', 'message' => 'The batch has been deleted', 'title' => 'Batch Deletion']);
        }
        return back()->with(['status' => 'error', 'message' => 'Unable to delete the batch. Try again later', 'title' => 'Batch Deletion']);
    }

    // Add Enrollees to Batch
    public function add_to_batch(Request $request){

        DB::beginTransaction();

        $enrollee_ids = $request->input('user_ids');
        $batchId = $request->input('batch_id');
        $batch = Batch::where('id', $batchId)->with('course')->first();
        $batchName = $batch->course->code.'-'.$batch->name;
        $courseName = $batch->course->name;

        $users = Enrollee::whereIn('id', $enrollee_ids)
            ->with('user')  // Eager load the related users
            ->get()
            ->pluck('user');

        try {
            // Update enrollees table with the batch_id for each selected user ID
            foreach ($enrollee_ids as $enrollee_id) {
                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->writerOptions([])
                    ->data(encrypt($enrollee_id))
                    ->encoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
                    // ->errorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
                    ->size(300)
                    ->margin(10)
                    ->build();
        
                $qrCode = base64_encode($result->getString());
                $courseId = Batch::where('id', $batchId)->pluck('course_id')->first();
                $enrollee = Enrollee::where('id', $enrollee_id)->first();
                $enrollee->update(['batch_id' => $batchId]);
                $user = User::where('id', $enrollee->user_id)->first();
                $user->update(['role' => 'student']);
                EnrolleeQrcode::create([
                    'enrollee_id' => $enrollee_id,
                    'qr_code' => $qrCode
                ]);
                $payment = new Payment();
                $payment->enrollee_id = $enrollee_id;

                $reg = $enrollee->course->registration_fee;
                $bond = $enrollee->course->bond_deposit;
                
                if($enrollee->employment_type == 'trainee' || $enrollee->employment_type == 'unemployed' ){
                    $reg = 0;
                }
                
                $payment->balance = $reg + $bond;
                $payment->save();

                // $user->notify(new EnrollmentStatus('accepted', $batchName, $courseName));
            }

            // Notification::route('mail', $users)->notify(new EnrollmentStatus('accepted', $batchName, $courseName));
            Notification::send($users, new EnrollmentStatus('accepted', $batchName, $courseName));

            $totalEnrollees = Enrollee::where('course_id', $courseId)
                ->whereNull('batch_id')
                ->whereNull('deleted_at')
                ->count();
            $perPage = 20;
            $totalPages = ceil($totalEnrollees / $perPage); // Calculate total number of pages

            for ($page = 1; $page <= $totalPages; $page++) {
                $cacheKey = "course-enrollees-page-{$courseId}-{$page}";
                Cache::forget($cacheKey);
            }

            DB::commit();


            return response()->json(['success' => true, 'userIds' => $batch->enrollee()->pluck('user_id')]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error saving to batch: ' . $e->getMessage());
            DB::rollBack();
            // Return error response
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function get_enrollee_records(Request $request){
        $enrollee = Enrollee::where('id', $request->enrollee_id)->with(['user', 'enrollee_files_submitted', 'enrollee_education'])->first();
        // dd($enrollee);
        if ($enrollee) {
            return response()->json(['enrollee_profile' => $enrollee]);
        }

        return response()->json(['error' => 'User cannot be found'], 404);
    }

    // Attendance Section

    //Scanner of ID
    public function scan_attendance(){
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data(encrypt(auth()->user()->id))
            ->encoding(new Encoding('UTF-8'))
            // ->errorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->build();

        $qrCode = base64_encode($result->getString());
        // dd($qrCode);
        return view('scan_attendance', compact('qrCode'));
    }

    //Returning the data of scanned ID
    public function get_scan_data(Request $request){
        if (!$this->isDecryptable($request->qr_code)) {
            return response()->json(['status'=>'error', 'message' => 'Invalid ID']);
        }

        $enrollee_id = decrypt($request->qr_code);
        $enrollee = Enrollee::where('id', $enrollee_id)
        ->with(['user', 'enrollee_files', 'batch.course', 
        'enrollee_attendances' => function ($q){
            $q->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc');
        }])
        ->first();
        
        if(!$enrollee){
            return response()->json(['status' => 'error', 'message' => 'Trainee not found']);
        }

        return response()->json($enrollee);
    }

    //Creating a record of the scanned ID
    public function submit_f2f_attendance(Request $request){
        $trainee = Enrollee::where('id', $request->student_id)->first();

        $batch = Batch::where('id', $request->batch_id)->first();

        $current_attendance = Attendance::where('batch_id', $batch->id)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->first();

        $all_student = Enrollee::where('batch_id', $batch->id)->get();

        if ($current_attendance) {
            // Check if the student is already logged in the student_attendance relation
            $student_attendance = $current_attendance->student_attendances()
                ->where('enrollee_id', $request->student_id)
                ->whereNot('status', 'absent')
                ->first();
            
            if (!$student_attendance) {
                // If the student is not yet logged, log them
                $current_attendance->student_attendances()
                ->where('enrollee_id', $request->student_id)
                ->update([
                    'status' => $request->status,
                ]);
            } else {
                // Student is already logged in, handle this case if needed
                $new_attendance = Attendance::create([
                    'batch_id' => $batch->id,
                    'date' => Carbon::today(),
                    'mode' => 'f2f',
                    'created_at' => Carbon::now(),
                ]);
        
                foreach ($all_student as $student) {
                    $new_attendance->student_attendances()->create([
                        'enrollee_id' => $student->id,
                        'status' => $request->student_id == $student->id ? $request->status : 'absent',
                    ]);
                }
            }

        } else {
            // If no attendance record for today, create a new one and log the student
            $new_attendance = Attendance::create([
                'batch_id' => $batch->id,
                'date' => Carbon::today(),
                'mode' => 'f2f',
                'created_at' => Carbon::now(),
            ]);


            foreach ($all_student as $student) {
                $new_attendance->student_attendance()->create([
                    'enrollee_id' => $student->id,
                    'status' => $request->student_id == $student->id ? $request->status : 'absent',
                ]);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'You accepted '.$trainee->user->fname.' '.$trainee->user->lname.' as '.($request->status == 'present' ? 'On Time' : 'Late'), 'title' => 'Attendance']);
    }

    // Users Section
    public function all_users(Request $request){
        $role = $request->query('role', 'all');

        $cacheKey = "all_users_role_{$role}";

        $cachedData = Cache::remember($cacheKey, 60, function () use ($role) {
            $query = User::query();
            $query->whereNot('role', 'superadmin');

            $users_count_query = clone $query;
            $all_user_count = $users_count_query->count();

            if($role && $role != 'all'){
                $query->where('role', $role);
            }

            $role_count_query = clone $query;
            $users_role_count = $role_count_query->count();

            $users = $query->with(['enrollee.enrollee_files' => function ($query) {
                        $query->select('enrollee_id', 'credential_type', 'filename');
                }])->take(20)->get();
            
            return [
                'users' => $users,
                'all_user_count' => $all_user_count,
                'users_role_count' => $users_role_count,
            ];
        });

        $users = $cachedData['users'];
        $all_user_count = $cachedData['all_user_count'];
        $users_role_count = $cachedData['users_role_count'];
                
        return view('all_users', compact('users', 'role', 'all_user_count', 'users_role_count'));
    }

    public function load_more_users(Request $request){
        $chunkSize = $request->query('chunkSize', 20);
        $offset = $request->query('offset', 0);
        $role = $request->query('role');
        $searchTerm = $request->query('searchTerm');

        $cacheKey = "load_more_users_{$role}_{$searchTerm}_{$chunkSize}_{$offset}";

        $cachedData = Cache::remember($cacheKey, 60, function () use ($chunkSize, $offset, $role, $searchTerm) {
            $query = User::query();

            // Add the search term filter if it's provided and not empty
            if (!empty($searchTerm)) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('fname', 'like', "%$searchTerm%")
                    ->orWhere('lname', 'like', "%$searchTerm%")
                    ->orWhere('email', 'like', "%$searchTerm%");
                });
            }

            // Apply role filter based on the 'role' parameter
            if ($role && $role !== 'all') {
                $query->where('role', $role);
            }

            // Exclude 'superadmin' role from the results
            $query->whereNot('role', 'superadmin');
            $totalQuery = clone $query;

            // Get the specified chunk of users
            $users = $query->skip($offset)->take($chunkSize)->get();
            $totalCount = $totalQuery->count();
            
            return [
                'users' => $users,
                'count' => $totalCount,
            ];
        });

        $users = $cachedData['users'];
        $totalCount = $cachedData['count'];

        return response()->json(['users' => $users, 'count' => $totalCount]);
    }

    public function search_user(Request $request){
        $chunkSize = 4;
        $role = $request->query('role');
        $searchTerm = $request->query('searchTerm');

        $query = User::query();

        // Add the search term filter if it's provided and not empty
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('fname', 'like', "%$searchTerm%")
                ->orWhere('lname', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%");
            });
        }

        // Apply role filter based on the 'role' parameter
        if ($role && $role !== 'all') {
            $query->where('role', $role);
        }

        // Exclude 'superadmin' role from the results
        $query->whereNot('role', 'superadmin');
        
        $totalQuery = clone $query;

        // Get the specified chunk of users
        $users = $query->take($chunkSize)->get();

        $totalCount = $totalQuery->count();

        return response()->json(['users' => $users, 'count' => $totalCount]);
    }


    public function disable_user(Request $request){
        $user = User::find($request->user_id);
        $user->delete();

        if($user)
            return back()->with(['status' => 'success', 'message' => 'User account, '.$user->email.', has been successfully disabled', 'title' => 'Account Disabled']);

        return back()->with([
            'status' => 'error',
            'title' => 'Account Disablement Failed',
            'message' => "Failed to disable the account for user {$user->email}. Please try again.",
        ]);
            
    }

    public function remove_session(Request $request) {
        $session = UserSession::find($request->session_id);
        $session->delete();

        if($session){
            return response()->json(['status' => 'success', 'message' => 'Session removed']);
        }
        return response()->json(['status' => 'error', 'message' => 'Session not removed']);

    }

    public function get_enrollee_data(Request $request){
        $enrollee_data = Enrollee::where('id', $request->enrollee_id)->with(['user', 'enrollee_files', 'enrollee_education', 'course'])->first();

        if ($enrollee_data) {
            return response()->json(['enrollee_data' => $enrollee_data]);
        }

        return response()->json(['error' => 'Enrollment data cannot be found'], 404);
        
    }

    public function promote_user(Request $request){
        $user = User::find($request->user_id);

        if($user){
            $user->role = 'instructor';
            $user->update();

            return back()->with(['status' => 'success', 
            'message' => "{$user->fname} {$user->lname} has been successfully promoted to the instructor role.`", 
            'title' => 'Account Promotion']);
        }
    }

    // Payments Section
    public function payments(Request $request){
        $course_id = $request->query('course');
        $batch_id = $request->query('batch');
        $query = Course::query();
        
        if(!$course_id){
            $course_id = Course::orderBy('id')->pluck('id')->first();
        }

        if(!$batch_id){
            $selected_course = Course::find($course_id); 
            $batch_id = $selected_course->batches->first()->id;
        }
        
        $course = Course::with(['batches' => function ($query) use (&$batch_id) {
            $query->where('id', $batch_id);
            $query->with(['enrollee.payments', 'enrollee.user', 'enrollee.enrollee_files']);
        }])->find($course_id);

        $all_batches = Batch::where('course_id', $course->id)->get();
        // dd($course);
        $all_courses = Course::with('batches')->get();
        return view('payments', compact('course', 'all_courses', 'all_batches', 'course_id', 'batch_id'));
    }

    public function make_payment(Request $request){
        $payment = Payment::where('id', $request->payment_id)->first();
        $new_balance = $payment->balance - $request->payment_amount;
        $payment->balance = $new_balance;
        $payment->update();

        $payment_log = new PaymentLog();
        $payment_log->payment_id = $payment->id;
        $payment_log->amount = $request->payment_amount;
        $payment_log->save();

        if($payment && $payment_log){
            return back()->with(['status' => 'success', 'message' => 'Amount of Php '.$payment_log->amount.' successfully deducted to the balance of '.$request->enrollee_name, 'title' => 'Payment']);
        }
        
        return back()->with(['status' => 'error', 'message' => 'There\'s an error. Please try again.', 'title' => 'Payment']);
    }

    public function make_refund(Request $request){
        $payment = Payment::where('id', $request->payment_id)->first();

        if($request->refund_reason != 'bond deposit'){
            $new_balance = $payment->balance + $request->refund_amount;
            $payment->balance = $new_balance;
            $payment->update();
        }

        $reason = $request->refund_reason == 'other' ? $request->other_reason : $request->refund_reason;

        $payment_log = new PaymentLog();
        $payment_log->payment_id = $payment->id;
        $payment_log->amount = $request->refund_amount;
        $payment_log->refund_reason = $reason;
        $payment_log->save();

        if($payment && $payment_log){
            return back()->with(['status' => 'success', 'title' => 'Refund', 'message' => 'Amount of Php '.$payment_log->refund_amount.' successfully refunded to '.$request->enrollee_name]);
        }
        
        return back()->with(['status' => 'error', 'title' => 'Refund', 'message' => 'There\'s an error. Please try again.']);
    }

    public function get_payment_details(Request $request){
        $payment = Payment::where('enrollee_id', $request->enrollee_id)->with('payment_logs')->first();
        return response()->json(['payment' => $payment]);
    }

    // Instructors Section
    public function instructors(){
        $instructors = User::select('id', 'lname', 'mname', 'fname', 'email', 'contact_number')
        ->where('role', 'instructor')
        ->with(['instructor_info' => function ($query){
            $query->select('id', 'user_id', 'folder','id_picture');
        }])
        ->get();

        return view('instructors', compact('instructors'));
    }

    public function get_instructor_info(Request $request){
        $instructor_info = Instructor::where('id',$request->instructor_id)
            ->with(['batches' => function ($query){
                $query->whereNull(['deleted_at'])
                ->with(['course' => function ($query){
                    $query->select('id', 'code', 'name');
                }
            ]);
            }])->first();
        // dd($instructor_info);
        if($instructor_info)
            return response()->json(['status' => 'success', 'instructorInfo' => $instructor_info]);
        
        return response()->json(['status' => 'error', 'message' => 'Instructor information not found']);
    }

    // Dashboard Section
    public function dashboard(){
        $web_users = [];

        $roles = User::select('role', \DB::raw('COUNT(*) as count'))->whereNot('role', 'superadmin')->groupBy('role')->get();
        foreach ($roles as $role) {
            $web_users[] = [
                'role' => $role->role,  // Role name
                'count' => $role->count // Number of users with that role
            ];
        }

        $deletedUsersCount = User::onlyTrashed()->whereNot('role', 'superadmin')->count();
        $web_users[] = [
            'role' => 'disabled account',
            'count' => $deletedUsersCount
        ];


        $yearly_enrollees['all'] = Enrollee::select(\DB::raw('YEAR(created_at) as year'), \DB::raw('COUNT(*) as count'))
        ->groupBy('year')
        ->get();

        $yearly_enrollees['accepted'] = Enrollee::select(\DB::raw('YEAR(created_at) as year'), \DB::raw('COUNT(*) as count'))
        ->whereNotNull('batch_id')
        ->groupBy('year')
        ->get();

        $monthly_enrollees = Enrollee::select(\DB::raw('YEAR(created_at) as year'), \DB::raw('MONTH(created_at) as month'), \DB::raw('COUNT(*) as count'))
        ->groupBy('year', 'month')
        ->get();
        
        $all_courses = Course::count();
        $ongoing_courses = Course::where('available', true)->count();
        $active_batches = Batch::whereNull('completed_at')->count();
        $all_batches = Batch::count();

        $today_enrollees = User::where('created_at', Carbon::today())->whereNotNull('email_verified_at')->count();
        $month_enrollees = User::whereMonth('created_at', Carbon::now()->month)
                           ->whereYear('created_at', Carbon::now()->year)
                           ->whereNotNull('email_verified_at')->count();

        $year_enrollees = User::whereYear('created_at', Carbon::now()->year)->whereNotNull('email_verified_at')->count();
        // dd($ongoing_courses); 
        // dd($web_users);
        // Enrollees per course
        $courses = Course::withCount('enrollees')->get();

        return view('dashboard', 
        compact(
            'courses',
        'today_enrollees',  
        'month_enrollees',  
        'year_enrollees',
        'all_courses', 
        'ongoing_courses',
        'active_batches' , 
        'all_batches',
        'web_users', 
        'yearly_enrollees',
        'monthly_enrollees')); 
    }

    public function get_orientation_date($batch_id){
        $batch = Batch::where('id', $batch_id)
            ->with(['orientation' => function ($q){
            $q->whereNull('deleted_at');
        }])
        ->first();
        
        if ($batch) {
            if($batch->orientation !== null){
                $batch->orientation_date = Carbon::parse($batch->orientation->date_time)->format('Y-m-d');
                $batch->orientation_time = Carbon::parse($batch->orientation->date_time)->format('H:i:s'); // or use 'h:i A' for 12-hour format
            }
            return response()->json(['status' => 'success', 'data' => $batch]);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Batch not found']);
    }

    public function assign_orientation_date(Request $request){
        $batch = Batch::where('id', $request->batch_id)
        ->first();
        
        if($batch){
            $date = Carbon::parse($request->orientation_date)->format('Y-m-d');; 
            $time = Carbon::parse($request->orientation_time)->format('H:i:s'); 

            $datetime = Carbon::parse("{$date} {$time}");

            $orientation = Orientation::updateOrCreate(
                ['batch_id' => $batch->id], // Conditions to find the record
                [
                    'date_time' => $datetime,
                ]
            );
            return response()->json(['status' => 'success', 'orientation' => $orientation, 'userIds' => $batch->enrollee()->pluck('user_id')]);
        }
        return response()->json(['status' => 'error', 'message' => 'Batch not found']);

    }

    public function updateAllPass(){
        $users = User::all();
        foreach ($users as $user) {
            $user->password = Hash::make('pass');
            $user->save();
        }
    
        return "All users' passwords have been updated to the default.";
    }
}