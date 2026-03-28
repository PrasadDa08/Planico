<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = ['list_id', 'board_id', 'assigned_to', 'created_by', 'name', 'description', 'priority', 'due_date', 'position'];

    public function list()
    {
        return $this->belongsTo(TaskList::class);
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
