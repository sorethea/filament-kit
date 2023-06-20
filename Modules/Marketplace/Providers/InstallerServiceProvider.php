<?php

namespace Modules\Marketplace\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Marketplace\Database\Seeders\MarketplaceDatabaseSeeder;
use Modules\System\Providers\BaseInstallerServiceProvider;

class InstallerServiceProvider extends BaseInstallerServiceProvider
{
    protected $moduleName = 'Marketplace';


}
