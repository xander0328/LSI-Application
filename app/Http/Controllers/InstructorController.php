<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Post;
use App\Models\Files;

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
}
