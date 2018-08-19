<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'price',
        'order_status',
        'order_type',
    ];

    protected $hidden = [
        "openid","pay_id"
    ];

    public $timestamps = true;
}
