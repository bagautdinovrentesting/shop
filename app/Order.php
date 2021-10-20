<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $total
*/

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
<<<<<<< HEAD
        /*return $this->belongsToMany('App\Product');*/
=======
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

    public function setPayedStatus()
    {
        $this->update(['status' => OrderStatus::getPayedStatusId()]);
>>>>>>> cb444e4de05ba9a63380d554747b2a389b9182b3
    }
}
