<?php

namespace App\Services;

use App\Enums\CoffeeMachineCostsEnum;
use App\Enums\CoffeeMachineStatusesEnum;
use App\Jobs\MakeCoffee;
use App\Repositories\impl\CoffeeMachineRepositoryInterface;
use App\Services\impl\CoffeeMachineServiceInterface;

class CoffeeMachineService implements CoffeeMachineServiceInterface
{
    private CoffeeMachineRepositoryInterface $coffeeMachineRepository;

    public function __construct(CoffeeMachineRepositoryInterface $coffeeMachineRepository)
    {
        $this->coffeeMachineRepository = $coffeeMachineRepository;
    }

    /**
     * @return string[]
     */
    public function refuelMachine(): array
    {
        $this->coffeeMachineRepository->updateMachineWater(CoffeeMachineCostsEnum::max_water);
        $this->coffeeMachineRepository->updateMachineCoffee(CoffeeMachineCostsEnum::max_coffee);

        $coffeeMachine = $this->coffeeMachineRepository->getCoffeeMachine();

        if ((int) $coffeeMachine['status_id'] === CoffeeMachineStatusesEnum::refuel)
        {
            $this->coffeeMachineRepository->updateMachineStatus(CoffeeMachineStatusesEnum::ready);
        }

        return ['message' => 'Кофемашина полностью дозаправлена'];
    }

    public function createNewCoffee(): array
    {
        MakeCoffee::dispatch($this->coffeeMachineRepository)->onQueue('coffee');

        return ['message' => 'Кофе отправлен в очередь'];
    }

    public function getRestOfWaterAndCoffee(): array
    {
        $coffeeMachine = $this->coffeeMachineRepository->getCoffeeMachine();
        $left_coffee = $coffeeMachine['coffee_count'];
        $left_water = $coffeeMachine['water_count'];

        return [
            'reminder' => [
                'coffee' => [
                    'kg' => (float) $left_coffee / 1000,
                    'g' => (float) $left_coffee,
                ],
                'water' => [
                    'l' => (float) $left_water / 1000,
                    'ml' => (float) $left_water,
                ]
            ]
        ];
    }

    public function getMachineStatus(): array
    {
        $coffeeMachine = $this->coffeeMachineRepository->getCoffeeMachine();

        return ['status' => $coffeeMachine['status']];
    }

    public function getRestCupsOfCoffee(): array
    {
        $coffeeMachine = $this->coffeeMachineRepository->getCoffeeMachine();
        $left_coffee = $coffeeMachine['coffee_count'];
        $left_water = $coffeeMachine['water_count'];
        $left_coffee_by_coffee = (int) ((float) $left_coffee / CoffeeMachineCostsEnum::cost_coffee);
        $left_coffee_by_water = (int) ((float) $left_water / CoffeeMachineCostsEnum::cost_water);

        return ['cups_of_coffee' => min($left_coffee_by_coffee, $left_coffee_by_water)];
    }
}
