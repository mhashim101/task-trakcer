<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        // return view('teams.index', compact('teams'));

        // dd($teams);

        return Inertia::render('Teams/Index', [
            'teams' => $teams,
        ]);
    }

    public function create()
    {
        $leads = User::where('role_id', 2)->get();
        $members = User::where('role_id', 3)->get();

        return Inertia::render('Teams/Create', [
            'leads' => $leads,
            'members' => $members,
        ]);
        // return view('teams.create', compact('leads', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_lead_id' => 'required|exists:users,id',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        $team = Team::create([
            'name' => $request->name,
            'description' => $request->description,
            'team_lead_id' => $request->team_lead_id,
        ]);

        if ($request->has('members')) {
            $team->members()->attach($request->members);
        }

        // return redirect()->route('teams.index')->with('success', 'Team created successfully.');

        return to_route('dashboard')->with('success', 'Team created successfully.');
    }

    public function show(Team $team)
    {
        // return view('teams.show', compact('team'));

        return Inertia::render('Teams/Show', [
            'team' => $team,
        ]);
    }

    public function edit(Team $team)
    {
        $leads = User::where('role_id', 2)->get();
        $members = User::where('role_id', 3)->get();


        return Inertia::render('Teams/Edit', [
            'team' => $team,
            'leads' => $leads,
            'members' => $members,

        ]);

        // return Inertia::render('Teams/Edit', [
        //     'team' => $team->load('members'),
        //     'leads' => $leads,
        //     'members' => $members,
        // ]);


        // $members = User::where('role_id', 2)->get(); // Fetch all members
        // return Inertia::render('Teams/Edit', [
        //     'team' => $team->load('members'), // Ensure team members are loaded
        //     'members' => $members,
        // ]);

        // return view('teams.edit', compact('team', 'leads', 'members'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_lead_id' => 'required|exists:users,id',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        $team->update([
            'name' => $request->name,
            'description' => $request->description,
            'team_lead_id' => $request->team_lead_id,
        ]);

        if ($request->has('members')) {
            $team->members()->sync($request->members);
        }

        // return redirect()->route('teams.index')->with('success', 'Team updated successfully.');

        return to_route('dashboard')->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team)
    {
           // Delete related records in the team_user table
    $team->members()->detach();

    // Delete the team
    $team->delete();

    return to_route('dashboard')->with('success', 'Team deleted successfully.');
    }
}
