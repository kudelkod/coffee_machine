<?php

namespace App\Services\impl;

interface CoffeeMachineServiceInterface
{
    public function refuelMachine();

    public function createNewCoffee();


    public function getRestOfWaterAndCoffee();

    public function getMachineStatus();

    public function getRestCupsOfCoffee();

}
