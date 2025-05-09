<?php

namespace App\Console\Commands;

use App\Models\AttendanceRecord;
use App\Models\AttendanceSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkAbsentUsers extends Command
{
    protected $signature = 'attendance:mark-absent';
    protected $description = 'Mark users who didn\'t check in as absent';

    public function handle()
    {
        $settings = AttendanceSetting::first();
        if (!$settings) {
            $this->error('Attendance settings not found.');
            return;
        }

        $today = Carbon::today();

        // Skip if today is a holiday
        $holidays = $settings->holidays ?? [];
        if (in_array($today->toDateString(), $holidays)) {
            $this->info('Today is a holiday. No absent marking needed.');
            return;
        }

        // Skip if today is a non-working day
        if (!in_array($today->dayOfWeekIso, $settings->working_days)) {
            $this->info('Today is a non-working day. No absent marking needed.');
            return;
        }

        // Rest of the method remains the same...
        $users = User::where('role_id', 3)->get();

        foreach ($users as $user) {
            $existingRecord = AttendanceRecord::where('user_id', $user->id)
                ->where('date', $today)
                ->first();

            if (!$existingRecord) {
                AttendanceRecord::create([
                    'user_id' => $user->id,
                    'date' => $today,
                    'status' => 'absent'
                ]);
                $this->info("Marked {$user->name} as absent.");
            }
        }

        $this->info('Absent marking completed.');
    }
}
