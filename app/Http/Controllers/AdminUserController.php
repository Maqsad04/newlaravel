<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Delete a user (admin only).
     */
    public function destroy(User $user)
    {
        // Check if the logged-in user is an admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent the admin from deleting their own account
        if (auth()->user()->hasRole('user')) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        // Delete the user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function index()
    {

        // Retrieve all users (except the currently logged-in admin)
        $users = User::where('id', '!=', auth()->id())->get();

        return view('admin.users.index', compact('users'));
    }

    public function toggleBlock(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked; // Toggle the is_blocked field
        $user->save();

        return redirect()->back()->with('success', 'User block status updated successfully.');
    }


    public function hellooo()    
    {

        // Retrieve all users (except the currently logged-in admin)
        $users = User::where('id', '!=', auth()->id())->get();


        
        return view('admin.dashboard',  compact('users')) ; // Admin dashboard view
    }
}