<?php

namespace Modules\System\Admin\Resources\PackageResource\Pages;

use Modules\System\Admin\Resources\PackageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
