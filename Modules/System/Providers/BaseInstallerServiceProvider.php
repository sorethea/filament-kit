<?php

namespace Modules\System\Providers;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BaseInstallerServiceProvider extends ServiceProvider
{
    protected $moduleName = 'System';

    public function boot()
    {
        app()->booted(function () {
            $this->install();
            Artisan::call("module:migrate ".$this->moduleName);
            Artisan::call("module:seed ".$this->moduleName);
            Artisan::call("cache:clear");
        });
    }

    public function install(){

    }

}
