<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'team_id',
        'assigned_by',
        'assigned_to',
        'status',
        'due_date'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // protected static function booted()
    // {
    //     static::updated(function ($task) {
    //         foreach ($task->getDirty() as $field => $newValue) {
    //             TaskHistory::create([
    //                 'task_id' => $task->id,
    //                 'changed_by' => auth()->id(),
    //                 'field_name' => $field,
    //                 'old_value' => $task->getOriginal($field),
    //                 'new_value' => $newValue,
    //             ]);
    //         }
    //     });
    // }

    public function histories()
    {
        return $this->hasMany(TaskHistory::class)->latest();
    }
}
