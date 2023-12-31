<?php

namespace App\Http\Controllers\CoffeeMachine;

use App\Http\Controllers\Controller;
use App\Services\impl\CoffeeMachineServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class CoffeeMachineController extends Controller
{
    private CoffeeMachineServiceInterface $coffeeMachineService;

    public function __construct(CoffeeMachineServiceInterface $coffeeMachineService)
    {
        $this->coffeeMachineService = $coffeeMachineService;
    }

    public function createCoffee(): JsonResponse
    {
        $result = $this->coffeeMachineService->createNewCoffee();

        return response()->json($result, 200);
    }

    public function refuelMachine(): JsonResponse
    {
        $result = $this->coffeeMachineService->refuelMachine();

        return response()->json($result, 200);

    }

    public function machineStatus(): JsonResponse
    {
       $data = $this->coffeeMachineService->getMachineStatus();

        return response()->json($data, 200);
    }

    public function restOfWaterAndCoffee(): JsonResponse
    {
        $data = $this->coffeeMachineService->getRestOfWaterAndCoffee();

        return response()->json($data, 200);
    }

    public function restCupsOfCoffee(): JsonResponse
    {
        $data = $this->coffeeMachineService->getRestCupsOfCoffee();

        return response()->json($data, 200);
    }

}
