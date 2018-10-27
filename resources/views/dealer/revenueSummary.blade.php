
@extends('layouts.default')

@section('title', '营收汇总')
@section('system', '运营商管理系统')
@section('content')

<section class="header">
    <div style="height:10rem;background: #F15A24;">
       @component('layouts._dealerheader',['type'=>$type])
            <strong>Whoops!</strong> Something went wrong!
        @endcomponent
        <!-- title -->
        <div style="height:5.25rem;">
            <div style="height: 5.25rem;padding-bottom: 1rem;padding-top: 1rem;">
                <div class="col-xs-4 col-md-4 col-lg-4" align="center">
                    <p class="mini-text-white-number" style="margin: 0;">{{$total_income}}</p>
                    <p class="mini-text-white">累计收益</p>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-4 hasline" align="center">
                    <div class="line-vertical-white vertical"></div>
                    <p class="mini-text-white-number" style="margin: 0;">{{$total_users}}</p>
                    <p class="mini-text-white">累计用户</p>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-4 hasline" align="center">
                    <div class="line-vertical-white vertical"></div>
                    <p class="mini-text-white-number" style="margin: 0;">{{$total_charge_count}}</p>
                    <p class="mini-text-white">累计充电次数</p>
                </div>
            </div>
        </div>
    </div>

</section>
<section class="body">
    <div class="revenus-container">
        <div class="board1" style="padding-top: 1.1rem;">
            <ul style="padding: 0;">
                <li class="revenus-heigh">
                    <span class="borad-text-left">起止时间：</span>
                    <span class="borad-text-right">注册时间-昨天</span>
                </li>
                <li class="revenus-heigh">
                    <span class="borad-text-left">数据来源：</span>
                    <span class="borad-text-right">全部</span>
                </li>
                <li class="revenus-heigh">
                    <span class="borad-text-left">营收总汇：</span>
                    <span class="borad-text-red">111.11</span>
                </li>
            </ul>
            <div align="center" style="margin-top:2rem;">
                <a class="button-style3">查询</a>
            </div>
        </div>
    </div>
</section>
<section class="footer">
    <ul style="padding: 0;">
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1rem;">
                <span class="pull-left text-36">李小龙</span>
                <span class="pull-right text-36-red">1346.01</span>
            </div>
            <div class="revenus-item-row" style="top:2.5rem;">
                <span class="pull-left mini-text">18081884532</span>
                <span class="pull-right mini-text">四川省成都市锦江区</span>
            </div>
            <div class="revenus-item-row" style="top:4rem;">
                <span class="pull-left mini-text">510922199913254567</span>
                <span class="pull-right mini-text-red">冻结</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1rem;">
                <span class="pull-left text-36">李小龙</span>
                <span class="pull-right text-36-red">1346.01</span>
            </div>
            <div class="revenus-item-row" style="top:2.5rem;">
                <span class="pull-left mini-text">18081884532</span>
                <span class="pull-right mini-text">四川省成都市锦江区</span>
            </div>
            <div class="revenus-item-row" style="top:4rem;">
                <span class="pull-left mini-text">510922199913254567</span>
                <span class="pull-right mini-text-red">冻结</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1rem;">
                <span class="pull-left text-36">李小龙</span>
                <span class="pull-right text-36-red">1346.01</span>
            </div>
            <div class="revenus-item-row" style="top:2.5rem;">
                <span class="pull-left mini-text">18081884532</span>
                <span class="pull-right mini-text">四川省成都市锦江区</span>
            </div>
            <div class="revenus-item-row" style="top:4rem;">
                <span class="pull-left mini-text">510922199913254567</span>
                <span class="pull-right mini-text-red">冻结</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
    </ul>
    <div align="center">
        <a href="#" class="text-45-b3">查看更多</a>
    </div>
</section>
@endsection