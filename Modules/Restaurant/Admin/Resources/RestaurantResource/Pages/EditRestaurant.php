<?php

namespace Modules\Restaurant\Admin\Resources\RestaurantResource\Pages;

use Modules\Restaurant\Admin\Resources\RestaurantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRestaurant extends EditRecord
{
    protected static string $resource = RestaurantResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
