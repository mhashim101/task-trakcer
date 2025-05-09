<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamLeadController extends Controller
{
    public function dashboard()
    {
        $team = auth()->user()->leadTeams()->first();
        $members = $team ? $team->members : collect();
        $tasks = $team ? $team->tasks : collect();

        // return view('team-lead.dashboard', compact('team', 'members', 'tasks'));
        
        return Inertia::render('TeamLead/Dashboard', [
            'team' => $team,
            'members' => $members,
            'tasks' => $tasks,
        ]);
    
    }

    // Add this method
    public function memberAnalytics()
    {
        $team = auth()->user()->leadTeams()->first();
        $members = $team ? $team->members : collect();
        $user = Auth::user();

        return Inertia::render('Reports/MemberPerformance', [
            'members' => $members,
            'user' => $user,
            'downloadReportUrl' => route('analytics.download-report'),
            'analyticsUrl' => route('analytics.member-performance'),
        ]);

        // return view('analytics.member-performance', compact('members'));
    }

    public function generateReport(Request $request)
{

    $team = auth()->user()->leadTeams()->first();
    $members = $team ? $team->members : collect();
    $user = Auth::user()->id;

    return Inertia::render('Reports/GenerateReport', [
        'user' => $user,
        'members' => $members,
        'generateReportUrl' => route('vue.analytics.generate-report'),
        'downloadReportUrl' => route('analytics.download-report'),
    ]);

}

}