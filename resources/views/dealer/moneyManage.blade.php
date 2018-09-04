@extends('layouts.default')

@section('title', '资金管理')
@section('system', '运营商管理系统')
@section('content')
<section class="header">
    <div style="height:18.75rem;background: #F15A24;">
        @component('layouts._dealerheader')
            <strong>Whoops!</strong> Something went wrong!
        @endcomponent
        <!-- title -->
        <div style="height:15rem;">
            <div style="height: 8.75rem;padding-top: 2.3rem;" align="center">
                <p class="dealer-money-text" style="margin-bottom: 0.2rem;">88.23</p>
                <p class="mini-text-white">可提现金额</p>
            </div>
            <div style="height: 1px; padding-left: 1.75rem;padding-right: 1.75rem;">
                <div class="line-white"></div>
            </div>
            <div style="height: 6.25rem;padding-bottom: 1.75rem;padding-top: 1.75rem;">
                <div class="col-xs-4 col-md-4 col-lg-4" align="center">
                    <p class="mini-text-white-number" style="margin: 0;">2000000.00</p>
                    <p class="mini-text-white">累计收益</p>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-4 hasline" align="center">
                    <div class="line-vertical-white vertical"></div>
                    <p class="mini-text-white-number" style="margin: 0;">10010</p>
                    <p class="mini-text-white">累计用户</p>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-4 hasline" align="center">
                    <div class="line-vertical-white vertical"></div>
                    <p class="mini-text-white-number" style="margin: 0;">2125552</p>
                    <p class="mini-text-white">累计充电次数</p>
                </div>
            </div>
        </div>
    </div>

</section>
<section class="body">
    <ul class="board1">
        <a href="{{route("dealer_takeOutMoney")}}">
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="../images/pm9_01.png" alt="我要提现">
            <span class="borad-text-left">我要提现</span>
            <img class="img-getin pull-right img-rounded" src="../images/p15_02.png">
        </li></a>
        <li class="line"></li>
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="../images/pm9_02.png" alt="收支明细">
            <span class="borad-text-left">收支明细</span>
            <img class="img-getin pull-right img-rounded" src="../images/p15_02.png">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="../images/pm9_03.png" alt="营收统计">
            <span class="borad-text-left">营收统计</span>
            <img class="img-getin pull-right img-rounded" src="../images/p15_02.png">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="../images/pm9_04.png" alt="用户充电记录">
            <span class="borad-text-left">用户充电记录</span>
            <img class="img-getin pull-right img-rounded" src="../images/p15_02.png">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="../images/pm9_05.png" alt="旁观账户设置">
            <span class="borad-text-left">旁观账户设置</span>
            <img class="img-getin pull-right img-rounded" src="../images/p15_02.png">
        </li>
    </ul>
</section>
<section class="footer">

</section>
@endsection