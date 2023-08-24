<?php

namespace App\Providers;

use App\Interfaces\ItemInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Repositories\ItemRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()  
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(ItemInterface::class, ItemRepository::class);
        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(CompanyRequestInterface::class, CompanyRequestRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(ProductTypeInterface::class, ProductTypesRepository::class);
        $this->app->bind(UserRequestInterface::class, UserRequestRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
