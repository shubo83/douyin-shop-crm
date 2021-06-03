<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //设置报错级别
        error_reporting(E_ALL^E_WARNING^E_NOTICE);

        //非生产环境，默认打开SQL日志
        if (env("APP_ENV") != 'production') {
            DB::connection()->enableQueryLog();
        }
    }

}
