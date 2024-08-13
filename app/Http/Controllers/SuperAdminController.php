<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

use Zxing\QrReader;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Enrollee;
use App\Models\EnrolleeFiles;
use App\Models\EnrolleeQrcode;
use App\Models\Batch;
use App\Models\Files;
use App\Models\Post;
use App\Models\StudentAttendance;
use App\Models\Attendance;
use App\Models\TempCourseImage;
use App\Models\UnitOfCompetency;

class SuperAdminController extends Controller
{
    public function website(){
        return view('website');
    }

    // View Courses
    public function courses_offers(){
        // dump(Course::all());
        return view('courses', [ 'courses' => Course::with('batches')->get(), 'categories' => CourseCategory::all(), 'temp_image' => TempCourseImage::first()]);
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
                $headers = [
                    'Content-Disposition' => 'inline; filename="'.basename($path).'"',
                ];
                return response()->file($path, $headers);
            }
        }else{

            $course = Course::where('id', $source)->first();

            if($course){
                $path = storage_path("app/public/website/course_image/{$course->id}/{$course->folder}/{$course->filename}");
                $headers = [
                    'Content-Disposition' => 'inline; filename="'.basename($path).'"',
                ];
                return response()->file($path, $headers);
            }
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

    // Enable/Disable Course
    public function course_toggle(Request $request)
    {
        $course = Course::find($request->input('course_id'));
        $course->available = !$course->available;
        $course->save();

        return response()->json(['status' => 'success', 'available' => $course->available]);
    }
    
    // See Enrollees per Course
    public function enrollees($id)
    {
        $course = Course::with('batches')->with('enrollees.user')->with('enrollees.enrollee_files')->where('id',$id)->first();
        // $enrollees = $course->enrollees->filter(function ($enrollee) {
        //     // Filter enrollees with batch_id equal to 0 and completed_at is null
        //     return is_null($enrollee->batch_id) && is_null($enrollee->completed_at);
        // });
        // dd($course);
        
        // $enrolleeFiles = collect();
        // $user_detail = collect();
        
        // foreach ($enrollees as $enrollee) {
        //     // Retrieve enrollee files for each filtered enrollee
        //     $enrolleeFiles = $enrolleeFiles->merge($enrollee->enrollee_files);
        //     $user_detail = $user_detail->merge($enrollee->user);
        // }

        // dd($enrollees);
        
        return view('enrollees', compact('course'));
        // print_r("<pre>");
        // print_r($enrolleeFiles);
    }

    // Generate New Batch
    public function create_new_batch(Request $request)
    {
       // Fetch all batches for the given course, including soft-deleted ones
        $batches = Batch::withTrashed()->where('course_id', $request->course_id)->get();

        // Initialize the maximum number and a flag to check if it's from a soft-deleted batch
        $maxNumber = 0;
        $isMaxFromSoftDeleted = false;

        foreach ($batches as $batch) {
            $number = intval($batch->name); // Convert batch name directly to an integer

            // Check if this number is greater than the current max
            if ($number > $maxNumber) {
                $maxNumber = $number;
                $isMaxFromSoftDeleted = $batch->trashed();
            }
        }

        // Determine the new number based on whether the highest was soft-deleted
        if ($isMaxFromSoftDeleted) {
            $newNumber = $maxNumber; // Reuse the highest number
        } else {
            $newNumber = $maxNumber + 1; // Use the next number
        }

        // Format the new batch name with leading zeros
        $newBatchName = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $new_batch = new Batch();
        $new_batch->name = $newBatchName;
        $new_batch->course_id = $request->course_id;
        $new_batch->save();

        if($new_batch)
            return response()->json(['status' => 'success','message' => 'Batch created successfully, '.$new_batch->course->code.'-'. $new_batch->name, 'title' => 'Create New Batch', 'new_batch' => $new_batch]);

        return response()->json(['status' => 'error','message' => 'New batch cannot be created. Try again later', 'title' => 'Create New Batch']);

    }

    // Create New Batch (Replaced/Deleted)
    // public function create_batch(Request $request)
    // {
    //     $batch = new Batch();

    //     $batch->name = $request->input('batch_name');
    //     $batch->course_id = $request->input('courseid');

    //     $batch->save();

    //     return response()->json(['message' => 'Batch created successfully', 'batch' => $batch], 201);
    // }

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
        $enrollee_ids = $request->input('user_ids');
        $batchId = $request->input('batch_id');
        
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

                Enrollee::where('id', $enrollee_id)->update(['batch_id' => $batchId]);
                EnrolleeQrcode::create([
                    'enrollee_id' => $enrollee_id,
                    'qr_code' => $qrCode
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error saving to batch: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

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
        $enrollee_id = decrypt($request->qr_code);
        $enrollee = Enrollee::where('id', $enrollee_id)->first();
        $files = collect();
        $user = collect();
        $batch = collect();

            // Retrieve files for each post
        $user = $user->merge($enrollee->user);
        $files = $files->merge($enrollee->enrollee_files);
        $batch = $batch->merge($enrollee->batch);

        // dd($enrollee);
        return response()->json($enrollee);
    }

    //Creating a record of the scanned ID
    public function submit_f2f_attendance(Request $request){
        $current_attendance = Attendance::where('date', Carbon::today())
        ->where('batch_id', $request->batch_id)
        ->first();

        $batch = Batch::where('id', $request->batch_id)->first();

        if($current_attendance){
            $already_recorded = StudentAttendance::where('attendance_id', $current_attendance->id)
            ->where('enrollee_id', $request->student_id)
            ->whereNot('status', 'absent')
            ->first();

            if($already_recorded){
                return response()->json(['status' => 'Batch '.$batch->name.': Already Recorded']);
            }
            else{
                $new_attendee = StudentAttendance::where('attendance_id', $current_attendance->id)
                ->where('enrollee_id', $request->student_id)
                ->first();

                $new_attendee->status = $request->status;
                $new_attendee->save();
                return response()->json(['status' => 'Batch '.$batch->name.': New attendee recorded']);
            }
        }
        else {
            $new_attendance_record = new Attendance();
            $new_attendance_record->batch_id = $request->batch_id;
            $new_attendance_record->date = Carbon::today();
            $new_attendance_record->mode = "f2f";
            $new_attendance_record->save();

            $all_students = Enrollee::where('batch_id', $request->batch_id)->get();
            foreach ($all_students as $student){
                $attendee = new StudentAttendance();
                $attendee->attendance_id = $new_attendance_record->id;
                $attendee->enrollee_id = $student->id;
                $attendee->status = $student->id == $request->student_id ? $request->status : 'absent';
                $attendee->save();
            }

            return response()->json(['status' => 'Batch '.$batch->name.': First attendee recorded today']);
        }
    }

    public function all_users(){
        return view('all_users');
    }

    

    // Test Input
    public function text_input_post(){
        return view('test_input_post');
    }
}