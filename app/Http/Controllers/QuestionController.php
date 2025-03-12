<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // public function index()
    // {
    //     // Fetch all questions with their associated users and answers
    //     $questions = Question::with('user', 'answers')->latest()->get();

    //     return view('questions.index', compact('questions'));
    // }

    public function index()
{
    // if (auth()->user()->hasRole('admin')) {
    //     // Admins see all pending questions
    //     $questions = Question::where('status', 'pending')->latest()->get();
    // } else {
    //     // Regular users see only accepted questions
    // }
    $questions = Question::where('status', 'accepted')->latest()->get();

    return view('questions.index', compact('questions'));
}
public function maqsad(){
    $questions = Question::where('status', 'accepted')->latest()->get();

    return view('welcome', compact('questions'));
}



    public function create()
    {
        return view('questions.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //     ]);

    //     $request->merge(['author' => auth()->user()->name]);

    //     // Create a new question for the authenticated user
    //     auth()->user()->questions()->create($request->all());

    //     return redirect()->route('questions.index')->with('success', 'Question created successfully!');
    // }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $question = Question::create([
        'user_id' => auth()->id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'status' => 'pending', // Set the status to pending
    ]);

    // $admins = User::role('admin')->get(); // Assuming Spatie roles are being used
    // foreach ($admins as $admin) {
    //     $admin->notify(new QuestionRejectedNotification($question));
    // }

    return redirect()->route('questions.index')->with('success', 'Your question has been submitted for review.');
}


// public function accept($id)
// {
//     $question = Question::findOrFail($id);
//     $question->status = 'accepted';
//     $question->save();

//     return redirect()->route('admin.questions.index')->with('success', 'Question accepted and moved to the main panel.');
// }

// public function reject($id)
// {
//     $question = Question::findOrFail($id);
//     $question->status = 'rejected';
//     $question->save();

//     // Notify the user
//     $user = $question->user;
//     $user->notify(new QuestionRejectedNotification($question));

//     return redirect()->route('admin.questions.index')->with('success', 'Question rejected, and the user has been notified.');
// }


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
        // Allow only the question's creator or an admin to delete it
        if (auth()->id() !== $question->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Delete the question
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
    }
}