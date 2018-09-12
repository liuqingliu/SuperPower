@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/orderpay.js')}}?v=2.0"></script>
@endsection
@section('title', '电卡充值')
@section('system', '个人中心')
@section('content')

<section class="header">
    <!-- title -->
    <div class="text-center title-container">
        <a href="javascript:history.back(-1);" class="title-back">
            <img class="title-back-img" src="{{URL::asset('images/p2_01.png')}}" alt="返回">
            <span class="title-back-text">返回</span>
        </a>
        <span class="title-text">电卡充值</span>
    </div>
    <!-- title -->
</section>

<section class="body">
    <ul class="board1">
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_05.png')}}" alt="电卡卡号">
            <span class="borad-text-left">电卡卡号</span>
            <input class="my-input1 borad-text-left" type="number" name="identifying-code" placeholder="点击输入卡号" oninput="if(value.length>11)value=value.slice(0,11)">
            <img class="borad-img-right pull-right img-rounded" src="{{URL::asset('images/p9_02.png')}}">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p9_05.png')}}" alt="电卡余额">
            <span class="borad-text-left">电卡余额</span>
            <span class="borad-text-right" style="margin-left: 1.15rem;">10.08元</span>
        </li>
    </ul>
    <p class="mini-text" style="margin-top: 0.7rem; margin-bottom: 0.6rem; margin-left: 1.4375rem; margin-right: 1.4375rem;">提示：充值前请仔细核对卡号，若因卡号输错等原因造成充值不到账，平台概不负责。</p>
    <div class="big-div">
        <div class="borad-heigh">
            <span class="pull-left borad-text-left">选择充值金额</span>
            <span class=" pull-right mini-text-red" style="visibility: hidden;">新客服专享优惠活动注册7天后结束<img src="{{URL::asset('images/p6_01.png')}}" class="img1"></span>
        </div>
        <div class="line"></div>
        <div>
            <ul class="recharge-ul">
                @foreach($pay_money_list as $pament_money)
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div  class="money-block">
                        <div class="order_tag recharge-block_title mini-text-white">新客户专享</div>
                        <p class="real_price text-48-grey recharge-block-text">充{{$pament_money["real_price"]}}元</p>
                        <p class="given_price mini-text-red recharge-block-text">赠送{{$pament_money["given_price"]}}元</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="payway-div" style="margin-top: 1rem;">
        <p class="borad-text-left">选择支付方式</p>

        <p class="pull-left borad-text-left">
            <img class="img-logo" src="{{URL::asset('images/p6_04.png')}}"> 微信支付
        </p>
        <img class="img-logo pull-right" src="{{URL::asset('images/p6_05.png')}}">

    </div>
</section>

<section class="footer">
    <div align="center" style="margin-top:1.5rem;">
        <button class="button-style">马上充值</button>
    </div>
    <div align="center" style="margin-top:1.25rem;">
        <a href="{{route('user_order')}}" onclick="" class="mini-text">为账户充值，点击这里</a>
    </div>
</section>

@endsection