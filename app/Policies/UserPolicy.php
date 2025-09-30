<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
      public function update(User $currentUser, User $targetUser): bool
    {
        
        return $currentUser->id === $targetUser->id || $currentUser->id === $targetUser->created_by;
    }


    public function delete(User $currentUser, User $targetUser): bool
    {
        if ($currentUser->id === $targetUser->id) {
            return false;
        }

        return $currentUser->id === $targetUser->created_by;
    }
}
