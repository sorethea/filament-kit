<?php

namespace Modules\System\Admin\Resources\PackageResource\Pages;

use Modules\System\Admin\Resources\PackageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;
}
