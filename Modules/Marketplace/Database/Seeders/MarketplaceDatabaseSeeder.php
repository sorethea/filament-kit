<?php

namespace Modules\Marketplace\Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MarketplaceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if(config('filament-shield.super_admin.enabled',false)){
            $superAdmin = Role::findOrCreate(config('filament-shield.super_admin.name'),Utils::getFilamentAuthGuard());
            $permissions = [
                'manage',
            ];
            foreach ($permissions as $permission){
                $permission = Permission::findOrCreate($permission.'_marketplace',Utils::getFilamentAuthGuard());
                $superAdmin->givePermissionTo($permission);
            }

        }

    }

    public function rollback(){
        Permission::where('name','like','%marketplace')->delete();
    }
}
