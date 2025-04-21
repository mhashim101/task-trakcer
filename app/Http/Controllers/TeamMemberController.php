<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function dashboard()
    {
        $tasks = auth()->user()->assignedTasks()->get();
        return view('team-member.dashboard', compact('tasks'));
    }
}
