<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{
    protected $fillable = ['game_id', 'killer', 'type', 'dead'];
}
