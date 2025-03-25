<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
{   
    $questions = Question::where('status', 'accepted')->latest()->get();
    return view('questions.index', compact('questions'));
}

    public function create()
    {        
        return view('questions.create');
    }

    

    public function store(Request $request)
{
    if (auth()->user()->is_blocked) {
        return redirect()->route('questions.index')->with('error', 'You are blocked and cannot create questions.');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $question = Question::create([
        'user_id' => auth()->id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'status' => 'accepted',
    ]);

    

    return redirect()->route('questions.index')->with('success', 'Your question has been submitted for review.');
}





    public function show($id)
    {
        // Fetch the question with its answers and the related user
        $question = Question::with(['user', 'answers.user'])->findOrFail($id);
        // $questions = Question::where('status', 'accepted')->get();

        return view('questions.show', compact('question'));
    }

    public function toggleComments(Question $question)
    {
        // Ensure only the user who created the question can toggle comments
        if (auth()->id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Toggle the comments_disabled status
        $question->comments_disabled = !$question->comments_disabled;
        $question->save();

        return redirect()->route('questions.show', $question->id)
                        ->with('success', 'Commenting status updated successfully.');
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