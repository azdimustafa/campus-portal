<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Site\Entities\Setting;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (php_sapi_name() === 'cli') {
            return;
        }
        $settings = Setting::pluck('value', 'key')->all();

        // Merge the settings with the existing configuration
        config(['settings' => $settings]);
    }
}