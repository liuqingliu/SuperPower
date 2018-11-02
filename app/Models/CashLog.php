<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'openid',
        'equipment_id',
        'cash_type',
        'cash_status',
        'cash_price',
        'cash_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'openid', 'openid');
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'openid', 'openid');
    }

    public function chargingEquipment()
    {
        return $this->belongsTo(ChargingEquipment::class, 'equipment_id', 'equipment_id');
    }
}
