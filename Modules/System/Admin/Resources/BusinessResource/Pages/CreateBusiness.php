<?php

namespace Modules\System\Admin\Resources\BusinessResource\Pages;

use Modules\System\Admin\Resources\BusinessResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBusiness extends CreateRecord
{
    protected static string $resource = BusinessResource::class;
}
