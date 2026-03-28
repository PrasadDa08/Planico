<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Board;
use App\Models\Task;

class TaskList extends Model
{
    protected $table = 'lists';

    protected $fillable = [
        'board_id',
        'name',
        'position'
    ];

    public function board(){
        return $this->belongsTo(Board::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
