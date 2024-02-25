<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;

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


    public function edit_course($id){
        $course = Course::find($id);
        return response()->json($course);
    }

    public function courses_enrollees(){
        return view('enrollees');
    }

    public function edit_courses_offers(){
        return view('courses');
    }
}
