<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Session extends Model
{
    protected $table = 'training_sessions';
    protected $fillable = ['formation_id', 'start_date', 'end_date', 'country', 'city', 'type', 'price', 'status'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'session_trainer');
    }

    public function getStatusAttribute($value)
    {
        if ($value === 'annulée') {
            return $value;
        }

        $today = Carbon::today();
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);

        if ($today < $startDate) {
            return 'en attente';
        } elseif ($today >= $startDate && $today <= $endDate) {
            return 'en cours';
        } else {
            return 'terminée';
        }
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
