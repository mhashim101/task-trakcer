<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
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
