<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function enrolled_course(){
        return view('student.enrolled-course');
    }
}
