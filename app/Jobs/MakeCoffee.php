<?php

namespace App\Jobs;

use App\Enums\CoffeeMachineCostsEnum;
use App\Enums\CoffeeMachineStatusesEnum;
use App\Models\Coffee;
use App\Models\CoffeeMachine;
use App\Repositories\impl\CoffeeMachineRepositoryInterface;
use App\Services\impl\CoffeeMachineServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeCoffee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private CoffeeMachineRepositoryInterface $coffeeMachineRepository;
    public function __construct(CoffeeMachineRepositoryInterface $coffeeMachineRepository)
    {
        $this->coffeeMachineRepository = $coffeeMachineRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $coffeeMachine = $this->coffeeMachineRepository->getCoffeeMachine();

        if ((int) $coffeeMachine['status_id'] === CoffeeMachineStatusesEnum::ready)
        {
            $this->coffeeMachineRepository->updateMachineStatus(CoffeeMachineStatusesEnum::works);

            sleep(120);

            $water = $coffeeMachine['water_count'] - CoffeeMachineCostsEnum::cost_water;
            $coffee = $coffeeMachine['coffee_count'] - CoffeeMachineCostsEnum::cost_coffee;

            if ($water < CoffeeMachineCostsEnum::cost_water || $coffee < CoffeeMachineCostsEnum::cost_coffee)
            {
                $this->coffeeMachineRepository->updateMachineStatus(CoffeeMachineStatusesEnum::refuel);
            }
            else
            {
                $this->coffeeMachineRepository->updateMachineStatus(CoffeeMachineStatusesEnum::ready);
            }

            $this->coffeeMachineRepository->updateMachineWater($water);
            $this->coffeeMachineRepository->updateMachineCoffee($coffee);

            $this->coffeeMachineRepository->createCoffee();
        }
        else
        {
            $this->fail("Нужна дозаправка машины");
        }
    }
}
