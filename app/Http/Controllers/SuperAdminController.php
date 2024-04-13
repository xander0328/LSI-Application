<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Enrollee;
use App\Models\Batch;
use App\Models\Files;
use App\Models\Post;

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
        return view('enrollees', compact('course', 'enrollees', 'batches'));
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
        $userIds = $request->input('user_ids');
        $batchId = $request->input('batch_id');

        try {
            // Update enrollees table with the batch_id for each selected user ID
            foreach ($userIds as $userId) {
                Enrollee::where('user_id', $userId)->update(['batch_id' => $batchId]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error saving to batch: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'An error occurred while saving to the batch.'], 500);
        }
    }


    // Test Input
    public function text_input_post(){
        return view('test_input_post');
    }

    public function post(Request $request){
        // Validate the request data
        $request->validate([
            'message' => 'required|string',
            'file' => 'required|file',
        ]);

        // Handle file upload
        if ($request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('uploads', $fileName, 'public'); // Change 'uploads' to your desired directory

            // Get file type
            $fileType = $file->getClientMimeType();
        }

        // Process other form data
        $message = $request->input('message');
        $post = new Post();
        $post->batch_id = 3;
        $post->description = $message;
        $post->save();

        // Save to database
        $fileEntry = new Files();
        $fileEntry->post_id = $post->id; // Assuming you have $postId available
        $fileEntry->path = $filePath;
        $fileEntry->file_type = $fileType;
        $fileEntry->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Form submitted successfully.');
    }

    
}