<?php

namespace Modules\System\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'landmark',
        'city',
        'mobile',
    ];

    protected $table = 'business_locations';

    protected static function newFactory()
    {
        return \Modules\System\Database\factories\LocationFactory::new();
    }
}
