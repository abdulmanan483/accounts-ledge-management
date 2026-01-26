<?php

namespace App\Providers;

use App\Interfaces\AccountInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\MediumInterface;
use App\Interfaces\StateInterface;
use App\Interfaces\UserInterface;
use App\Models\BaseModel;
use App\Models\User;
use App\Observers\BaseObserver;
use App\Observers\UserObserver;
use App\Repositories\AccountRepository;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\MediumRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CountryInterface::class,CountryRepository::class);
        $this->app->bind(StateInterface::class,StateRepository::class);
        $this->app->bind(CityInterface::class,CityRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(MediumInterface::class,MediumRepository::class);
        // ALM
        $this->app->bind(AccountInterface::class,AccountRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // BaseModel::observe(BaseObserver::class);
        User::observe(UserObserver::class);
        Blueprint::macro('userTracking', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
            $this->unsignedBigInteger('deleted_by')->nullable();
        });
    }
}
