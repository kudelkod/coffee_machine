<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CoffeeMachine extends Model
{
    protected $fillable = [
        'coffee_count',
        'water_count',
        'status_id',
        'name',
    ];

    public function status()
    {
        return $this->hasOne(CoffeeMachineStatus::class, 'id', 'status_id');
    }

    public function getStatusNameAttribute()
    {
        if($this->status){
            return $this->status->status;
        }
        return null;
    }
}
