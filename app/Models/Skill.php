<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name'];

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'formation_skill');
    }
}
