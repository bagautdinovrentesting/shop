<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'sort', 'type', 'multiple', 'group_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\GroupProperty', 'group_id', 'id');
    }

    public function values()
    {
        return $this->hasMany('App\PropertyValue');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'property_value_product');
    }
}
