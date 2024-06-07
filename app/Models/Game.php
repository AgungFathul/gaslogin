<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'photo'];

    // app/Models/Game.php
    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

}
