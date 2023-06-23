<?php

namespace Modules\Restaurant\Admin\Resources\RestaurantResource\Pages;

use Modules\Restaurant\Admin\Resources\RestaurantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRestaurant extends CreateRecord
{
    protected static string $resource = RestaurantResource::class;
}
