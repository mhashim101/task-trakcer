<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Http\Request;

class TaskHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = TaskHistory::with('task', 'user')
            ->orderBy('created_at', 'desc');

        // Filter by task if task_id is provided
        if ($request->has('task_id')) {
            $query->where('task_id', $request->task_id);
        }

        // Filter by user if user_id is provided
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by event type if provided
        if ($request->has('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        $histories = $query->paginate(15);


        return view('task-history.index', compact('histories'));
    }

    public function taskHistory(Task $task)
    {
        $histories = $task->histories()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('task-history.task', compact('task', 'histories'));
    }

    public function userHistory()
    {
        $histories = auth()->user()->taskHistories()
            ->with('task') // Eager load the task relationship
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('task-history.user', compact('histories'));
    }
}
