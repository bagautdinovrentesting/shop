<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/** @property string $handler*/

class PayHandler extends Model
{
    public const ACTIVE_STATUS = 1;

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE_STATUS);
    }
}
