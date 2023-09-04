<?php

namespace App\Repositories\impl;

interface CoffeeMachineRepositoryInterface
{
    public function createCoffee();

    public function getCoffeeMachine();

    public function updateMachineStatus($status);

    public function updateMachineWater($water);

    public function updateMachineCoffee($coffee);
}
