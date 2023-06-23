<?php

namespace Modules\System\Admin\Resources\EmployeeResource\Pages;

use Modules\System\Admin\Resources\EmployeeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
