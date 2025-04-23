<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function dashboard()
    {
        $tasks = auth()->user()->assignedTasks()->orderBy('created_at', 'desc')->paginate(10);
        return view('team-member.dashboard', compact('tasks'));
    }
}
