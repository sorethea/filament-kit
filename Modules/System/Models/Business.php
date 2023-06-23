<?php

namespace Modules\System\Models;

use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Business extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saved(function ($model){
            if($model->owner_id){
                $owner = User::find($model->owner_id);
                if(!empty($owner) && !$owner->hasRole(config('system.roles.owner'))) $owner->assignRole(config('system.roles.owner'));
            };
        });
    }

    protected $fillable = [
        'name',
        'logo',
        'start_date',
        'currency_id',
        'owner_id',
        'phone_number',
    ];
    protected $casts = [
        'ref_no_prefixes' => 'array',
        'enabled_modules' => 'array',
        'email_settings' => 'array',
        'sms_settings' => 'array',
        'common_settings' => 'array',
        'weighing_scale_setting' => 'array',
    ];
    protected static function newFactory()
    {
        return \Modules\System\Database\factories\BusinessFactory::new();
    }

    public function currency():BelongsTo{
        return $this->belongsTo(Currency::class);
    }

    public function locations():HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id','id');
    }

}
