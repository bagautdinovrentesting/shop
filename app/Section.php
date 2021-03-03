<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */

class Section extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function parent()
    {
        return $this->belongsTo('App\Section');
    }
}
