<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\NotificationSendController;
use App\Http\Controllers\SessionController;
use App\Models\Course;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Facades\Auth;
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
    $courses = Course::where('featured', true)->get();
    $user = null;
    if(Auth::check()){
        $query = User::query();
        if(auth()->user()->role == 'instructor'){
            $query->with('instructor_info');
        }
        $user = $query->find(auth()->user()->id);
    }
    
    return view('welcome', compact('courses', 'user'));
})->name('home');

Route::get('/unavailable', function () {
    return view('unauthorized');
})->name('unauthorized');


Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::prefix('dashboard')->group(function(){
        Route::get('/', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    });

    Route::get('/website', [SuperAdminController::class, 'website'])->name('website');

    Route::prefix('courses')->group(function () {
        Route::get('/offers', [SuperAdminController::class, 'courses_offers'])->name('courses');
        Route::post('/add_course', [SuperAdminController::class, 'add_course'])->name('add_course');
        Route::get('/edit_course/{id}', [SuperAdminController::class, 'edit_course'])->name('edit_course');
        Route::post('/delete_course', [SuperAdminController::class, 'delete_course'])->name('delete_course');
        Route::post('/course_toggle',  [SuperAdminController::class, 'course_toggle'])->name('course_toggle');
        Route::post('/feature_toggle',  [SuperAdminController::class, 'feature_toggle'])->name('feature_toggle');

        Route::post('/add_course_category',  [SuperAdminController::class, 'add_course_category'])->name('add_course_category');
        Route::post('/edit_course_category',  [SuperAdminController::class, 'edit_course_category'])->name('edit_course_category');
        Route::post('/delete_course_category',  [SuperAdminController::class, 'delete_course_category'])->name('delete_course_category');

        Route::get('/{id}/enrollees', [SuperAdminController::class, 'enrollees'])->name('course_enrollees');
        Route::get('/{id}/enrollees/{page}', [SuperAdminController::class, 'load_more_enrollees'])->name('load_more_enrollees');
        Route::post('/get_enrollee_records', [SuperAdminController::class, 'get_enrollee_records'])->name('get_enrollee_records');
        
        // Defaults
        Route::get('/load_default_id/{source}', [SuperAdminController::class, 'load_default_id'])->name('load_default_id');
        Route::post('/upload_default_id', [SuperAdminController::class, 'upload_default_id'])->name('upload_default_id');
        Route::delete('/revert_default_id', [SuperAdminController::class, 'revert_default_id'])->name('revert_default_id');
        Route::delete('/delete_default_id/{file_id}', [SuperAdminController::class, 'delete_default_id'])->name('delete_default_id');
        
        // ID Template
        Route::get('/load_id_template/{source}', [SuperAdminController::class, 'load_id_template'])->name('load_id_template');
        Route::post('/upload_id_template', [SuperAdminController::class, 'upload_id_template'])->name('upload_id_template');
        Route::delete('/revert_id_template', [SuperAdminController::class, 'revert_id_template'])->name('revert_id_template');
        Route::delete('/delete_id_template/{file_id}', [SuperAdminController::class, 'delete_id_template'])->name('delete_id_template');
        
        // Enrollees
        Route::post('/remove_enrollee', [SuperAdminController::class, 'remove_enrollee'])->name('remove_enrollee');
        
        // Enrollee Batch
        Route::post('/create_new_batch', [SuperAdminController::class, 'create_new_batch'])->name('create_new_batch');
        Route::post('/create_batch', [SuperAdminController::class, 'create_batch'])->name('create_batch');
        Route::post('/delete_batch', [SuperAdminController::class, 'delete_batch'])->name('delete_batch');
        Route::post('/add_to_batch', [SuperAdminController::class, 'add_to_batch'])->name('add_to_batch');
        Route::post('/get_course_batches', [SuperAdminController::class, 'get_course_batches'])->name('get_course_batches');
        Route::post('/get_batch_data', [SuperAdminController::class, 'get_batch_data'])->name('get_batch_data');
        Route::post('/unassign_instructor', [SuperAdminController::class, 'unassign_instructor'])->name('unassign_instructor');
        Route::post('/get_all_instructors', [SuperAdminController::class, 'get_all_instructors'])->name('get_all_instructors');
        Route::post('/assign_instructor', [SuperAdminController::class, 'assign_instructor'])->name('assign_instructor');

        // Upload Course Image (FilePond)
        Route::post('/upload_course_image', [SuperAdminController::class, 'upload_course_image'])->name('upload_course_image');
        Route::delete('/revert_course_image', [SuperAdminController::class, 'revert_course_image'])->name('revert_course_image');
        Route::get('/load_course_image/{action}/{source}', [SuperAdminController::class, 'load_course_image'])->name('load_course_image');
        Route::delete('/delete_course_image/{action}/{file_id}', [SuperAdminController::class, 'delete_course_image'])->name('delete_course_image');
        
        
        // Route::get('/text_input_post', [SuperAdminController::class, 'text_input_post'])->name('text_input_post');
        // Route::get('/enrollees', [SuperAdminController::class, 'courses_enrollees'])->name('enrollees');
    });
    
    Route::get('/show_enrollee_file/{id}', [SuperAdminController::class, 'show_diploma'])->name('show_enrollee_file');

    Route::prefix('users')->group(function () {
        Route::get('/', [SuperAdminController::class, 'all_users'])->name('users');
        Route::post('/disable_user', [SuperAdminController::class, 'disable_user'])->name('disable_user');
        Route::post('/get_user_records', [SuperAdminController::class, 'get_user_records'])->name('get_user_records');
        Route::get('/load_more_users', [SuperAdminController::class, 'load_more_users'])->name('load_more_users');
        Route::get('/search_user', [SuperAdminController::class, 'search_user'])->name('search_user');
        Route::post('/remove_session', [SuperAdminController::class, 'remove_session'])->name('remove_session');
        Route::post('/promote_user', [SuperAdminController::class, 'promote_user'])->name('promote_user');
        
        Route::post('/get_enrollee_data', [SuperAdminController::class, 'get_enrollee_data'])->name('get_enrollee_data');

    });
    
    Route::prefix('payments')->group(function () {
        Route::get('/', [SuperAdminController::class, 'payments'])->name('payments');
        Route::post('/make_payment', [SuperAdminController::class, 'make_payment'])->name('make_payment');
        Route::post('/make_refund', [SuperAdminController::class, 'make_refund'])->name('make_refund');
        Route::post('/get_payment_details', [SuperAdminController::class, 'get_payment_details'])->name('get_payment_details');
    
    });

    Route::prefix('instructors')->group(function () {
        Route::get('/', [SuperAdminController::class, 'instructors'])->name('instructors');
        Route::post('/get_instructor_info', [SuperAdminController::class, 'get_instructor_info'])->name('get_instructor_info');
    
    });

    //For testing only
    Route::get('/updateAllPass', [SuperAdminController::class, 'updateAllPass'])->name('updateAllPass');



    Route::get('/scan_attendance', [SuperAdminController::class, 'scan_attendance'])->name('scan_attendance');
    Route::post('/get_scan_data', [SuperAdminController::class, 'get_scan_data'])->name('get_scan_data');
    Route::post('/submit_f2f_attendance', [SuperAdminController::class, 'submit_f2f_attendance'])->name('submit_f2f_attendance');
    Route::get('/all_users', [SuperAdminController::class, 'all_users'])->name('all_users');
    
});

Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::get('/course_completed', [StudentController::class, 'course_completed'])->name('course_completed');

    Route::prefix('course')->group(function () {
    // Stream / Posts
        // Route::get('/enrolled_course', [StudentController::class, 'enrolled_course'])->name('enrolled_course');
        Route::get('/enrolled_course_assignment', [StudentController::class, 'enrolled_course_assignment'])->name('enrolled_course_assignment');
        
    // Assignment
        Route::get('/view_assignment/{id}', [StudentController::class, 'view_assignment'])->name('view_assignment');
        Route::post('/turn_in_status', [StudentController::class, 'turn_in_status'])->name('turn_in_status');
        Route::post('/assignment_action', [StudentController::class, 'assignment_action'])->name('assignment_action');
        Route::post('/upload_links', [StudentController::class, 'upload_links'])->name('upload_links');
    
    //Comments
        Route::get('/comments/{batch_id}/{post_id}', [StudentController::class, 'comments'])->name('student.comments');
        Route::post('/add_comment', [InstructorController::class, 'add_comment'] )->name('student.add_comment');
    });

    //Filepond Assignment
    Route::post('/turn_in_files', [StudentController::class, 'turn_in_files'])->name('turn_in_files');
    Route::post('/turn_in_links', [StudentController::class, 'turn_in_links'])->name('turn_in_links');
    Route::get('/load_files/{batch_id}/{assignment_id}/{file_id}', [StudentController::class, 'load_files'])->name('load_files');
    Route::get('/get_files/{assignment_id}', [StudentController::class, 'get_files'])->name('get_files');
    Route::delete('/delete_file/{batch_id}/{assignment_id}/{id}', [StudentController::class, 'delete_file'])->name('delete_file');
    Route::delete('/revert', [StudentController::class, 'revert'])->name('revert');

    // Attendance
    Route::get('/enrolled_course_attendance', [StudentController::class, 'enrolled_course_attendance'])->name('enrolled_course_attendance');

    //Message
    Route::prefix('message')->group(function () {
        Route::get('/{id}', [StudentController::class, 'message'])->name('message');
        Route::get('/get_messages/{id}', [StudentController::class, 'get_messages'])->name('get_messages');
        Route::get('/message_list', [StudentController::class, 'message_list'])->name('message_list');
        Route::post('/send_message', [StudentController::class, 'send_message'])->name('send_message');
    });
    
    //ID CARD
    Route::get('/generateIDCard/{id}', [StudentController::class, 'generateIDCard'])->name('generateIDCard');
    Route::get('/idcard', [StudentController::class, 'show_id_card'])->name('idcard');
    Route::get('/id_card/{id}', [StudentController::class, 'id_card'])->name('id_card');
    
});

Route::middleware(['auth', 'verified', 'role:instructor'])->group(function () {
    // Batch List
    Route::get('/batch_list', [InstructorController::class, 'batch_list'])->name('batch_list');
    Route::post('/get_batch_info', [InstructorController::class, 'get_batch_info'])->name('get_batch_info');
    Route::post('/close_batch', [InstructorController::class, 'close_batch'])->name('close_batch');
    
    Route::get('/batch_posts/{id}', [InstructorController::class, 'batch_posts'])->name('batch_posts');
    Route::get('/batch_members', [InstructorController::class, 'batch_members'])->name('batch_members');
    Route::get('/batch_assignments/{batch_id}', [InstructorController::class, 'batch_assignments'])->name('batch_assignments');
    //Route::get('/review_turn_ins/{assignment_id}', [InstructorController::class, 'review_turn_ins'])->name('review_turn_ins');
    Route::get('/list_turn_ins/{assignment_id}', [InstructorController::class, 'list_turn_ins'])->name('list_turn_ins');
    Route::get('/batch_attendance/{batch_id}', [InstructorController::class, 'batch_attendance'])->name('batch_attendance');
    
    Route::prefix('record_information')->group(function () {
        Route::post('/', [InstructorController::class, 'record_instructor'])->name('record_instructor');
        Route::post('/upload_instructor_picture', [InstructorController::class, 'upload_instructor_picture'])->name('upload_instructor_picture');
        Route::delete('/revert_instructor_picture', [InstructorController::class, 'revert_instructor_picture'])->name('revert_instructor_picture');
        Route::get('/load_instructor_picture/{source}', [InstructorController::class, 'load_instructor_picture'])->name('load_instructor_picture');
        Route::delete('/delete_instructor_picture/{source}', [InstructorController::class, 'delete_instructor_picture'])->name('delete_instructor_picture');
    });

    //Post (for Stream)
    Route::post('/post', [InstructorController::class, 'post'])->name('post');
    Route::post('/upload_temp_post_files', [InstructorController::class, 'upload_temp_post_files'])->name('upload_temp_post_files');
    Route::delete('/revert_post_files', [InstructorController::class, 'revert_post_files'])->name('revert_post_files');
    Route::get('/load_post_files/{action}/{batch_id}/{file_id}', [InstructorController::class, 'load_post_files'])->name('load_post_files');
    Route::delete('/delete_post_files/{batch_id}/{id}', [InstructorController::class, 'delete_post_files'])->name('delete_post_files');
    Route::post('/delete_post', [InstructorController::class, 'delete_post'])->name('delete_post');

    
    // Assignment
    Route::post('/post_assignment', [InstructorController::class, 'post_assignment'])->name('post_assignment');
    Route::post('/delete_assignment', [InstructorController::class, 'delete_assignment'])->name('delete_assignment');
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
    Route::get('/get_uploaded_assignment_files/{assignment_id}/{file_id}', [InstructorController::class, 'get_uploaded_assignment_files'])->name('get_uploaded_assignment_files');
    Route::delete('/delete_uploaded_assignment_file/{assignment_id}/{id}', [InstructorController::class, 'delete_uploaded_assignment_file'])->name('delete_uploaded_assignment_file');

    //Lesson (to be Learning Outcome)
    Route::post('/add_lesson', [InstructorController::class, 'add_lesson'])->name('add_lesson');
    Route::post('/edit_lesson', [InstructorController::class, 'edit_lesson'])->name('edit_lesson');
    Route::post('/get_lessons', [InstructorController::class, 'get_lessons'])->name('get_lessons');
    Route::post('/delete_lesson', [InstructorController::class, 'delete_lesson'])->name('delete_lesson');

    // Unit of Competency
    Route::post('/add_uc', [InstructorController::class, 'add_uc'])->name('add_uc');
    Route::post('edit_uc', [InstructorController::class, 'edit_uc'])->name('edit_uc');
    Route::post('/delete_uc', [InstructorController::class, 'delete_uc'])->name('delete_uc');

    //Attendace
    Route::post('/save_attendance', [InstructorController::class, 'save_attendance'])->name('save_attendance');
    Route::post('/get_attendance_data', [InstructorController::class, 'get_attendance_data'])->name('get_attendance_data');

    //Comments 
    Route::prefix('comments')->group(function () {
        Route::get('/{batch_id}/{post_id}', [InstructorController::class, 'comments'])->name('instructor.comments');
        Route::post('/add_comment', [InstructorController::class, 'add_comment'] )->name('add_comment');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendMesssageNotification'])->name('send.web-notification');
    
    Route::post('/check_session', [SessionController::class, 'check_session'])->name('check_session');
});

Route::middleware(['auth', 'verified', 'role:guest,student'])->group(function () {
    
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
    Route::get('/formats', [StudentController::class, 'formats'])->name('formats');

    
    Route::prefix('course')->group(function () {
        // Stream / Posts
            Route::get('/enrolled_course', [StudentController::class, 'enrolled_course'])->name('enrolled_course');
    });

    Route::prefix('enrollment')->group(function () {
        Route::get('/', [StudentController::class, 'enrollment'])->name('enrollment');
        Route::post('/cancel', [StudentController::class, 'cancel_enrollment'])->name('cancel_enrollment');
    });
});



require __DIR__.'/auth.php';
