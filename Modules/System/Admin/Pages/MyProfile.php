<?php

namespace Modules\System\Admin\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use JeffGreco13\FilamentBreezy\Pages\MyProfile as BaseProfile;

class MyProfile extends BaseProfile
{
protected function getUpdateProfileFormSchema(): array
{
    return array_merge(
        [
            FileUpload::make('avatar')
                ->directory('avatar')
                ->image(),
        ],parent::getUpdateProfileFormSchema()
    );
}
}
