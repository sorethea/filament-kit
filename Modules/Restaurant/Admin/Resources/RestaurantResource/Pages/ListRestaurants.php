<?php

namespace Modules\Restaurant\Admin\Resources\RestaurantResource\Pages;

use Modules\Restaurant\Admin\Resources\RestaurantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRestaurants extends ListRecords
{
    protected static string $resource = RestaurantResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
