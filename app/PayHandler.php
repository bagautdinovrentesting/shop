<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/** @property string $handler*/

class PayHandler extends Model
{
    public const STATUS_ACTIVE = 1;

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
