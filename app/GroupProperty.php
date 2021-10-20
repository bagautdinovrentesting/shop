<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupProperty extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany('App\Property', 'group_id', 'id');
    }
}
