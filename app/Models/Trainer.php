<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'is_active'];

    public function sessions()
    {
        return $this->belongsToMany(Session::class, 'session_trainer');
    }
}
