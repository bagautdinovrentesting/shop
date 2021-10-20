<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'property_value_product');
    }
}
