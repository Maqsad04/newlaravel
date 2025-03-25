<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()    
    {

        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Retrieve all users (except the currently logged-in admin)
        $users = User::where('id', '!=', auth()->id())->get();

        $totalUsers = User::count();
        $totalQuestions = Question::count();
        $deletedQuestions = Question::where('status', 'deleted')->count();

        $allQuestions = Question::with('user')->get(); // Include soft-deleted questions
        $chartData = [
            ['month' => 'January', 'questions' => 20],
            ['month' => 'February', 'questions' => 35],
            ['month' => 'March', 'questions' => 50],
            ['month' => 'April', 'questions' => 50]
        ];



        
        return view('admin.dashboard', compact('totalUsers', 'totalQuestions', 'deletedQuestions', 'users', 'allQuestions', 'chartData')); // Admin dashboard view
    }


    public function destroy(Question $question)
{
    // Allow only the question's creator or an admin to mark it as deleted
    if (auth()->id() !== $question->user_id && auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    // Update the question status to "deleted"
    $question->status = 'deleted';
    $question->save();

    return redirect()->route('questions.index')->with('success', 'Question marked as deleted successfully.');
}
}