<?php

namespace Modules\System\Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Models\Currency;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SystemDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $currencies =[
            ['id' => '21', 'country' => 'Cambodia', 'currency' => 'Riels', 'code' => 'KHR', 'symbol' => '៛',
                'thousand_separator' => ',', 'decimal_separator' => '.', 'created_at' => null, 'updated_at' => null, ],
            ['id' => '124', 'country' => 'United States of America', 'currency' => 'Dollars', 'code' => 'USD', 'symbol' => '$',
                'thousand_separator' => ',', 'decimal_separator' => '.', 'created_at' => null, 'updated_at' => null, ],
        ];
        Currency::insert($currencies);
        if(config('filament-shield.super_admin.enabled',false)){
            $superAdmin = Role::findOrCreate(config('filament-shield.super_admin.name'),Utils::getFilamentAuthGuard());
            $permissions = config('system.custom_permissions',[]);
            if (!empty($permissions)){
                foreach ($permissions as $permission){
                    $permission = Permission::findOrCreate($permission.'_system',Utils::getFilamentAuthGuard());
                    $superAdmin->givePermissionTo($permission);
                }
            }
        }
    }
}
