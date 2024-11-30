<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;

Route::get('/two', function () {
return view('welcome');
});

Route::get('/', [QuestionController::class, 'index']);
Auth::routes();

Route::get('/', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create')->middleware('auth');
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store')->middleware('auth');
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');


//delete answer andquestion
Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/three', [QuestionController::class, 'create'])->name('question.create')->middleware('auth');

// Answer routes
Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store')->middleware('auth');
Route::get('/one', [Controller::class, 'hello']);

// Toggle comments for a question
Route::patch('/questions/{question}/toggle-comments', [QuestionController::class, 'toggleComments'])
->name('questions.toggleComments')
->middleware('auth');

// Highlight an answer
Route::patch('/answers/{answer}/highlight', [AnswerController::class, 'highlightAnswer'])
->name('answers.highlight')
->middleware('auth');




Route::middleware(['admin'])->get('/test-admin', function () {
return 'You are an admin!';
});

Route::get('/debug-user', function () {
return Auth::user();
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Auth routes
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');