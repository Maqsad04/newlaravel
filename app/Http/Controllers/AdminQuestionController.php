<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Notifications\QuestionRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminQuestionController extends Controller
{
    // Display all pending questions
    public function index()
    {
        $questions = Question::where('status', 'pending')->get(); // Only show pending questions
        return view('admin.questions.index', compact('questions'));
    }

    // Accept a question
    public function accept($id)
    {
        $question = Question::findOrFail($id);
        $question->status = 'accepted';
        $question->save();

        return redirect()->route('admin.questions.index')->with('success', 'Question accepted and moved to the main panel.');
    }

    // Reject a question
    // public function reject($id)
    // {
    //     $question = Question::findOrFail($id);
    //     $question->status = 'rejected';
    //     $question->save();
    //     // unset($question);

    //     // Notify the user about the rejection
    //     $user = $question->user;
    //     $user->notify(new QuestionRejectedNotification($question));

    //     return redirect()->route('admin.questions.index')->with('success', 'Question rejected, and the user has been notified.');
    // }

    

    public function reject($id)
    {
        $question = Question::findOrFail($id);
        $question->status = 'rejected';
    
        Log::info('Before saving question:', ['id' => $question->id, 'status' => $question->status]);
        $question->save();
        Log::info('After saving question:', ['id' => $question->id, 'status' => $question->status]);
    
        $user = $question->user;
        $user->notify(new QuestionRejectedNotification($question));
    
        return redirect()->route('admin.questions.index')->with('success', 'Question rejected, and the user has been notified.');
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:accepted,rejected',
    ]);

    $question = Question::findOrFail($id);
    $question->status = $request->status;
    $question->save();

    return redirect()->back()->with('success', 'Question status updated successfully.');
}



// public function approve($id)
// {
//     $question = Question::findOrFail($id);
//     $question->status = 'approved';
//     $question->save();

//     return redirect()->back()->with('success', 'Question approved successfully.');
// }






}