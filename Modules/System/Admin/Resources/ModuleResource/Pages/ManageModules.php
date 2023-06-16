<?php

namespace Modules\System\Admin\Resources\ModuleResource\Pages;

use Modules\System\Admin\Resources\ModuleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageModules extends ManageRecords
{
    protected static string $resource = ModuleResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
