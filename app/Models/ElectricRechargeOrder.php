<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectricRechargeOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id',
        'equipment_id',
        'jack_id',
        'recharge_unit_money',
        'recharge_time',
        'recharge_status',
    ];

    public $timestamps = true;
}