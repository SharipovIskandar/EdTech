<?php

namespace App\Traits\Scopes;

use App\Models\Scopes\Contract\RegionalScope;

trait IsRegional
{
    protected static function bootIsRegional()
    {
        self::addGlobalScope(new RegionalScope);
    }

    public static function scopeWithOutIsRegional($query)
    {
        $query->withOutGlobalScope(RegionalScope::class);
    }
}
