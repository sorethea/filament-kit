<?php

namespace Modules\System\Admin\Resources\ContactResource\Pages;

use Modules\System\Admin\Resources\ContactResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
