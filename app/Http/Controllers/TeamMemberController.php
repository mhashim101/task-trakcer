<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function dashboard()
    {
        // $tasks = auth()->user()->assignedTasks()->get();
        // return view('team-member.dashboard', compact('tasks'));


        $tasks = auth()->user()->assignedTasks()->get();
        return Inertia::render('teamMember/dashboard', [
            'tasks' => $tasks,
            'flash' => [
                'success' => session('success')
            ],
        ]);

    }
}
