<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{
    public $timestamps = false;

    protected $fillable = ['game_id', 'killer', 'type', 'dead', 'score'];
}
