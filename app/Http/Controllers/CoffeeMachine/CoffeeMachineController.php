<?php

namespace App\Http\Controllers\CoffeeMachine;

use App\Http\Controllers\Controller;
use App\Jobs\MakeCoffee;
use App\Models\Coffee;
use App\Models\CoffeeMachine;
use App\Services\impl\CoffeeMachineServiceInterface;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;

class CoffeeMachineController extends Controller
{
    private $coffeeMachineService;

    public function __construct(CoffeeMachineServiceInterface $coffeeMachineService)
    {
        $this->coffeeMachineService = $coffeeMachineService;
    }
    public function createCoffee()
    {
        $result = $this->coffeeMachineService->createNewCoffee();

        return response()->json($result, 200);
    }

    public function count()
    {
        $data = Queue::size('coffee');
        return response()->json(['count' => $data], 200);
    }

    public function refuelMachine()
    {
        $this->coffeeMachineService->refuelMachine();

        return response()->json(['message' => 'Кофемашина полностью дозаправлена'], 200);

    }

    public function machineStatus()
    {
       $data = $this->coffeeMachineService->getMachineStatus();

        return response()->json($data, 200);
    }

    public function restOfWaterAndCoffee()
    {
        $data = $this->coffeeMachineService->getRestOfWaterAndCoffee();

        return response()->json($data, 200);
    }

    public function restCupsOfCoffee()
    {
        $data = $this->coffeeMachineService->getRestCupsOfCoffee();

        return response()->json($data, 200);
    }

}
