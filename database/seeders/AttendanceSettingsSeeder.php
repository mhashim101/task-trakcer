<?php

namespace Database\Seeders;

use App\Models\AttendanceSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttendanceSetting::create([
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'late_threshold' => 15,
            'half_day_threshold' => 4,
            'working_days' => [1, 2, 3, 4, 5], // Monday to Friday
            'holidays' => [],
        ]);
    }
}
