@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/cardorderpay.js?v=1.4')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jweixin-1.2.0.js?')}}" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $wxjssdk; ?>);
    </script>
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
            <input id="cardNum" class="my-input1 borad-text-right" readonly @isset($card_id) value="{{$card_id}}" @endisset placeholder="点击输入卡号" data-toggle="modal" data-target="#cardNumInput" >
            <img class="borad-img-right pull-right img-rounded" onclick="scanCard()" src="{{URL::asset('images/p9_02.png')}}">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p9_05.png')}}" alt="电卡余额">
            <span class="borad-text-left">电卡余额</span>
            <span class="borad-text-right" style="margin-left: 1.85rem;">{{$money or 0.00}}</span>
        </li>
    </ul>
    {{--dialog--}}
    <div class="modal" id="cardNumInput" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div style="min-height: 14.5rem;" class="center-dialog">
            <div style="min-height:11rem;width: 100%;padding: 1.5rem;margin-bottom: 3.5rem;" >
                <p class="borad-text-left">请正确输入11位电卡卡号，并仔细核对</p>
                <input id="dialogInput" style="height:3.4625rem;border: 0;outline:none;" class="borad-text-left" data-toggle="modal" data-target="#newUserDialog" type="number" placeholder="请输入电卡卡号" oninput="if(value.length>11)value=value.slice(0,11)">
            </div>
            <div style="width: 100%;height: 1px;background:url('/images/p16_06.png');position: absolute;bottom: 3.535rem;"></div>
            <div style="height:3.4375rem;width: 100%; line-height: 3.4375rem;position:absolute;bottom: 0;">
                <div data-dismiss="modal" class="pull-left" style="height:3.4375rem;width: 50%;text-align: center;color: #777777;font-size: 1.65rem;">取消
                    <div class="line-vertical pull-right" style="height: 3.4375rem;width: 1px;"></div>
                </div>
                <div class="pull-right" onclick="Values()" style="height:3.4375rem;width: 50%;text-align: center;color: #F15A24;font-size: 1.65rem;">确定</div>
            </div>
        </div>
    </div>
    <p class="mini-text" style="margin-top: 0.7rem; margin-bottom: 0.6rem; margin-left: 1.4375rem; margin-right: 1.4375rem;">提示：充值前请仔细核对卡号，若因卡号输错等原因造成充值不到账，平台概不负责。</p>
    <div class="big-div">
        <div class="borad-heigh">
            <span class="pull-left borad-text-left">选择充值金额</span>
        </div>
        <div class="line"></div>
        <div>
            <ul class="recharge-ul">
                @foreach($pay_money_list as $pament_money)
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div  class="money-block">
                        <p class="real_price text-48-grey" style="margin-top: 1rem;margin-bottom: 0;">充{{$pament_money["real_price"]}}元</p>
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
        <button class="button-style" onclick="confirmInfo()">马上充值</button>
    </div>
    <div align="center" style="margin-top:1.25rem;">
        <a href="{{route('user_order')}}" onclick="" class="mini-text">为账户充值，点击这里</a>
    </div>
    {{--confirmDialog--}}
    <div class="modal" id="confirmDialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div style="min-height: 12.5rem;" class="center-dialog">
            <div style="min-height:9rem;width: 100%;padding: 1.5rem;margin-bottom: 3.5rem;" >
                <p class="borad-text-left" id="cardInfo"></p>
                <p class="borad-text-left" style="margin-bottom: 0;" id="moneyInfo"></p>
            </div>
            <div style="width: 100%;height: 1px;background:url('/images/p16_06.png');position: absolute;bottom: 3.535rem;"></div>
            <div style="height:3.4375rem;width: 100%; line-height: 3.4375rem;position:absolute;bottom: 0;">
                <div data-dismiss="modal" class="pull-left" style="height:3.4375rem;width: 50%;text-align: center;color: #777777;font-size: 1.65rem;">取消
                    <div class="line-vertical pull-right" style="height: 3.4375rem;width: 1px;"></div>
                </div>
                <div class="pull-right" onclick="confirmedRecharge()" style="height:3.4375rem;width: 50%;text-align: center;color: #F15A24;font-size: 1.65rem;">确定</div>
            </div>
        </div>
    </div>




</section>

@endsection