<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Support\Facades\Auth;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'event_type' => 'created',
            'new_values' => $task->getAttributes(),
            'description' => 'Task was created'
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $changes = $task->getChanges();
        $original = $task->getOriginal();

        $eventType = 'updated';
        $description = null;

        if (array_key_exists('status', $changes)) {
            $eventType = 'status_changed';
        }

        if (array_key_exists('assigned_to', $changes)) {
            $eventType = 'assigned';
        }

        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'event_type' => $eventType,
            'old_values' => array_intersect_key($original, $changes),
            'new_values' => $changes,
            'description' => $description
        ]);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'event_type' => 'deleted',
            'description' => 'Task was deleted'
        ]);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
