<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'card_id',
        'price',
        'order_status',
        'order_type',
        "openid",
        'type',
        "pay_id"
    ];

    protected $hidden = [

    ];

    public $timestamps = true;
}
