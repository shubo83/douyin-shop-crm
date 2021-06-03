<?php

namespace App\Providers;

use App\Repositories\Admin\Contracts\AdminLogInterface;
use App\Repositories\Admin\Contracts\AdminMenuInterface;
use App\Repositories\Admin\Contracts\AdminRoleInterface;
use App\Repositories\Admin\Contracts\AdminUserInterface;
use App\Repositories\Admin\Contracts\AuthInterface;
use App\Repositories\Admin\Contracts\CustomerAddressInterface;
use App\Repositories\Admin\Contracts\CustomerInterface;
use App\Repositories\Admin\Contracts\CustomerSalesInterface;
use App\Repositories\Admin\Contracts\ProductInterface;
use App\Repositories\Admin\Contracts\SendSampleInterface;
use App\Repositories\Admin\Contracts\SettingGroupInterface;
use App\Repositories\Admin\Contracts\SettingInterface;
use App\Repositories\Admin\Contracts\UserInterface;
use App\Repositories\Admin\Contracts\UserLevelInterface;
use App\Repositories\Admin\Eloquent\AdminLogRepository;
use App\Repositories\Admin\Eloquent\AdminMenuRepository;
use App\Repositories\Admin\Eloquent\AdminRoleRepository;
use App\Repositories\Admin\Eloquent\AdminUserRepository;
use App\Repositories\Admin\Eloquent\AuthRepository;
use App\Repositories\Admin\Eloquent\CustomerAddressRepository;
use App\Repositories\Admin\Eloquent\CustomerRepository;
use App\Repositories\Admin\Eloquent\CustomerSalesRepository;
use App\Repositories\Admin\Eloquent\ProductRepository;
use App\Repositories\Admin\Eloquent\SendSampleRepository;
use App\Repositories\Admin\Eloquent\SettingGroupRepository;
use App\Repositories\Admin\Eloquent\SettingRepository;
use App\Repositories\Admin\Eloquent\UserLevelRepository;
use App\Repositories\Admin\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class AdminRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(AuthInterface::class,AuthRepository::class);
        $this->app->singleton(AdminMenuInterface::class,AdminMenuRepository::class);
        $this->app->singleton(AdminUserInterface::class,AdminUserRepository::class);
        $this->app->singleton(AdminRoleInterface::class,AdminRoleRepository::class);
        $this->app->singleton(AdminLogInterface::class,AdminLogRepository::class);
        $this->app->singleton(UserInterface::class,UserRepository::class);
        $this->app->singleton(UserLevelInterface::class,UserLevelRepository::class);
        $this->app->singleton(SettingInterface::class,SettingRepository::class);
        $this->app->singleton(SettingGroupInterface::class,SettingGroupRepository::class);
        $this->app->singleton(CustomerInterface::class,CustomerRepository::class);
        $this->app->singleton(ProductInterface::class,ProductRepository::class);
        $this->app->singleton(SendSampleInterface::class,SendSampleRepository::class);
        $this->app->singleton(CustomerAddressInterface::class,CustomerAddressRepository::class);
        $this->app->singleton(CustomerSalesInterface::class,CustomerSalesRepository::class);
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
