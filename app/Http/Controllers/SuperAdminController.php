<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

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

class SuperAdminController extends Controller
{
    public function website(){
        return view('website');
    }

    // View Courses
    public function courses_offers(){
        // dump(Course::all());
        return view('courses', [ 'courses' => Course::all(), 'categories' => CourseCategory::all()]);
    }

    // Update / Save Course
    public function add_course(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255', 
            'code' => 'required|string|max:255', 
            'training_hours' => 'required|integer',
            'description' => 'required' ,
            'category' => 'required|integer'
        ]);

        Course::updateOrCreate(
            ['id' => $request->course_id],
            $data);
        return redirect()->route('courses');
    }

    // Delete Course
    public function delete_course($id){
        $record = Course::findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'Record deleted successfully']);
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
        $course = Course::findOrFail($id);
        $enrollees = $course->enrollees->filter(function ($enrollee) {
            // Filter enrollees with batch_id equal to 0 and completed_at is null
            return is_null($enrollee->batch_id) && is_null($enrollee->completed_at);
        });
        $batches = $course->batches;
        
        $enrolleeFiles = collect();
        $user_detail = collect();
        
        foreach ($enrollees as $enrollee) {
            // Retrieve enrollee files for each filtered enrollee
            $enrolleeFiles = $enrolleeFiles->merge($enrollee->enrollee_files);
            $user_detail = $user_detail->merge($enrollee->user);
        }

        // dd($enrollees);
        
        return view('enrollees', compact('course', 'enrollees', 'batches', 'enrolleeFiles'));
        // print_r("<pre>");
        // print_r($enrolleeFiles);
    }

    // Generate Name for New Batch
    public function generate_batch_name(Request $request)
    {
        $course = Course::find($request->courseid);
        $course_code = $course->code;
        $batch = Batch::orderBy('created_at', 'desc')->where('course_id', $request->courseid)->first();
        $lastBatch = $batch->name;

        $lastNumber = intval(substr($lastBatch, -4));
        $newNumber = $lastNumber + 1;
        $newBatchName = $course_code . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $newBatchName;
    }

    // Create New Batch
    public function create_batch(Request $request)
    {
        $request->validate([
            'batch_name' => 'required|string',
            'courseid' => 'required|exists:courses,id',
        ]);

        $batch = new Batch();

        $batch->name = $request->input('batch_name');
        $batch->course_id = $request->input('courseid');

        $batch->save();

        return response()->json(['message' => 'Batch created successfully', 'batch' => $batch], 201);
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

    public function scan_attendance(){
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data(encrypt(auth()->user()->id))
            ->encoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
            // ->errorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->build();

        $qrCode = base64_encode($result->getString());
        // dd($qrCode);
        return view('scan_attendance', compact('qrCode'));
    }

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