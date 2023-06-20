<?php

namespace Modules\System\Admin\Resources\SubscriptionResource\Pages;

use Modules\System\Admin\Resources\SubscriptionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubscription extends CreateRecord
{
    protected static string $resource = SubscriptionResource::class;
}
