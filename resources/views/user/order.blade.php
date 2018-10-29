@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/order.js?v=1.2')}}"></script>
@endsection
@section('title', '账户充值')
@section('system', '个人中心')
@section('content')
<section class="header">
    @component('layouts._userheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
    <div class="headr-div">
        <div align="center">
            <span class="mini-text-white">您的账户余额(元)</span><br>
            <span class="big-text-white money"> <span class="yuan">￥</span>{{$user_money}}</span>
        </div>
    </div>

</section>
<section class="body">
    <div class="big-div">
        <div class="borad-heigh">
            <span class="pull-left borad-text-left">选择充值金额</span>
            {{--@if($new_user)--}}
            <span class=" pull-right mini-text-red" data-toggle="modal" data-target="#newUserDialog">新客服专享优惠活动注册7天后结束<img src="{{URL::asset('images/p6_01.png')}}" class="img1"></span>
                {{--@endif--}}
        </div>
        <div class="line"></div>
        <div>
            <ul class="recharge-ul">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                @foreach($pay_money_list as $pament_money)
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div class="money-block" data-real_price = "{{$pament_money["real_price"]}}">
                        @if($new_user)
                        <div data-new_user= "{{$new_user}}" class="recharge-block_title mini-text-white">新客户专享</div>
                        @else
                            <div class="recharge-block_title mini-text-white" style="visibility: hidden">新客户专享</div>
                        @endif
                        <p class="real_price text-48-grey recharge-block-text">充{{$pament_money["real_price"]}}元</p>
                        <p class="given_price mini-text-red recharge-block-text">赠送{{$pament_money["given_price"]}}元</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <p class="mini-text" style="margin-top: 0.7rem; margin-bottom: 0.6rem; margin-left: 1.4375rem; margin-right: 1.4375rem;">充值后账户余额可直接用于扫码充电，不必每次再进行付款操作，充值可享优惠，多充多送。</p>
    <div class="payway-div">
        <p class="borad-text-left">选择支付方式</p>

        <p class="pull-left borad-text-left">
            <img class="img-logo" src="{{URL::asset('images/p6_04.png')}}"> 微信支付
        </p>
        <img class="img-logo pull-right" src="{{URL::asset('images/p6_05.png')}}">

    </div>
</section>
{{--dialog--}}
<div class="modal fade" id="newUserDialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div style="min-height: 15.625rem;" class="center-dialog">
        <div style="min-height:12.125rem;width: 100%;padding: 1.5rem;margin-bottom: 3.5rem;" >
            <div style="text-align: center;"><p class="text-48-red">新用户优惠专享说明</p></div>
            <p class="text-36" >1.仅新用户有资格参与</p>
            <p class="text-36" >2.一个账号只能享受一次优惠</p>
            <p class="text-36" style="margin-bottom: 0;" >3.新用户专享优惠注册7天内有效。注册7天后优惠将自动消失。</p>
        </div>
        <div class="line-dialog"></div>
        <div class="dialog-single-button" data-dismiss="modal">知道了</div>
    </div>
</div>
<section class="footer">
    <div align="center" style="margin-top:1.5rem;">
        <a id="gopay" class="button-style" onclick="creatOrder()">马上充值</a>
    </div>
    <div align="center" style="margin-top:1.25rem;">
        <a href="{{route('electric_cardorderpay')}}" class="mini-text">为电卡充值，点击这里</a>
    </div>
</section>
@endsection
