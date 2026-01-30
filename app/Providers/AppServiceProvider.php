<?php

namespace App\Providers;

use App\Interfaces\AccountInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\CurrencyInterface;
use App\Interfaces\MediumInterface;
use App\Interfaces\PersonInterface;
use App\Interfaces\StateInterface;
use App\Interfaces\TransactionCategoryInterface;
use App\Interfaces\TransactionHeaderInterface;
use App\Interfaces\TransactionLineInterface;
use App\Interfaces\UserInterface;
use App\Models\TransactionLine;
use App\Models\User;
use App\Observers\TransactionLineObserver;
use App\Observers\UserObserver;
use App\Repositories\AccountRepository;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\MediumRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StateRepository;
use App\Repositories\TransactionCategoryRepository;
use App\Repositories\TransactionHeaderRepository;
use App\Repositories\TransactionLineRepository;
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
        $this->app->bind(PersonInterface::class,PersonRepository::class);
        $this->app->bind(TransactionCategoryInterface::class,TransactionCategoryRepository::class);
        $this->app->bind(TransactionHeaderInterface::class,TransactionHeaderRepository::class);
        $this->app->bind(TransactionLineInterface::class,TransactionLineRepository::class);
        $this->app->bind(CurrencyInterface::class,CurrencyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // BaseModel::observe(BaseObserver::class);
        User::observe(UserObserver::class);
        TransactionLine::observe(TransactionLineObserver::class);
        Blueprint::macro('userTracking', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
            $this->unsignedBigInteger('deleted_by')->nullable();
        });
    }
}
