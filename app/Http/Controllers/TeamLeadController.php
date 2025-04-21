<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamLeadController extends Controller
{
    public function dashboard()
    {
        $team = auth()->user()->leadTeams()->first();
        $members = $team ? $team->members : collect();
        $tasks = $team ? $team->tasks : collect();

        return view('team-lead.dashboard', compact('team', 'members', 'tasks'));
    }

    // Add this method
    public function memberAnalytics()
    {
        $team = auth()->user()->leadTeams()->first();
        $members = $team ? $team->members : collect();
        return view('analytics.member-performance', compact('members'));
    }

    public function generateReport()
    {
        $team = auth()->user()->leadTeams()->first();
        $members = $team ? $team->members : collect();
        return view('analytics.report', compact('members'));
    }
}
