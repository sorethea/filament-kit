<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'logo',
        'image',
        'description',
        'address',
        'latitude',
        'longitude',
        'phone',
        'mobile',
        'admin_commission_mode',
        'admin_commission',
        'admin_commission_tax',
        'delivery_fee',
        'default_tax',
        'service_charge',
        'packaging_fee',
        'delivery_range',
        'available_for_delivery',
        'closed',
        'information',
        'active',
        'settlement_mode',
        'payment_mode',
        'close_at',
        'open_at',
    ];

    protected static function newFactory()
    {
        return \Modules\Restaurant\Database\factories\RestaurantFactory::new();
    }
}
