<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use Illuminate\Http\Request;

class AttendanceSettingController extends Controller
{

    public function edit()
    {
        $settings = AttendanceSetting::firstOrNew();
        return view('attendance.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'late_threshold' => 'required|integer|min:1',
            'half_day_threshold' => 'required|integer|min:1',
            'working_days' => 'required|array',
            'working_days.*' => 'integer|between:1,7',
            'holidays' => 'nullable|string', // Changed from array to string
        ]);

        // Convert holidays from textarea to array
        $holidays = $request->input('holidays') ?
            array_filter(
                array_map('trim',
                    explode("\n", $request->input('holidays'))
                )
            ) : [];

        // Validate each holiday date
        foreach ($holidays as $holiday) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $holiday)) {
                return redirect()->back()
                    ->withErrors(['holidays' => 'Invalid date format in holidays. Use YYYY-MM-DD format.'])
                    ->withInput();
            }
        }

        $settings = AttendanceSetting::firstOrNew();
        $settings->fill($validated);
        $settings->holidays = $holidays; // Set the processed array
        $settings->save();

        return redirect()->back()->with('success', 'Attendance settings updated successfully.');
    }
}
