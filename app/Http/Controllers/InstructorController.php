<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Post;

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
}
