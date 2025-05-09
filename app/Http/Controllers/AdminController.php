<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
<<<<<<< HEAD
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

=======
use Carbon\Carbon;
>>>>>>> 7a6e778683d6a30636388f0cf29f63f3305b9925

class AdminController extends Controller
{
    public function dashboard()
    {
<<<<<<< HEAD
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
=======
        // Task Statistics
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // User Statistics
        $totalUsers = User::count();

        // Recent Data
        $recentTasks = Task::with('assignedTo')->latest()->take(5)->get();
        $recentUsers = User::with('role')->latest()->take(3)->get();

        // Chart Data (last 6 months)
        $chartData = [
            'labels' => [],
            'data' => []
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartData['labels'][] = $date->format('M Y');
            $chartData['data'][] = Task::where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'completionPercentage',
            'totalUsers',
            'recentTasks',
            'recentUsers',
            'chartData'
        ));
>>>>>>> 7a6e778683d6a30636388f0cf29f63f3305b9925
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
