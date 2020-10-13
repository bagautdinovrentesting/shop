<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewStatus extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
