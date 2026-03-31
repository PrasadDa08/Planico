<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
     protected $fillable = ['board_id', 'user_id', 'task_id', 'action', 'subject_model', 'subject_id', 'meta'];

     protected $casts = [
        'meta' => 'array',
     ];

     public function user(){
        return $this->belongsTo(User::class);
     }
}

