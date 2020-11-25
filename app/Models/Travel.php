<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $with = [
      'startCity',
      'dropOfCity',
        'busType',
        'company',
        'tickets'
    ];

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

    public function startCity() {
        return $this->belongsTo(City::class, 'startCityId');
    }

    public function dropOfCity() {
        return $this->belongsTo(City::class, 'dropOfCityId');
    }

//    public function getStartCityNameAttribute() {
//        return $this->startCity->name;
//    }
//
//    public function getDropOfCityNameAttribute() {
//        return $this->dropOfCity->name;
//    }
}
