<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;

class LeaveRequestPolicy
{
    public function review(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->isAdmin() && $leaveRequest->status === 'Pending';
    }
}
