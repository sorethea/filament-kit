<?php

namespace Modules\System\Admin\Resources\ContactResource\Pages;

use Modules\System\Admin\Resources\ContactResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
