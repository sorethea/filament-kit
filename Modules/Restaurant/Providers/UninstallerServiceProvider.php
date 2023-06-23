<?php

namespace Modules\Restaurant\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\System\Providers\BaseUnInstallerServiceProvider;

class UninstallerServiceProvider extends BaseUnInstallerServiceProvider
{
    protected $moduleName = 'Restaurant';
}
