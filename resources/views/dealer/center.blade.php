@extends('layouts.default')

@section('title', '首页')
@section('system', '运营商管理系统')
@section('content')

<section class="header">
    <div style="height:18.75rem;background: #F15A24;">
        @component('layouts._dealerheader')
            <strong>Whoops!</strong> Something went wrong!
        @endcomponent
        <!-- title -->
        <div style="height:14rem;">
            <div style="height: 7.75rem;padding-top: 1rem;" align="center">
                <p class="dealer-money-text" style="margin-bottom: 0.2rem;">{{$day_income}}</p>
                <p class="mini-text-white">今日收益</p>
            </div>
            <div style="height: 1px; padding-left: 1.75rem;padding-right: 1.75rem;">
                <div class="line-white"></div>
            </div>
            <div style="height: 6.25rem;padding-bottom: 1.75rem;padding-top: 1.75rem;">
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
    <div class="body-container">
        <div class="s-title borad-text-right">
            <img src="{{URL::asset('images/pm1_04.png')}}" />常用功能
        </div>
        <div class="nav row">
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="{{route('dealer_moneymanage')}}">
                    <img src="{{URL::asset('images/pm1_05.png')}}" class="img-responsive center-block nav-img">
                    <span class="borad-text-left text-center center-block nav-text">资金管理</span>
                </a>
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="{{route('dealer_manage')}}">
                    <img src="{{URL::asset('images/pm1_06.png')}}" class="img-responsive center-block nav-img">
                    <span class="borad-text-left text-center center-block nav-text">经销商管理</span>
                </a>
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="{{route('dealer_powerStationManage')}}">
                    <img src="{{URL::asset('images/pm1_07.png')}}" class="img-responsive center-block nav-img">
                    <span class="borad-text-left text-center center-block nav-text">电站管理</span>
                </a>
            </div>
        </div>
    </div>
</section>
<section class="footer">
    <div class="footer-container">
        <div class="s-title borad-text-right">
            <img src="{{URL::asset('images/pm1_04.png')}}" />通知公告
        </div>
    </div>
    <ul style="padding: 0;background: #FFFFFF;">
        <li class="message-item">
            <span class="text-40-77 item-content pull-left">关于系统升级</span>
            <span class="text-40-b3 pull-right item-date">2018-08-06</span>
            <div class="line-positong"><div class="line"></div></div>
        </li>
        <li class="message-item">
            <span class="text-40-77 item-content pull-left">关于系统升级</span>
            <span class="text-40-b3 pull-right item-date">2018-08-06</span>
            <div class="line-positong"><div class="line"></div></div>
        </li>
        <li class="message-item">
            <span class="text-40-77 item-content pull-left">关于系统升级</span>
            <span class="text-40-b3 pull-right item-date">2018-08-06</span>
            <div class="line-positong"><div class="line"></div></div>
        </li>
    </ul>
</section>
@endsection