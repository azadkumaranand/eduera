<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChapterContentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\JitsiController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Test\ResultController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GoogleAuthController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about']);
Route::get('/web/courses', [HomeController::class, 'allCourse']);
Route::get('/course/{id}/coursedetails', [HomeController::class, 'courseDetails'])->name('coursedetails');
Route::get('/test/{id}/detail', [TestController::class, 'showTestDetails'])->name('test.detail');



Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);


Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/create-order', [PaymentController::class, 'createOrder'])->name('payment.createOrder');
Route::post('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');


Route::get('/checkout-success', function () {
    return view('checkout-success');
})->name('checkout-success');

Route::get('/checkout-cancel', function () {
    return view('checkout-cancel');
})->name('checkout-cancel');


Route::get('/privecy-policy', function(){
    return view('policy.policy');
})->name('privecy-policy');
Route::get('/terms-conditions', function(){
    return view('policy.terms-conditions');
})->name('terms-conditions');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:student'])->group(function(){
    Route::get('/test/{id}/start', [TestController::class, 'showQuestion'])->name('test.start');
    Route::post('/test/submit', [TestController::class, 'storeUsreAnswer'])->name('test.submit');
    Route::get('/results/{testId}', [ResultController::class, 'showResults'])->name('results.show');
    Route::get('/chapter/{id}/chapterdetails', [HomeController::class, 'chapterDetails'])->name('chapterdetails');
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
    Route::post('chapter/content/store/', [ChapterContentController::class, 'store'])->name('chapter.content.store');
    Route::get('content/{id}/customize', [ChapterController::class, 'contentCustomize'])->name('content.customize');
    Route::post('content/update', [ChapterContentController::class, 'contentUpdate'])->name('content.update');
    Route::get('content/{id}/delete', [ChapterContentController::class, 'contentDelete'])->name('content.delete');

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
    Route::get('teacher/test/mcq/result', [TestController::class, 'showTestResult'])->name('test.mcq.result');
    Route::get('teacher/test/{id}/mcq/delete', [TestController::class, 'deleteMcq'])->name('test.mcq.delete');
});


require __DIR__.'/auth.php';
