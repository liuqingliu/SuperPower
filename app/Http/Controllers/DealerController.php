<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function center()
    {
        $totalIncome = Dealer::find(1)->total_income;
        //今日收益需要实时计算吗？ todo 询问
        $dayIncome = 122;
        $totalUsers = 133;
        $totalChargeCount = 143234;
        return view('dealer/center',[
            "day_income" => $dayIncome,
            "total_income" => $totalIncome,
            "total_users" => $totalUsers,
            "total_charge_count" => $totalChargeCount,
        ]);
    }

    public function electriccardmanage()
    {
        return view('dealer/electriccardmanage');
    }

    public function electricstationmanage()
    {
        return view('dealer/electricstationmanage');
    }

    public function manage()
    {
        return view('dealer/manage');
    }

    public function moneymanage()
    {
        $dealInfo = Dealer::find(1,["income_withdraw","total_income"]);
        $totalUsers = 133;
        $totalChargeCount = 143234;
        return view('dealer/moneymanage',[
            "income_withdraw" => $dealInfo->income_withdraw,
            "total_income" => $dealInfo->total_income,
            "total_users" => $totalUsers,
            "total_charge_count" => $totalChargeCount,
        ]);
    }
}