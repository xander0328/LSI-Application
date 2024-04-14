<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Enrollee;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Post;
use App\Models\Files;
use App\Models\Education;
use App\Models\EnrolleeFiles;

class StudentController extends Controller
{
    public function enrolled_course()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $enrollee = Enrollee::where('user_id', $user_id)->first();
        if($enrollee){
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
        }else{
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

        if(isset($enrollee->id))
        $hasRequirements = EnrolleeFiles::where('enrollee_id', $enrollee->id)->exists();

        if ($enrollee) {
            if(!$hasRequirements)
                return view('student.enroll_requirements', compact('enrollee'));
            else
                return view('student.already_enrolled');
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

                    if(array_key_exists('educational_level', $edu) ){
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
            // print_r($numberOfEduc);
            $enrollee = $enrollee_id;

            return redirect()->route('enroll_requirements', compact('enrollee'));
        }
    }

    public function enroll_requirements($enrollee){
        return view('student.enroll_requirements', compact('enrollee'));
    }

    public function already_enrolled()
    {
        return view('student.already_enrolled');
    }

    public function enroll_requirements_save(Request $request) {
        $request->all();
        $directory = 'enrollee_files/'. $request->enrollee_id;
        $path = [];
        foreach(['valid_id', 'diploma_tor', 'birth_certificate', 'id_picture'] as $name){
            $file = $request->file($name);
            $extension = $file->getClientOriginalExtension();
            $path[$name] = $file->storeAs($directory, $name . '_' . $request->enrollee_id.'.'.$extension, 'public');
            
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

    public function course_completed(){
        $user = auth()->user();
        $completed = Enrollee::where('user_id', $user->id)
        ->whereNotNull('completed_at')
        ->get();

        return view('student.course_completed', compact('completed'));
    }
}