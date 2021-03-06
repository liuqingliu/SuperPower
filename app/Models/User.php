<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'headimgurl', //微信头像
        'nickname', //微信昵称
        'phone', //用户手机号
        'user_last_login',//最后登录时间
        'user_status',//用户状态
        'user_type',//用户类型
        'user_money',//用户余额
        'charging_total_cnt',//累计充电次数
        'charging_total_time',//累计充电时长
        'ip',//用户注册ip
        'openid',
        'user_id',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $timestamps = true;

    public function dealer()
    {
        return $this->hasOne(Dealer::class, 'openid', 'openid');
    }

    public function electricCards()
    {
        return $this->hasMany(ElectricCard::class, 'openid', 'openid');
    }

    public function cashLogs()
    {
        return $this->hasMany(CashLog::class, 'openid', 'openid');
    }

    public function chargingEquipment()
    {
        return $this->hasMany(ChargingEquipment::class, 'openid', 'openid');
    }
}
