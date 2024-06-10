<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\NotificationSendController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $courses = Course::where('available', true)->get();
    return view('welcome', compact('courses'));
})->name('home');

Route::get('/unavailable', function () {
    return view('unauthorized');
})->name('unauthorized');


Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::get('/website', [SuperAdminController::class, 'website'])->name('website');

    Route::prefix('courses')->group(function () {
        Route::get('/offers', [SuperAdminController::class, 'courses_offers'])->name('courses');
        Route::post('/add_course', [SuperAdminController::class, 'add_course'])->name('add_course');
        Route::get('/edit_course/{id}', [SuperAdminController::class, 'edit_course'])->name('edit_course');
        Route::delete('/delete_course/{id}', [SuperAdminController::class, 'delete_course'])->name('delete_course');
        Route::post('/course_toggle',  [SuperAdminController::class, 'course_toggle'])->name('course_toggle');

        Route::get('/{id}/enrollees', [SuperAdminController::class, 'enrollees'])->name('course_enrollees');
        Route::get('/generate_batch_name', [SuperAdminController::class, 'generate_batch_name'])->name('generate_batch_name');
        Route::post('/create_batch', [SuperAdminController::class, 'create_batch'])->name('create_batch');
        Route::post('/add_to_batch', [SuperAdminController::class, 'add_to_batch'])->name('add_to_batch');

        // Route::get('/text_input_post', [SuperAdminController::class, 'text_input_post'])->name('text_input_post');
        
        
        
        // Route::get('/enrollees', [SuperAdminController::class, 'courses_enrollees'])->name('enrollees');
    });

    Route::get('/scan_attendance', [SuperAdminController::class, 'scan_attendance'])->name('scan_attendance');
    Route::post('/get_scan_data', [SuperAdminController::class, 'get_scan_data'])->name('get_scan_data');
    Route::post('/submit_f2f_attendance', [SuperAdminController::class, 'submit_f2f_attendance'])->name('submit_f2f_attendance');
    Route::get('/all_users', [SuperAdminController::class, 'all_users'])->name('all_users');
    
});

Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    // Enrollment
    Route::get('/enroll/{id}', [StudentController::class, 'enroll'])->name('enroll');
    Route::post('/enroll_save', [StudentController::class, 'enroll_save'])->name('enroll_save');
    Route::get('/enroll_requirements/{enrollee}', [StudentController::class, 'enroll_requirements'])->name('enroll_requirements');
    Route::get('/already_enrolled', [StudentController::class, 'already_enrolled'])->name('already_enrolled');
    Route::post('/upload_requirement', [StudentController::class, 'upload_requirement'])->name('upload_requirement');
    Route::delete('/revert_requirement', [StudentController::class, 'revert_requirement'])->name('revert_requirement');
    Route::get('/get_requirement/{enrolee_id}/{type}', [StudentController::class, 'get_requirement'])->name('get_requirement');
    Route::get('/load_requirement/{enrollee_id}/{type}/{source}', [StudentController::class, 'load_requirement'])->name('load_requirement');
    Route::delete('/delete_requirement/{enrollee_id}/{type}/{source}', [StudentController::class, 'delete_requirement'])->name('delete_requirement');
    Route::post('/check_user_requirements', [StudentController::class, 'check_user_requirements'])->name('check_user_requirements');
    Route::post('/enroll_requirements_save', [StudentController::class, 'enroll_requirements_save'])->name('enroll_requirements_save');

    Route::get('/course_completed', [StudentController::class, 'course_completed'])->name('course_completed');

    
    // Stream / Posts
    Route::get('/enrolled_course', [StudentController::class, 'enrolled_course'])->name('enrolled_course');
    Route::get('/enrolled_course_assignment', [StudentController::class, 'enrolled_course_assignment'])->name('enrolled_course_assignment');
    
    //Assignments
    Route::get('/view_assignment/{id}', [StudentController::class, 'view_assignment'])->name('view_assignment');
    Route::post('/turn_in_status', [StudentController::class, 'turn_in_status'])->name('turn_in_status');
    Route::post('/assignment_action', [StudentController::class, 'assignment_action'])->name('assignment_action');
    
    //Filepond Assignment
    Route::post('/turn_in_files', [StudentController::class, 'turn_in_files'])->name('turn_in_files');
    Route::post('/turn_in_links', [StudentController::class, 'turn_in_links'])->name('turn_in_links');
    Route::get('/load_files/{batch_id}/{file_id}', [StudentController::class, 'load_files'])->name('load_files');
    Route::get('/get_files/{assignment_id}', [StudentController::class, 'get_files'])->name('get_files');
    Route::delete('/delete_file/{batch_id}/{assignment_id}/{id}', [StudentController::class, 'delete_file'])->name('delete_file');
    Route::delete('/revert', [StudentController::class, 'revert'])->name('revert');

    //Message
    Route::get('/message/{id}', [StudentController::class, 'message'])->name('message');
    Route::get('/get_messages/{id}', [StudentController::class, 'get_messages'])->name('get_messages');
    Route::get('/message_list', [StudentController::class, 'message_list'])->name('message_list');
    Route::post('/send_message', [StudentController::class, 'send_message'])->name('send_message');
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendMesssageNotification'])->name('send.web-notification');

    //ID CARD
    Route::get('/generateIDCard/{id}', [StudentController::class, 'generateIDCard'])->name('generateIDCard');
});

Route::middleware(['auth', 'verified', 'role:instructor'])->group(function () {
    Route::get('/batch_list', [InstructorController::class, 'batch_list'])->name('batch_list');
    Route::get('/batch_posts/{id}', [InstructorController::class, 'batch_posts'])->name('batch_posts');
    Route::get('/batch_members', [InstructorController::class, 'batch_members'])->name('batch_members');
    Route::get('/batch_assignments/{batch_id}', [InstructorController::class, 'batch_assignments'])->name('batch_assignments');
    //Route::get('/review_turn_ins/{assignment_id}', [InstructorController::class, 'review_turn_ins'])->name('review_turn_ins');
    Route::get('/list_turn_ins/{assignment_id}', [InstructorController::class, 'list_turn_ins'])->name('list_turn_ins');
    Route::get('/batch_attendance/{batch_id}', [InstructorController::class, 'batch_attendance'])->name('batch_attendance');
    
    //Post (for Stream)
    Route::post('/post', [InstructorController::class, 'post'])->name('post');
    
    // Assignment
    Route::post('/post_assignment', [InstructorController::class, 'post_assignment'])->name('post_assignment');
    Route::get('/get_assignment/{id}', [InstructorController::class, 'get_assignment'])->name('get_assignment');
    // Route::post('/edit_assignment', [InstructorController::class, 'edit_assignment'])->name('edit_assignment');
    Route::post('/assignment_toggle', [InstructorController::class, 'assignment_toggle'])->name('assignment_toggle');
    
    //Grading
    Route::post('/update_grade', [InstructorController::class, 'update_grade'])->name('update_grade');
    
    //Filepond Assignment (in batch_posts)
    Route::post('/temp_upload_assignment', [InstructorController::class, 'temp_upload_assignment'])->name('temp_upload_assignment');
    Route::get('/get_assignment_files/{batch_id}', [InstructorController::class, 'get_assignment_files'])->name('get_assignment_files');
    Route::get('/load_assignment_files/{batch_id}/{file_id}', [InstructorController::class, 'load_assignment_files'])->name('load_assignment_files');
    Route::delete('/revert_assignment_file', [InstructorController::class, 'revert_assignment_file'])->name('revert_assignment_file');
    Route::delete('/delete_assignment_file/{batch_id}/{id}', [InstructorController::class, 'delete_assignment_file'])->name('delete_assignment_file');
    
    //Filepond Assignment for Editing (in list_turn_ins)
    Route::get('/get_uploaded_assignment_files/{assignment_id}', [InstructorController::class, 'get_uploaded_assignment_files'])->name('get_uploaded_assignment_files');
    Route::delete('/delete_uploaded_assignment_file/{assignment_id}/{id}', [InstructorController::class, 'delete_uploaded_assignment_file'])->name('delete_uploaded_assignment_file');

    //Lesson (to be Learning Outcome)
    Route::post('/add_lesson', [InstructorController::class, 'add_lesson'])->name('add_lesson');
    Route::post('/edit_lesson', [InstructorController::class, 'edit_lesson'])->name('edit_lesson');
    Route::post('/get_lessons', [InstructorController::class, 'get_lessons'])->name('get_lessons');
    Route::delete('/delete_lesson/{lesson_id}', [InstructorController::class, 'delete_lesson'])->name('delete_lesson');

    //Attendace
    Route::post('/save_attendance', [InstructorController::class, 'save_attendance'])->name('save_attendance');
    Route::post('/get_attendance_data', [InstructorController::class, 'get_attendance_data'])->name('get_attendance_data');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
