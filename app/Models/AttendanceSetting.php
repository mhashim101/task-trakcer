<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'late_threshold',
        'half_day_threshold',
        'working_days',
        'holidays'
    ];

    protected $casts = [
        'working_days' => 'array',
        'holidays' => 'array', // This ensures proper JSON conversion
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];
}
