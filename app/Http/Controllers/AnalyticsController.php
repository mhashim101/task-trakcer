<?php

namespace App\Http\Controllers;

use App\Exports\MemberTasksExport;
use App\Models\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AnalyticsController extends Controller
{
    public function memberPerformance(Request $request)
    {

        $request->validate([
            'member_id' => 'required|exists:users,id',
            'month' => 'nullable|date_format:Y-m',
        ]);

        $member = User::findOrFail($request->member_id);
        $month = $request->month ? Carbon::parse($request->month) : now();

        // Monthly stats
        $tasksCompleted = Task::where('assigned_to', $member->id)
            ->where('status', 'completed')
            ->whereMonth('updated_at', $month->month)
            ->whereYear('updated_at', $month->year)
            ->count();

        $tasksPending = Task::where('assigned_to', $member->id)
            ->where('status', 'pending')
            ->count();

        $tasksInProgress = Task::where('assigned_to', $member->id)
            ->where('status', 'in_progress')
            ->count();

        // Recent completed tasks
        $recentCompleted = Task::where('assigned_to', $member->id)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Task completion trend (last 6 months)
        $completionTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $month->copy()->subMonths($i);
            $count = Task::where('assigned_to', $member->id)
                ->where('status', 'completed')
                ->whereMonth('updated_at', $date->month)
                ->whereYear('updated_at', $date->year)
                ->count();

            $completionTrend[] = [
                'month' => $date->format('M Y'),
                'count' => $count,
            ];
        }

        return response()->json([
            'member' => $member,
            'stats' => [
                'completed_this_month' => $tasksCompleted,
                'pending' => $tasksPending,
                'in_progress' => $tasksInProgress,
            ],
            'recent_completed' => $recentCompleted,
            'completion_trend' => $completionTrend,
        ]);
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $member = User::findOrFail($request->member_id);
        $tasks = Task::where('assigned_to', $member->id)
            ->orWhere('updated_at', [$request->start_date, $request->end_date])
            ->with(['team', 'assignedBy'])
            ->get();

        return response()->json([
            'member' => $member,
            'period' => [
                'start' => $request->start_date,
                'end' => $request->end_date,
            ],
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('status', 'completed')->count(),
            'tasks' => $tasks,
        ]);
    }

    public function downloadReport(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:pdf,excel'
        ]);

        $member = User::findOrFail($request->member_id);
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $tasks = Task::where('assigned_to', $member->id)
            ->orWhere('updated_at', [$startDate, $endDate])
            ->with(['team', 'assignedBy'])
            ->get();

        $data = [
            'member' => $member,
            'period' => [
                'start' => $startDate,
                'end' => $endDate,
            ],
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('status', 'completed')->count(),
            'tasks' => $tasks,
        ];

        if ($request->format === 'pdf') {
            $pdf = PDF::loadView('reports.member-tasks-pdf', $data);
            return $pdf->download("{$member->name}_task_report_{$startDate}_to_{$endDate}.pdf");
        }

        return Excel::download(new MemberTasksExport($data),
            "{$member->name}_task_report_{$startDate}_to_{$endDate}.xlsx");
    }
}
