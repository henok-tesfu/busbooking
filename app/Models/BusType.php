<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function travel()
    {
       return $this->belongsTo(Travel::class);
    }
}
