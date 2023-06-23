<?php

namespace Modules\System\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Modules\System\Models\Business;

trait HasBusiness
{
    public function business(): HasOneOrMany
    {
        return $this->hasOneOrMany(Business::class);
    }
}
