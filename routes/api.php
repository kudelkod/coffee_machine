<?php

use App\Http\Controllers\CoffeeMachine\CoffeeMachineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/coffee'], function($route){
    $route->get('/create', [CoffeeMachineController::class, 'createCoffee']);
    $route->group(['prefix' => '/machine'], function ($route){
        $route->post('/refuel', [CoffeeMachineController::class, 'refuelMachine']);
        $route->get('/status', [CoffeeMachineController::class, 'machineStatus']);
        $route->get('/reminder', [CoffeeMachineController::class, 'restOfWaterAndCoffee']);
        $route->get('/reminder_cups', [CoffeeMachineController::class, 'restCupsOfCoffee']);
    });
});
