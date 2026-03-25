<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['owner_id', 'name', 'description', 'is_private'];

    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }
}
