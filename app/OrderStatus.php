<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $guarded = [];

    protected $table = 'order_status';

    public const FINISH_STATUS_ID = 2;

    public function orders()
    {
        return $this->hasMany('App\Order', 'status_id');
    }
}
