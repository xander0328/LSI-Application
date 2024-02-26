<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\StudentController;
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
    return view('welcome');
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


        // Route::get('/enrollees', [SuperAdminController::class, 'courses_enrollees'])->name('enrollees');
    });
    
});

Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::get('/enrolled_course', [StudentController::class, 'enrolled_course'])->name('enrolled_course');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
