<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $guarded = [];

    protected $table = 'order_status';

    public const CREATE_STATUS_CODE = 'CREATE';
    public const FINISH_STATUS_CODE = 'DONE';
    public const PAYED_STATUS_CODE = 'PAYED';

    public function orders()
    {
        return $this->hasMany('App\Order', 'status_id');
    }

    public static function getCreateStatusId() : int
    {
        return self::select('id')->where('code', self::CREATE_STATUS_CODE)->first()->id;
    }

    public static function getPayedStatusId() : int
    {
        return self::select('id')->where('code', self::PAYED_STATUS_CODE)->first()->id;
    }

    public static function getFinishStatusId() : int
    {
        return self::select('id')->where('code', self::FINISH_STATUS_CODE)->first()->id;
    }
}
