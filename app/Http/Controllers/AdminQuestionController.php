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
        $questions = Question::with('user')->get();
        // $questions = Question::where('status', 'pending')->get(); // Only show pending questions
        return view('admin.questions', compact('questions'));
    }

    public function getQuestionsData()
    {
        $questions = Question::with('user')->get();
        return response()->json($questions);
    }
    


    // Accept a question
    public function accept($id)
    {
        $question = Question::findOrFail($id);
        $question->status = 'accepted';
        $question->save();
        return redirect()->route('admin.questions')->with('success', 'Question accepted and moved to the main panel.');
    }

   

    // public function reject($id)
    // {
    //     $question = Question::findOrFail($id);
    //     $question->status = 'rejected';
    
    //     Log::info('Before saving question:', ['id' => $question->id, 'status' => $question->status]);
    //     $question->save();
    //     Log::info('After saving question:', ['id' => $question->id, 'status' => $question->status]);
    
    //     $user = $question->user;
    //     $user->notify(new QuestionRejectedNotification($question));
    
    //     return redirect()->route('admin.questions.index')->with('success', 'Question rejected, and the user has been notified.');
    // }

    public function reject($id)
    {
        $question = Question::findOrFail($id);
        $question->status = 'rejected';
        $question->save();
        return redirect()->back()->with('success', 'Question rejected successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $status = $request->input('status'); // Get status from form input
        if (!in_array($status, ['accepted', 'deleted'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }
        $question->status = $status;
        $question->save();
        return redirect()->back()->with('success', 'Question status updated successfully.');
    }




}