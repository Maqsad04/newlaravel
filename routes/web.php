<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminQuestionController;


Route::get('/two', function () {
return view('welcome');
});

Route::get('/', [QuestionController::class, 'index']);
Auth::routes();

Route::get('/', [QuestionController::class, 'index'])->name('questions.index');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/maqsad', [QuestionController::class, 'maqsad'])->name('welcome');
});
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create')->middleware('auth');
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store')->middleware('auth');
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show')->middleware('auth');


//delete answer and question
Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    // Route::get('/admin', [AdminUserController::class, 'hellooo'])->name('admin.dashboard');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/my-questions', [Controller::class, 'index'])->name('user.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/questions', [ProfileController::class, 'getQuestions'])->name('profile.questions');
});



Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store')->middleware('auth');

Route::patch('/questions/{question}/toggle-comments', [QuestionController::class, 'toggleComments'])
->name('questions.toggleComments')
->middleware('auth');


Route::patch('/answers/{answer}/highlight', [AnswerController::class, 'highlightAnswer'])
->name('answers.highlight')
->middleware('auth');

Route::patch('/answers/{answer}/unhighlight', [AnswerController::class, 'unhighlightAnswer'])
->name('answers.unhighlight')
->middleware('auth');




Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/questions', [AdminQuestionController::class, 'index'])->name('admin.questions.index'); // List of questions
    // Route::post('/questions/{id}/status', [AdminQuestionController::class, 'updateStatus'])->name('questions.updateStatus');
    Route::post('/questions/{id}/accept', [AdminQuestionController::class, 'accept'])->name('admin.questions.accept'); // Accept question
    Route::post('/questions/{id}/reject', [AdminQuestionController::class, 'reject'])->name('admin.questions.reject'); // Reject question
    Route::post('/questions/{id}/status', [AdminQuestionController::class, 'updateStatus'])->name('questions.updateStatus');
    Route::get('/questions/data', [AdminQuestionController::class, 'getQuestionsData'])->name('admin.questions.data');
    Route::patch('/users/{user}/toggle-block', [AdminUserController::class, 'toggleBlock'])->name('admin.users.toggleBlock');
    Route::get('/youcan', [AdminController::class, 'index'])->name('admin.dashboard');
});


Route::post('/questions/{id}/status', [AdminQuestionController::class, 'updateStatus'])->name('questions.updateStatus');


Route::get('/debug-user', function () {
return Auth::user();
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');