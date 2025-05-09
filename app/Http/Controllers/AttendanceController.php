<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\AttendanceSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $records = AttendanceRecord::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(15);

        $todayRecord = AttendanceRecord::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        return view('attendance.index', compact('records', 'todayRecord'));
    }


    public function checkIn()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $existingRecord = AttendanceRecord::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existingRecord && $existingRecord->check_in) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        if (!$existingRecord) {
            $existingRecord = new AttendanceRecord([
                'user_id' => $user->id,
                'date' => $today,
                'status' => 'present'
            ]);
        }

        $existingRecord->check_in = now()->format('H:i:s');

        // Check if late
        $settings = AttendanceSetting::first();
        if ($settings && now()->format('H:i:s') > $settings->start_time) {
            $existingRecord->status = 'late';
        }

        $existingRecord->save();

        return redirect()->back()->with('success', 'Checked in successfully.');
    }

    public function checkOut()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $record = AttendanceRecord::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$record) {
            return redirect()->back()->with('error', 'You need to check in first.');
        }

        if ($record->check_out) {
            return redirect()->back()->with('error', 'You have already checked out today.');
        }

        $record->check_out = now()->format('H:i:s');

        // Check if half day
        $settings = AttendanceSetting::first();
        if ($settings) {
            $checkIn = Carbon::parse($record->check_in);
            $checkOut = Carbon::parse($record->check_out);
            $hoursWorked = $checkOut->diffInHours($checkIn);

            if ($hoursWorked < $settings->half_day_threshold) {
                $record->status = 'half_day';
            }
        }

        $record->save();

        return redirect()->back()->with('success', 'Checked out successfully.');
    }

    public function teamAttendance()
{
    $user = Auth::user();

    if ($user->role_id == 3) {
        abort(403, 'Unauthorized action.');
    }

    // Get all team IDs where user is either a member or a lead
    $teamIds = $user->teams->pluck('id')
        ->merge($user->leadTeams->pluck('id'))
        ->unique()
        ->values();

    if ($user->role_id == 1) { // Admin can see all team members
        $users = User::where('role_id', 3)->get();
    } else { // Team lead can see their own team members
        $users = User::whereHas('teams', function ($query) use ($teamIds) {
            $query->whereIn('teams.id', $teamIds);
        })->where('role_id', 3)->get();
    }

    $startDate = request('start_date', now()->startOfMonth()->toDateString());
    $endDate = request('end_date', now()->endOfMonth()->toDateString());

    $records = AttendanceRecord::whereIn('user_id', $users->pluck('id'))
        ->whereBetween('date', [$startDate, $endDate])
        ->orderBy('date', 'desc')
        ->paginate(15);

    return view('attendance.team', compact('records', 'users', 'startDate', 'endDate'));
}

}
