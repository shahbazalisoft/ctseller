<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Setting;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $mode = env('APP_MODE');
        try {
            $pagination = BusinessSetting::where(['key' => 'default_pagination'])->first();
            if ($pagination) {
                Config::set('default_pagination', $pagination->value);
            } else {
                Config::set('default_pagination', 25);
            }
        } catch (\Exception $ex) {

        }
    }
}
