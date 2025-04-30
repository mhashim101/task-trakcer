<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceReportController extends Controller
{
    public function userReport($userId = null)
    {
        $user = $userId ? User::findOrFail($userId) : Auth::user();

        // Authorization check
        if (Auth::user()->role_id == 3 && Auth::id() != $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->role_id == 2 && !$user->teams->contains('team_lead_id', Auth::id())) {
            abort(403, 'Unauthorized action.');
        }

        $startDate = request('start_date', now()->startOfMonth()->toDateString());
        $endDate = request('end_date', now()->endOfMonth()->toDateString());

        $records = AttendanceRecord::where('user_id', $user->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $summary = [
            'total_days' => Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1,
            'present' => $records->where('status', 'present')->count(),
            'late' => $records->where('status', 'late')->count(),
            'half_day' => $records->where('status', 'half_day')->count(),
            'absent' => $records->where('status', 'absent')->count(),
        ];

        return view('attendance.report', compact('records', 'user', 'summary', 'startDate', 'endDate'));
    }
}
