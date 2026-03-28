<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Comment;

class BoardPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // policies for Board
    public function viewBoard(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->exists();
    }

    public function updateBoard(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->Where('role', 'manager')->exists();
    }

    public function deleteBoard(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->Where('role', 'manager')->exists();
    }

    // Policies for Member
    public function inviteMember(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->whereIn('role', ['manager', 'team_lead'])->exists();
    }

    public function updateMemberRole(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->where('role', 'manager')->exists();
    }

    public function viewMembers(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->exists();
    }

    public function deleteMember(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->whereIn('role', ['manager', 'team_lead'])->exists();
    }

    // Policies for List
    public function addList(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->whereIn('role', ['manager', 'team_lead'])->exists();
    }

    public function viewList(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->exists();
    }

    public function updateList(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->whereIn('role', ['manager', 'team_lead'])->exists();
    }

    public function deleteList(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->whereIn('role', ['manager', 'team_lead'])->exists();
    }

    // Policies for Tasks

    public function viewTask(User $user, Board $board){
        return  $board->members()->where('user_id', $user->id)->exists();
    }

    public function addTask(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->whereIn('role', ['manager', 'team_lead'])->exists();
    }

    public function updateTask(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->whereIn('role', ['manager', 'team_lead'])->exists();
    }

    public function deleteTask(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->whereIn('role', ['manager', 'team_lead'])->exists();
    }

    //policies for comments

    public function viewComment(User $user, Board $board){
        return  $board->members()->where('user_id', $user->id)->exists();
    }

    public function addComment(User $user, Board $board){
        return $board->members()->where('user_id', $user->id)->exists();
    }

    public function updateComment(User $user, Board $board, Comment $comment){
        $userExists = $board->members()->where('user_id', $user->id)->exists();
        $ownerCheck = $comment->user_id === $user->id;

        return ($userExists && $ownerCheck);
    }

    public function deleteComment(User $user, Board $board, Comment $comment){
         $isManager = $board->members()->where('user_id', $user->id)->where('role', 'manager')->exists();
         $ownerCheck = $comment->user_id === $user->id;
         
         return ($isManager || $ownerCheck);
    }


}
