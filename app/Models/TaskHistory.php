<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'event_type',
        'old_values',
        'new_values',
        'description'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDescriptionAttribute($value)
    {
        return $value ?? $this->generateDescription();
    }

    protected function generateDescription()
    {
        $userName = $this->user->name;
        $taskTitle = $this->task->title;

        switch ($this->event_type) {
            case 'created':
                return "Task '$taskTitle' was created by $userName";
            case 'updated':
                return "Task '$taskTitle' was updated by $userName";
            case 'status_changed':
                $oldStatus = $this->old_values['status'] ?? 'N/A';
                $newStatus = $this->new_values['status'];
                return "$userName changed status from $oldStatus to $newStatus";
            case 'assigned':
                $oldAssignee = User::find($this->old_values['assigned_to'])->name ?? 'N/A';
                $newAssignee = User::find($this->new_values['assigned_to'])->name;
                return "$userName reassigned task from $oldAssignee to $newAssignee";
            default:
                return "Task '$taskTitle' was modified by $userName";
        }
    }
}
