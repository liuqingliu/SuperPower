@extends('layouts.default')

@section('title', '账户充值')

@section('content')
<section class="header">
    @component('layouts._header')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
    <div class="headr-div">
        <div align="center">
            <span class="mini-text-white">您的账户余额(元)</span><br>
            <span class="big-text-white money"> <span class="yuan">￥</span>18.56</span>
        </div>
    </div>

</section>
<section class="body">
    <div class="big-div">
        <div class="borad-heigh">
            <span class="pull-left borad-text-left">选择充值金额</span>
            <span class=" pull-right mini-text-red">新客服专享优惠活动注册7天后结束<img src="{{URL::asset('images/p6_01.png')}}" class="img1"></span>
        </div>
        <div class="line"></div>
        <div>
            <ul class="recharge-ul">
                @foreach($pay_money_list as $pament_money)
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div class="money-block">
                        <div class="recharge-block_title mini-text-white">新客户专享</div>
                        <p class="text-48-grey recharge-block-text">充{{$pament_money["real_price"]}}元</p>
                        <p class="mini-text-red recharge-block-text">赠送{{$pament_money["given_price"]}}元</p>
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
<section class="footer">
    <div align="center" style="margin-top:1.5rem;">
        <button class="button-style">马上充值</button>
    </div>
    <div align="center" style="margin-top:1.25rem;">
        <a href="#" onclick="" class="mini-text">为电卡充值，点击这里</a>
    </div>
</section>
@endsection
{{--onclick="callpay()"--}}
{{--<script type="text/javascript">--}}
    {{--//调用微信JS api 支付--}}
    {{--function jsApiCall()--}}
    {{--{--}}
        {{--WeixinJSBridge.invoke(--}}
            {{--'getBrandWCPayRequest',{"appId":"wx604f85d199ae04c9","timeStamp":"1535206291","nonceStr":"5b816393b54cc","package":"prepay_id=wx2522113121896933df54b5b91814180647","signType":"MD5","paySign":"B1B1BAE3C83619FC261D44D94F18BA63"},--}}
            {{--function(res){--}}
                {{--WeixinJSBridge.log(res.err_msg);--}}
                {{--alert(res.err_code+res.err_desc+res.err_msg);--}}
            {{--}--}}
        {{--);--}}
    {{--}--}}

    {{--function callpay()--}}
    {{--{--}}
        {{--if (typeof WeixinJSBridge == "undefined"){--}}
            {{--if( document.addEventListener ){--}}
                {{--document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);--}}
            {{--}else if (document.attachEvent){--}}
                {{--document.attachEvent('WeixinJSBridgeReady', jsApiCall);--}}
                {{--document.attachEvent('onWeixinJSBridgeReady', jsApiCall);--}}
            {{--}--}}
        {{--}else{--}}
            {{--jsApiCall();--}}
        {{--}--}}
    {{--}--}}
{{--</script>--}}