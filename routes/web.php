<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/website', [SuperAdminController::class, 'website'])->name('website');

    Route::prefix('courses')->group(function () {
        Route::get('/offers', [SuperAdminController::class, 'courses_offers'])->name('courses');
        Route::post('/add_course', [SuperAdminController::class, 'add_course'])->name('add_course');
        Route::get('/edit_course/{id}', [SuperAdminController::class, 'edit_course'])->name('edit_course');
        Route::delete('/delete_course/{id}', [SuperAdminController::class, 'delete_course'])->name('delete_course');
        
        Route::get('/enrollees', [SuperAdminController::class, 'courses_enrollees'])->name('enrollees');
    });
    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
