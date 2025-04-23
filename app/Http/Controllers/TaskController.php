<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->createdTasks()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $team = auth()->user()->leadTeams()->first();
        $members = $team ? $team->members : collect();
        return view('tasks.create', compact('team', 'members'));
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

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('attachments.user');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $team = auth()->user()->leadTeams()->first();
        $members = $members = $team ? $team->members : collect();
        return view('tasks.edit', compact('task', 'team', 'members'));
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

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    // app/Http/Controllers/TaskController.php
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'completion_notes' => 'nullable|string',
            'attachments.*' => 'sometimes|file|max:10240'
        ]);

        $task->update(['status' => $request->status]);

        // Record completion notes if provided
        if ($request->status === 'completed' && $request->completion_notes) {
            $task->update(['completion_notes' => $request->completion_notes]);
        }

        // Handle file uploads
        if ($request->hasFile('attachments') && $request->status === 'completed') {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task_attachments');

                $task->attachments()->create([
                    'user_id' => auth()->id(),
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'description' => $request->description ?? 'Task completion attachment'
                ]);
            }
        }

        return back()->with('success', 'Task status updated successfully');
    }

    public function complete(Request $request, Task $task)
    {
        $request->validate([
            'completion_notes' => 'required|string',
            'attachments.*' => 'nullable|file|max:5120', // 5MB max
        ]);

        // Update task status and completion notes
        $task->update([
            'status' => 'completed',
            'completion_notes' => $request->completion_notes,
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task_attachments');

                $task->attachments()->create([
                    'user_id' => auth()->id(),
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('team-member.tasks-show', $task)
            ->with('success', 'Task marked as complete with attachments');
    }


}
