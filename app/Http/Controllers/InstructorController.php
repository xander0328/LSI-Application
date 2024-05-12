<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Batch;
use App\Models\Post;
use App\Models\Files;
use App\Models\Assignment;
use App\Models\AssignmentFile;
use App\Models\TempAssignment;

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

        $files = collect(); // Initialize an empty collection for files

    // Retrieve files for each post
    foreach ($posts as $post) {
        $files = $files->merge($post->files);
    }

        return view('instructor.batch_posts', compact('batch', 'posts', 'files'));
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
                $fileName = time(). '_' . str_replace(' ', '_', $attachments->getClientOriginalName());
                $folder = uniqid('ass', true);
                $filePath = $attachments->storeAs('assignments/temp/' . $folder, $fileName, 'public'); // Change 'uploads' to your desired directory
                    
                // Get file type
                $fileType = $attachments->getClientMimeType();
                        
                $temp_assignment = new TempAssignment();
                $temp_assignment->folder = $folder;
                $temp_assignment->filename = $fileName;
                $temp_assignment->file_type = $fileType;
                $temp_assignment->save();   
                return $folder;
            }
        }
            
        return '';
    }
    
    //New
    public function post_assignment(Request $request){
        
        $assignment_details = $request->only([
            'batch_id',
            'title',
            'description',
            'due_date',
            'due_hour',
        ]);
        $assignment_details['due_date'] = date('Y-m-d', strtotime($assignment_details['due_date']));

        $assignment_details['closing'] = $request->input('closing') ? 1 : 0;

        $assignment = new Assignment();
        $assignment->fill($assignment_details);
        $assignment->save();
        
        // dd($temp_assignment);
        if($request->assignment_files){
            foreach($request->assignment_files as $temp){
                $temp_assignment = TempAssignment::where('folder', $temp)->first();
                Storage::copy('assignments/temp/' . $temp_assignment->folder . '/'. $temp_assignment->filename, 'assignments/'.$request->batch_id.'/'. $temp_assignment->filename  );
                // $filePath = $folder->storeAs('assignment/'.$request->batch_id.'/', $fileName, 'public'); // Change 'uploads' to your desired directory
                        
                $fileEntry = new AssignmentFile();
                $fileEntry->assignment_id = $assignment->id; // Assuming you have $postId available
                $fileEntry->path = 'assignments/' . $request->batch_id . '/' . $temp_assignment->filename;
                $fileEntry->file_type = $temp_assignment->file_type;
                $fileEntry->save();

                Storage::deleteDirectory('assignments/temp/'.$temp_assignment->folder);
                $temp_assignment->delete();
            }
        }
        return redirect()->back()->with('success', 'Assigned successfully.');;
    }

    // public function post_assignment(Request $request){
    //     return $request->all();
    // }
}
