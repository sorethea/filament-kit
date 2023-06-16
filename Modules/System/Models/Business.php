<?php

namespace Modules\System\Models;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model implements HasShieldPermissions
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\System\Database\factories\BusinessFactory::new();
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
        ];
    }
}
