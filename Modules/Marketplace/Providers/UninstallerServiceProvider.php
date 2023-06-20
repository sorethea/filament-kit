<?php

namespace Modules\Marketplace\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\System\Providers\BaseUnInstallerServiceProvider;

class UninstallerServiceProvider extends BaseUnInstallerServiceProvider
{
    protected $moduleName = 'Marketplace';

}
