@extends('layouts.default')

@section('title', '个人中心')

@section('content')
<!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
<section class="header">
    <img src="{{URL::asset($user_info->headimgurl)}}" alt="头像" class="img-rounded header-img pull-left">
    <div class="header-title pull-left">
        <span class="higher-title">{{$user_info->nickname}}</span>
        <span class="lower-title sub-title-1">账号：{{$user_info->user_id}}</span>
        @if (empty($user_info->phone))
        <span class="lower-title">点这里绑定手机号，享更多优惠</span>
        @else
        <span class="lower-title">{{$user_info->phone}}</span>
        @endif
    </div>
    <img src="{{URL::asset('images/p1_01.png')}}" alt="绑定手机号" class="img-rounded bind-phone pull-right">
</section>
<section class="main">
    <ul class="list-group">
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_02.png')}}" alt="头像" class="img-rounded header-img pull-left">
            <span class="pull-left img-left font-1">账户充值(<span class="font-2">余额：{{$user_info->user_money}}元</span>)</span>
            <span class="pull-right img-right font-2">充值优惠<i class="hint-img"></i></span>
        </li>
        <li class="list-group-item item-hr"><hr></li>
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_04.png')}}" class="pull-left">
            <span class="pull-left img-left font-1">我的充电记录</span>
        </li>
    </ul>
    <ul class="list-group">
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_05.png')}}" class="pull-left">
            <span class="pull-left img-left font-1">电卡充值</span>
            <span class="pull-right img-right font-2">多充多送<i class="hint-img"></i></span>
        </li>
        <li class="list-group-item item-hr"><hr></li>
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_06.png')}}" class="pull-left">
            <span class="pull-left img-left font-1">正在充电</span>
        </li>
        <li class="list-group-item item-hr"><hr></li>
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_07.png')}}" class="pull-left">
            <span class="pull-left img-left font-1">附近电站</span>
        </li>
    </ul>
    <ul class="list-group">
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_08.png')}}" class="pull-left">
            <span class="pull-left img-left font-1">运营商管理平台</span>
        </li>
        <li class="list-group-item item-hr"><hr></li>
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_09.png')}}" class="pull-left">
            <span class="pull-left img-left font-1">诚邀合伙人加盟</span>
            <span class="pull-right img-right font-2">合作方式丰富多样<i class="hint-img"></i></span>
        </li>
        <li class="list-group-item item-hr"><hr></li>
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_10.png')}}" class="pull-left">
            <span class="pull-left img-left font-1">关于</span>
        </li>
    </ul>
</section>
<section class="footer">
    <nav class="navbar  navbar-fixed-bottom" role="navigation">
        <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="{{route("electric_recharge")}}">
                    <img src="{{URL::asset('images/p1_11_on.png')}}" class="bottom-img img-responsive center-block">
                    <span class="text-center center-block font-3">正在充电</span>
                </a>
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="#">
                    <img src="{{URL::asset('images/p1_12_off.png')}}" class="bottom-img img-responsive center-block">
                    <span class="text-center center-block font-3">扫码充电</span>
                </a>
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="#">
                    <img src="{{URL::asset('images/p1_13_on.png')}}" class="bottom-img img-responsive center-block">
                    <span class="text-center center-block font-4">个人中心</span>
                </a>
            </div>
        </div>
    </nav>
</section>
@endsection