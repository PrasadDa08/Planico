<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Board;

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
}
