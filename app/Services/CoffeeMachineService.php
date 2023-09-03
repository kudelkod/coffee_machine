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
     * @return void
     */
    public function refuelMachine(): void
    {
        $this->coffeeMachineRepository->updateMachine(null, CoffeeMachineCostsEnum::max_water, CoffeeMachineCostsEnum::max_coffee);

        $coffeeMachine = $this->coffeeMachineRepository->getCoffeeMachine();

        if ((int) $coffeeMachine['status_id'] === CoffeeMachineStatusesEnum::refuel)
        {
            $this->coffeeMachineRepository->updateMachine(CoffeeMachineStatusesEnum::ready);
        }
    }

    /**
     * @return void
     */
    public function coffeeCreating(): void
    {
        $coffeeMachine = $this->coffeeMachineRepository->getCoffeeMachine();

        if ((int) $coffeeMachine['status_id'] == CoffeeMachineStatusesEnum::ready)
        {
            $this->coffeeMachineRepository->updateMachine(CoffeeMachineStatusesEnum::works);

            sleep(120);

            $water = $coffeeMachine['water_count'] - CoffeeMachineCostsEnum::cost_water;
            $coffee = $coffeeMachine['coffee_count'] - CoffeeMachineCostsEnum::cost_coffee;

            if ($water < CoffeeMachineCostsEnum::cost_water || $coffee < CoffeeMachineCostsEnum::cost_coffee)
            {
                $this->coffeeMachineRepository->updateMachine(CoffeeMachineStatusesEnum::refuel, $water, $coffee);
            }
            else
            {
                $this->coffeeMachineRepository->updateMachine(CoffeeMachineStatusesEnum::ready, $water, $coffee);
            }

            $this->coffeeMachineRepository->createCoffee();
        }
        else
        {
            MakeCoffee::dispatch($this)->onQueue('coffee');
        }
    }

    public function createNewCoffee(): array
    {
        MakeCoffee::dispatch($this)->onQueue('coffee');

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

        return ['status' =>$coffeeMachine['status']];
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
