<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'id_card',
        'parent_user_id',
        'province',
        'city',
        'area',
        'name',
        'total_income',
        'income_withdraw',
        'give_proportion',
        'remark',
    ];

    public $timestamps = true;
}
