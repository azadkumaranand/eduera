<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);
Route::get('/course/{id}/coursedetails', [HomeController::class, 'courseDetails'])->name('coursedetails');
Route::get('/test/{id}/start', [TestController::class, 'showQuestion'])->name('test.start');
Route::get('/test/{id}/detail', [TestController::class, 'showTestDetails'])->name('test.detail');
Route::post('/test/submit', [TestController::class, 'storeUsreAnswer'])->name('test.submit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'role:teacher'])->group(function(){
    // Set names for course resource routes
    Route::get('/teacher', function(){
        return view('teacher.page');
    });
    
    Route::resource('courses', CourseController::class)->names([
        'index' => 'courses.index',
        'create' => 'courses.create',
        'store' => 'courses.store',
    ]);

    Route::get('courses/{id}/customize/', [CourseController::class, 'edit'])->name('courses.customize');
    Route::post('courses/{id}/update/', [CourseController::class, 'update'])->name('courses.update');

    Route::resource('chapters', ChapterController::class)->names([
        'index' => 'chapters.index',
        'create' => 'chapters.create',
        'store' => 'chapters.store',
    ]);
    Route::get('chapter/{id}/customize/', [ChapterController::class, 'edit'])->name('chapter.customize');
    Route::post('chapter/{id}/update/', [ChapterController::class, 'update'])->name('chapter.update');

    // test routes
    Route::get('teacher/test/', [TestController::class, 'show'])->name('teacher.test');
    Route::get('teacher/test/mcq', [TestController::class, 'showmcqpage'])->name('teacher.test.mcq');
    Route::post('teacher/test/store', [TestController::class, 'storeTest'])->name('teacher.test.store');
    Route::get('teacher/test/create', [TestController::class, 'createTest'])->name('teacher.test.create');
    Route::get('teacher/test/{id}/customize', [TestController::class, 'customizeTest'])->name('teacher.test.customize');
    Route::post('teacher/test/{id}/update', [TestController::class, 'updateTest'])->name('teacher.test.update');
    Route::post('teacher/test/mcq/store', [TestController::class, 'storeMcqQuestion'])->name('teacher.test.mcq.store');
    Route::get('teacher/test/mcq/{id}/customize', [TestController::class, 'customizeMcq'])->name('test.mcq.customize');
    Route::post('teacher/test/mcq/{id}/update', [TestController::class, 'updateMcq'])->name('test.mcq.update');
});


require __DIR__.'/auth.php';
