<?php

namespace Modules\System\Admin\Resources\BusinessResource\Pages;

use Modules\System\Admin\Resources\BusinessResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusiness extends EditRecord
{
    protected static string $resource = BusinessResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
