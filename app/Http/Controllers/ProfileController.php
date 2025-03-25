<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $questions = $user->questions()->with('user')->get();
        return view('profile.index', compact('user', 'questions'));
    }

    public function getQuestions()
    {
        $user = Auth::user();
        $questions = $user->questions()->with('user')->get();
        return response()->json($questions);
    }
}