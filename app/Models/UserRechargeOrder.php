<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRechargeOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'equipment_id',
        'jack_id',
        'recharge_unit_money',
        'recharge_time',
    ];

    public function chargingEquipment()
    {
        return $this->belongsTo(ChargingEquipment::class, 'equipment_id', 'equipment_id');
    }

    public $timestamps = true;
}
