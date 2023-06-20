<?php

namespace Modules\System\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class BaseUnInstallerServiceProvider extends ServiceProvider
{
    protected $moduleName = 'System';

    public function boot()
    {
        try {
            app()->booted(function () {
                $this->uninstall();
                Artisan::call("module:migrate-rollback ".$this->moduleName);
                $seed =app(config("modules.namespace","Modules")."\\".$this->moduleName."\\Database\\Seeders\\".$this->moduleName."DatabaseSeeder");
                $seed?->rollback();
                Artisan::call("cache:clear");
            });
        }catch (\Exception $exception){
            logger($exception->getMessage());
        }

    }

    public function uninstall(){

    }
}
