<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $with = ['seats'];

    public function seats()
    {


     return $this->hasMany(Seat::class);
    }
    public function travel()
    {


        return $this->belongsTo(Seat::class);
    }
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
