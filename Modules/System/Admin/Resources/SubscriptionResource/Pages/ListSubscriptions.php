<?php

namespace Modules\System\Admin\Resources\SubscriptionResource\Pages;

use Modules\System\Admin\Resources\SubscriptionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
