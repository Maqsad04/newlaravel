<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        dd(Auth::user()->role);
        return view('admin.dashboard'); // Admin dashboard view
    }
}
