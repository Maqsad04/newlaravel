<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminQuestionController;


Route::get('/two', function () {
return view('welcome');
});

Route::get('/', [QuestionController::class, 'index']);
Auth::routes();

Route::get('/', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create')->middleware('auth');
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store')->middleware('auth');
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show')->middleware('auth');


//delete answer andquestion
Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    // Route::get('/admin', [AdminUserController::class, 'hellooo'])->name('admin.dashboard');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/my-questions', [Controller::class, 'index'])->name('user.index');
});


// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
// });

// Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');


Route::get('/three', [QuestionController::class, 'create'])->name('question.create')->middleware('auth');

// Answer routes
Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store')->middleware('auth');
Route::get('/one', function(){
    return view('home');
});

// Toggle comments for a question
Route::patch('/questions/{question}/toggle-comments', [QuestionController::class, 'toggleComments'])
->name('questions.toggleComments')
->middleware('auth');

// Highlight an answer
Route::patch('/answers/{answer}/highlight', [AnswerController::class, 'highlightAnswer'])
->name('answers.highlight')
->middleware('auth');


Route::post('/men', function(){
    return("hello one");
});

// Admin Question Management Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/questions', [AdminQuestionController::class, 'index'])->name('admin.questions.index'); // List of questions
    Route::post('/questions/{id}/accept', [AdminQuestionController::class, 'accept'])->name('admin.questions.accept'); // Accept question
    Route::post('/questions/{id}/reject', [AdminQuestionController::class, 'reject'])->name('admin.questions.reject'); // Reject question
});


Route::post('/questions/{id}/status', [AdminQuestionController::class, 'updateStatus'])->name('questions.updateStatus');

// Route::middleware(['auth' ,'role:admin'])->group(function () {
//     Route::post('/questions/{id}/approve', [AdminQuestionController::class, 'approve'])->name('questions.approve');
//     Route::post('/questions/{id}/reject', [AdminQuestionController::class, 'reject'])->name('questions.reject');
// });

// Route::get('/four', [AdminQuestionController::class, 'index']);



// Route::middleware(['admin'])->get('/test-admin', function () {
// return 'You are an admin!';
// });

// Route::middleware(['admin'])->get('/admin', function(){
//     return view('admin.dashboard');
// });




Route::get('/debug-user', function () {
return Auth::user();
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
Route::get('/queue', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Auth routes
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');