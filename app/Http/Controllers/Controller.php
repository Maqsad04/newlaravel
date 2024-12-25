<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function hello() {
        return "hello yo what's up";
    }

    public function index()
    {
        $questions = auth()->user()->questions; // Get all questions for the logged-in user
        return view('user.index', compact('questions'));
    }
}
