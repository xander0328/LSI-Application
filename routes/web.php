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

        Route::get('/text_input_post', [SuperAdminController::class, 'text_input_post'])->name('text_input_post');
        

        // Route::get('/enrollees', [SuperAdminController::class, 'courses_enrollees'])->name('enrollees');
    });
    
});

Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::get('/enroll/{id}', [StudentController::class, 'enroll'])->name('enroll');
    Route::post('/enroll_save', [StudentController::class, 'enroll_save'])->name('enroll_save');
    Route::get('/enroll_requirements/{enrollee}', [StudentController::class, 'enroll_requirements'])->name('enroll_requirements');
    Route::post('/enroll_requirements_save', [StudentController::class, 'enroll_requirements_save'])->name('enroll_requirements_save');
    Route::get('/already_enrolled', [StudentController::class, 'already_enrolled'])->name('already_enrolled');

    Route::get('/course_completed', [StudentController::class, 'course_completed'])->name('course_completed');
    
    Route::get('/enrolled_course', [StudentController::class, 'enrolled_course'])->name('enrolled_course');
    Route::get('/enrolled_course_assignment', [StudentController::class, 'enrolled_course_assignment'])->name('enrolled_course_assignment');
    Route::get('/view_assignment/{id}', [StudentController::class, 'view_assignment'])->name('view_assignment');
    Route::post('/turn_in_assignment', [StudentController::class, 'turn_in_assignment'])->name('turn_in_assignment');

    //Message
    Route::get('/message/{id}', [StudentController::class, 'message'])->name('message');
    Route::get('/get_messages/{id}', [StudentController::class, 'get_messages'])->name('get_messages');
    Route::get('/message_list', [StudentController::class, 'message_list'])->name('message_list');
    Route::post('/send_message', [StudentController::class, 'send_message'])->name('send_message');
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});

Route::middleware(['auth', 'verified', 'role:instructor'])->group(function () {
    Route::get('/batch_list', [InstructorController::class, 'batch_list'])->name('batch_list');
    Route::get('/batch_posts/{id}', [InstructorController::class, 'batch_posts'])->name('batch_posts');
    Route::get('/batch_members', [InstructorController::class, 'batch_members'])->name('batch_members');
    Route::post('/post', [InstructorController::class, 'post'])->name('post');
    Route::post('/post_assignment', [InstructorController::class, 'post_assignment'])->name('post_assignment');
    Route::post('batch_posts/{id}/temp_upload_assignment', [InstructorController::class, 'temp_upload_assignment'])->name('temp_upload_assignment');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
