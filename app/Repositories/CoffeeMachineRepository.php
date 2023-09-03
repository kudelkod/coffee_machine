<?php

namespace App\Repositories;

use App\Models\Coffee;
use App\Models\CoffeeMachineStatus;
use App\Repositories\impl\CoffeeMachineRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class CoffeeMachineRepository implements CoffeeMachineRepositoryInterface
{
    private Coffee $coffee;
    private CoffeeMachineStatus $coffeeMachineStatus;

    public function __construct(
        Coffee $coffee,
        CoffeeMachineStatus $coffeeMachineStatus
    )
    {
        $this->coffee = $coffee;
        $this->coffeeMachineStatus = $coffeeMachineStatus;
    }

    public function createCoffee()
    {
        return $this->coffee->create();
    }

    public function getCoffeeMachine()
    {
        $coffee_machine = Redis::hgetall('coffee_machine');
        $coffee_machine['status'] = $this->coffeeMachineStatus->find($coffee_machine['status_id'])->status ?? null;

        return $coffee_machine;
    }

    public function updateMachine($status = null, $water = null, $coffee = null): void
    {
        if ($water){
            Redis::hset('coffee_machine', 'water_count', $water);
        }
        if ($coffee){
            Redis::hset('coffee_machine', 'coffee_count', $coffee);
        }
        if ($status){
            Redis::hset('coffee_machine', 'status_id', $status);
        }
    }
}
