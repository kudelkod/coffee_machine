<?php

namespace Database\Seeders;

use App\Models\CoffeeMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Redis;

class CoffeeMachinesSeeder extends Seeder
{
    public function run()
    {
        Redis::hset('coffee_machine', 'coffee_count', 0);
        Redis::hset('coffee_machine', 'water_count', 0);
        Redis::hset('coffee_machine', 'status_id', 3);
    }
}
