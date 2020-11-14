<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function admins()
    {

        return $this->hasMany(Admin::class);
    }

    public function travel()
    {

        return $this->hasOne(Travel::class);
    }
}
