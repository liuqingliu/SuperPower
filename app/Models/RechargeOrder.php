<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RechargeOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'recharge_str',
        'equipment_id',
        'port',
        'recharge_total_time',
        'recharge_unit_second',
        'recharge_end_time',
        'recharge_price',
        'recharge_status',
        'type',
        'wat',
        'in_come_flag',
    ];

    public function chargingEquipment()
    {
        return $this->belongsTo(ChargingEquipment::class, 'equipment_id', 'equipment_id');
    }

    public $timestamps = true;
}
