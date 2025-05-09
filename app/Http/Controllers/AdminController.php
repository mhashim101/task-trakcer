<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function dashboard()
    {
        // $users = User::with('role')->get(); // Get all users with their roles

        $users = User::with('role')->where('id', '!=', Auth::id())->get(); // Get all users with their roles except the logged-in user
        $teams = Team::with('teamLead')->get(); // Get all teams with their team leads
        
        return Inertia::render('admin/dashboard', [
            'users' => $users,
          'teams' => $teams->map(function ($team) {
        return [
            'id' => $team->id,
            'name' => $team->name,
            'teamLead' => $team->teamLead ? ['name' => $team->teamLead->name] : null,
        ];
    }),
        ]);
    }
    // Add this method
    public function memberAnalytics()
    {
        $members = User::where('role_id', 3)->get(); // Get all team members
        $user = Auth::user();
        // return view('analytics.member-performance', compact('members'));
        return Inertia::render('Reports/MemberPerformance', [
            'user' => $user,
            'members' => $members,
            'downloadReportUrl' => route('analytics.download-report'),
            'analyticsUrl' => route('analytics.member-performance'),
        ]);
    }

    public function generateReport()
    {
        $members = User::where('role_id', 3)->get(); // Get all team members

        $user = Auth::user();

        // return view('analytics.report', compact('members'));
        
        // $team = auth()->user()->leadTeams()->first();
        // $members = $team ? $team->members : collect();
    
        return Inertia::render('Reports/GenerateReport', [
            'user' => $user,
            'members' => $members,
            'generateReportUrl' => route('vue.analytics.generate-report'),
            'downloadReportUrl' => route('analytics.download-report'),
        ]);
    }
}
