<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }
}
