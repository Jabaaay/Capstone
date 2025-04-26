<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FacialExpressionController;
use App\Http\Controllers\QuizRecordingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/tests', [AdminController::class, 'tests'])->name('admin.tests');
    Route::get('/tests/{test}', [AdminController::class, 'showTest'])->name('admin.tests.show');
    Route::get('/tests/{test}/download-pdf', [AdminController::class, 'downloadPdf'])->name('admin.test.download-pdf');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/video-feed', [AdminController::class, 'videoFeed'])->name('admin.video-feed');
});

// User Routes
Route::prefix('user')->middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/test', [UserController::class, 'testForm'])->name('user.test.form');
    Route::post('/test', [UserController::class, 'submitTest'])->name('user.test.submit');
    Route::get('/test/questions', [UserController::class, 'testQuestions'])->name('user.test.questions');
    Route::post('/test/questions', [UserController::class, 'submitAnswers'])->name('user.test.answers');
    Route::get('/test/{test_id}/download-pdf', [UserController::class, 'downloadPdf'])->name('user.test.download-pdf');
});


Route::post('/store-expression', [FacialExpressionController::class, 'store'])->name('store.expression');
Route::get('/get-most-frequent-expression/{testId}', [FacialExpressionController::class, 'getMostFrequentExpression'])->name('get.expression');
Route::get('/get-test-expressions/{testId}', [FacialExpressionController::class, 'getTestExpressions'])->name('get.test.expressions');
Route::get('/api/get-test-user/{testId}', [FacialExpressionController::class, 'getTestUser'])->name('get.test.user');
Route::post('/store-recording', [QuizRecordingController::class, 'store'])->name('store.recording');

require __DIR__.'/auth.php';
