<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->format('d.m.Y');
    }
}
