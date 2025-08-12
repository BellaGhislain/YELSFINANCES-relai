<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'formation_id', 'session_id', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
