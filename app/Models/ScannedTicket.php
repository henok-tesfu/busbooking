<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedTicket extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function checker()
    {
     return $this->belongsTo(Admin::class,'checker_id');
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

}
