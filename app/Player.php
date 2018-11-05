<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function kills() {
        return $this->hasMany(Kill::class, 'killer', 'name');
    }

    public function deads() {
        return $this->hasMany(Kill::class, 'dead', 'name');
    }
}
