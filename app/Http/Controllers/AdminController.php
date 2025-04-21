<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $teams = Team::all();
        return view('admin.dashboard', compact('users', 'teams'));
    }
    // Add this method
    public function memberAnalytics()
    {
        $members = User::where('role_id', 3)->get(); // Get all team members
        return view('analytics.member-performance', compact('members'));
    }

    public function generateReport()
    {
        $members = User::where('role_id', 3)->get(); // Get all team members
        return view('analytics.report', compact('members'));
    }
}
