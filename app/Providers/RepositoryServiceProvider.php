<?php

namespace App\Providers;

use App\Interfaces\AddressInterface;
use App\Interfaces\ItemInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\BrandInterface;
use App\Interfaces\CompanyInterface;
use App\Interfaces\ProductInterface;
use App\Repositories\ItemRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductTypeInterface;
use App\Interfaces\UserRequestInterface;
use App\Interfaces\CompanyRequestInterface;
use App\Repositories\AddressRepository;
use App\Repositories\UserRequestRepository;
use App\Repositories\ProductTypesRepository;
use App\Repositories\CompanyRequestRepository;

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
        $this->app->bind(AddressInterface::class, AddressRepository::class);
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
