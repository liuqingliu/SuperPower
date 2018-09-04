@extends('layouts.default')

@section('title', '我的充电记录')
@section('system', '个人中心')
@section('content')
<section class="header">
    <!-- title -->
    <div class="text-center title-container">
        <a href="javascript:history.back(-1);" class="title-back">
            <img class="title-back-img" src="{{URL::asset('images/p2_01.png')}}" alt="返回">
            <span  class="title-back-text">返回</span>
        </a>
        <span class="title-text">我的充电记录</span>
    </div>
    <!-- title -->
</section>
<section class="body">
    <p class="mini-text" style="margin-top: 1.5625rem; margin-left: 3.125rem; ">扫码充电记录</p>

    <ul style="padding: 0;">
        <li class="item">
            <img src="{{URL::asset('images/p8_01.png')}}" class="item-img">
            <span class="item-location mini-text">锦江区锦城逸景B区 5号充电站5号插座</span>
            <span class="rechargelog-item-date mini-text">2018-08-23</span>
            <span class="item-time-interval mini-text">10:35~15:05</span>
            <span class="item-money text-42-red">0.85元</span>
            <span class="item-time-total text-42-red">5小时30分钟</span>
            <div class="item-line"><div class="line"></div></div>
        </li>
        <li class="item">
            <img src="{{URL::asset('images/p8_01.png')}}" class="item-img">
            <span class="item-location mini-text">锦江区锦城逸景B区 5号充电站5号插座</span>
            <span class="rechargelog-item-date mini-text">2018-08-23</span>
            <span class="item-time-interval mini-text">10:35~15:05</span>
            <span class="item-money text-42-red">0.85元</span>
            <span class="item-time-total text-42-red">5小时30分钟</span>
            <div class="item-line"><div class="line"></div></div>
        </li>
        <li class="item">
            <img src="{{URL::asset('images/p8_01.png')}}" class="item-img">
            <span class="item-location mini-text">锦江区锦城逸景B区 5号充电站5号插座</span>
            <span class="rechargelog-item-date mini-text">2018-08-23</span>
            <span class="item-time-interval mini-text">10:35~15:05</span>
            <span class="item-money text-42-red">0.85元</span>
            <span class="item-time-total text-42-red">5小时30分钟</span>
            <div class="item-line"><div class="line"></div></div>
        </li>
    </ul>
</section>
<section class="footer">
    <div align="center" style="margin-top:1.5rem;">
        <button class="button-style">查看更多记录</button>
    </div>
</section>
@endsection