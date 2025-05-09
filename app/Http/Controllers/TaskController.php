<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index()
    {
        
        $tasks = auth()->user()->createdTasks()->with(['team', 'assignedTo'])->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'team' => $task->team ? $task->team->name : null,
                    'assigned_to' => $task->assignedTo ? $task->assignedTo->name : null,
                    'status' => $task->status,
                    'due_date' => $task->due_date,
                    'created_at' => $task->created_at,
                    'updated_at' => $task->updated_at,
                ];
            }),
            'auth' => [
                'user' => auth()->user(),
            ],
        ]);


    }

    public function create()
    {
        $teams = auth()->user()->leadTeams()->first();
        $members = $teams ? $teams->members : collect();
        // return view('tasks.create', compact('team', 'members'));
        return Inertia::render('Tasks/Create', [
            'teams' => $teams,
            'members' => $members,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'team_id' => 'required|exists:teams,id',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'team_id' => $request->team_id,
            'assigned_by' => auth()->id(),
            'assigned_to' => $request->assigned_to,
            'due_date' => $request->due_date,
            'status' => 'pending',
        ]);

        return to_route('dashboard')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        // return view('tasks.show', compact('task'));

        $task->load(['team', 'assignedBy', 'assignedTo']); // Ensure relationships are loaded

        return Inertia::render('Tasks/Show', [
            'task' => $task,
            'auth' => [
                'user' => auth()->user(),
            ],
        ]);
    }

    public function edit(Task $task)
    {
        $team = auth()->user()->leadTeams()->first();
        $members = $members = $team ? $team->members : collect();
        // return view('tasks.edit', compact('task', 'team', 'members'));
        return Inertia::render('Tasks/Edit', [
            'task' => $task,
            'team' => $team,
            'members' => $members,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'team_id' => 'required|exists:teams,id',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->all());

        return to_route('dashboard')->with('success', 'Task updated successfully.');
        // return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return to_route('dashboard')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Task status updated successfully.');
    }
}
