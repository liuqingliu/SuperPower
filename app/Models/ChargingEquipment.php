<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargingEquipment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipment_id',
        'province',
        'city',
        'area',
        'street',
        'address',
        'equipment_status',//设备状态,0,默认，1,已激活,2,禁用
        'jack_info',
        'net_status',
        'charging_cost',
        'charging_unit_price',
        'active_time',
        'parent_user_id',
        'manager_phone',
    ];

    public $timestamps = true;

    public function userrechargeorders()
    {
        return $this->hasMany(UserRechargeOrder::class, 'equipment_id', 'equipment_id');
    }
}
