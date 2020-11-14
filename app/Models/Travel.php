<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;


    public function tickets()
    {
       return $this->hasMany(Ticket::class);

    }
    public function busType()
    {
        return $this->belongsTo(BusType::class,'busType_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

}
