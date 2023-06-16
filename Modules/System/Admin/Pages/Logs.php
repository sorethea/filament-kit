<?php

namespace Modules\System\Admin\Pages;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use FilipFonal\FilamentLogManager\Pages\Logs as BaseLogs;

class Logs extends BaseLogs implements HasShieldPermissions
{
    use HasPageShield;

    protected function beforeBooted(): void
    {
        auth()->user()->can('page_Logs');
    }

    public function delete(): bool
    {
        if(!auth()->user()->can('page_Logs_delete')){
            Notification::make()->title("You don't have permission to perform this action!")->danger()->send();
            return false;
        }
        return parent::delete(); // TODO: Change the autogenerated stub
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'delete'
        ];
    }
}