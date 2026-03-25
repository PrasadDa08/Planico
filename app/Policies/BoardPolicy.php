<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Board;

class BoardPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->exists();
    }
}
