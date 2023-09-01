<?php

namespace App\Providers;

use App\Repositories\CoffeeMachineRepository;
use App\Repositories\impl\CoffeeMachineRepositoryInterface;
use App\Services\CoffeeMachineService;
use App\Services\impl\CoffeeMachineServiceInterface;
use Illuminate\Support\ServiceProvider;

class CoffeeMachineServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CoffeeMachineServiceInterface::class, function ($app){
            return $app->make(CoffeeMachineService::class);
        });

        $this->app->singleton(CoffeeMachineRepositoryInterface::class, function ($app){
            return $app->make(CoffeeMachineRepository::class);
        });
    }

    public function boot()
    {

    }

}
