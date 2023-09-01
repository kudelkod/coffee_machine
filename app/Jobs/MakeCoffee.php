<?php

namespace App\Jobs;

use App\Enums\CoffeeMachineStatusesEnum;
use App\Models\Coffee;
use App\Models\CoffeeMachine;
use App\Services\impl\CoffeeMachineServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeCoffee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CoffeeMachineServiceInterface $coffeeMachineService;
    public function __construct(CoffeeMachineServiceInterface $coffeeMachineService)
    {
        $this->coffeeMachineService = $coffeeMachineService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->coffeeMachineService->coffeeCreating();
    }

}
