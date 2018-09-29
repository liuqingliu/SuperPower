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
        'openid',
        'id_card',
        'parent_openid',
        'province',
        'city',
        'area',
        'name',
        'total_income',
        'income_withdraw',//总共提现数
        'give_proportion',
        'remark',
        'password',
        'bank_name',
        'bank_no',
        'bank_username',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'openid', 'openid');
    }

    public function cashLogs()
    {
        return $this->hasMany(Cashlog::class, 'openid', 'openid');
    }
}
