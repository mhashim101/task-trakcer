<?php

namespace App\Policies;

use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, AttendanceRecord $record)
    {
        return $user->id === $record->user_id ||
               $user->role_id === 1 ||
               ($user->role_id === 2 && $user->teams->contains('team_lead_id', $user->id));
    }

    public function create(User $user)
    {
        return $user->role_id === 3; // Only team members can check in/out
    }

    public function update(User $user, AttendanceRecord $record)
    {
        return $user->role_id === 1; // Only admin can manually update
    }

    public function delete(User $user, AttendanceRecord $record)
    {
        return $user->role_id === 1; // Only admin can delete
    }
}
