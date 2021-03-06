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
        'board_info',//插板信息
        'jack_info',
        'net_status',
        'charging_cost',
        'charging_unit_second',
        'active_time',
        'openid',//经销商openid
        'manager_phone',//管理人员手机号
    ];

    public $timestamps = true;

    public function rechargeorders()
    {
        return $this->hasMany(RechargeOrder::class, 'equipment_id', 'equipment_id');
    }

    public function equipmentports()
    {
        return $this->hasMany(EquipmentPort::class, 'equipment_id', 'equipment_id');
    }

    public function cashLogs()
    {
        return $this->hasMany(Cashlog::class, 'equipment_id', 'equipment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'openid', 'openid');
    }
}
