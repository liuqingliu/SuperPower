<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentPort extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipment_id',
        'port',
        'status',
    ];

    public $timestamps = true;

    public function chargingEquipment()
    {
        return $this->belongsTo(ChargingEquipment::class, 'equipment_id', 'equipment_id');
    }
}
