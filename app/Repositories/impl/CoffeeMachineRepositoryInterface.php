<?php

namespace App\Repositories\impl;

interface CoffeeMachineRepositoryInterface
{
    public function createCoffee();

    public function getCoffeeMachine();

    public function updateMachine($status, $water, $coffee);
}
