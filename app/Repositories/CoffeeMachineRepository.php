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

    public function updateMachineStatus($status): bool
    {
        Redis::hset('coffee_machine', 'status_id', $status);
        return true;
    }

    public function updateMachineWater($water): bool
    {
        Redis::hset('coffee_machine', 'water_count', $water);
        return true;
    }

    public function updateMachineCoffee($coffee): bool
    {
        Redis::hset('coffee_machine', 'coffee_count', $coffee);
        return true;
    }
}
