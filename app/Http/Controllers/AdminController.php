<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()    
    {

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Retrieve all users (except the currently logged-in admin)
        $users = User::where('id', '!=', auth()->id())->get();


        
        return view('admin.dashboard'); // Admin dashboard view
    }
}