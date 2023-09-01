<?php

namespace Database\Seeders;

use App\Models\CoffeeMachineStatus;
use Illuminate\Database\Seeder;

class CoffeeMachineStatusesSeeder extends Seeder
{
    public function run()
    {
        CoffeeMachineStatus::create([
            'status' => 'Готов к работе',
        ]);

        CoffeeMachineStatus::create([
            'status' => 'В работе',
        ]);

        CoffeeMachineStatus::create([
            'status' => 'Требуется дозаправка',
        ]);
    }
}
