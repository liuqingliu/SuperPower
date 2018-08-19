<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectricCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id',
        'bind_phone',
        'card_status',
        'parent_user_id',
        'active_time',
        'money',
    ];

    public $timestamps = true;

}