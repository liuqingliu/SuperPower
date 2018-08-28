@extends('layouts.default')

@section('title', '我的账户')

@section('content')
<section class="header">
    <!-- title -->
    <div class="text-center title-container">
        <a href="javascript:history.back(-1);" class="title-back">
            <img class="title-back-img" src="{{URL::asset('images/p2_01.png')}}" alt="返回">
            <span  class="title-back-text">返回</span>
        </a>
        <span class="title-text">我的账户</span>
    </div>
    <!-- title -->
</section>

<section class="body">
    <ul class="board1">
        <li class="borad-heighwithimg">
            <span class="borad-text-left text-left">我的头像</span>
            <img class="pull-right img-rounded header-img" src="{{URL::asset($user_info->headimgurl)}}">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">名字</span>
            <span class="borad-text-right pull-right">{{$user_info->nickname}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机号</span>
            @if (empty($user_info->phone))
                <a class="pull-right" href="#"><span class="borad-text-right">未绑定，点击可绑定</span><img src="{{URL::asset('images/p2_03.png')}}" class="img-right"></a>
            @else
                <span class="lower-title">{{$user_info->phone}}</span>
            @endif

        </li>
    </ul>
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">累计为爱车充电</span>
            <span class="borad-text-right pull-right">{{$user_info->charging_total_cnt}}次</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">累计充电时长</span>
            <span class="borad-text-right pull-right">{{$user_info->charging_total_time}}小时</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">账户余额</span>
            <span class="text-important pull-right">{{$user_info->user_money}}元</span>
        </li>
    </ul>
</section>

<section class="footer">
    <div align="center" style="margin-top:1.75rem;"><button class="button-style">马上充值</button></div>
</section>
@endsection