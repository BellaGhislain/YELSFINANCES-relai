<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = ['name', 'level', 'presentation', 'youtube_link', 'photo', 'is_active'];

    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'formation_trainer');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'formation_skill');
    }
}
