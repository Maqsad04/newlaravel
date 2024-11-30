<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // Create a new answer for the authenticated user
        $question->answers()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('questions.show', $question->id)->with('success', 'Answer submitted successfully!');
    }

    public function highlightAnswer(Answer $answer)
    {
        $question = $answer->question;

        // Ensure only the user who created the question can highlight an answer
        if (auth()->id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Unhighlight any previously highlighted answers for this question
        $question->answers()->update(['highlighted' => false]);

        // Highlight the selected answer
        $answer->highlighted = true;
        $answer->save();

        return redirect()->route('questions.show', $question->id)
                        ->with('success', 'Answer highlighted successfully.');
    }

    public function destroy(Answer $answer)
    {
        // Allow only the answer's creator or an admin to delete it
        if (auth()->id() !== $answer->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Delete the answer
        $answer->delete();

        return redirect()->route('questions.show', $answer->question_id)->with('success', 'Answer deleted successfully.');
    }
}