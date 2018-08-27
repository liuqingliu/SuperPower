<!DOCTYPE html>
<html lang="zh-Cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>账户充值</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!--你自己的样式文件 -->
    <link href="../css/usersOrder.css" rel="stylesheet">
    <link href="../css/public.css" rel="stylesheet">
    <!-- 以下两个插件用于在IE8以及以下版本浏览器支持HTML5元素和媒体查询，如果不需要用可以移除 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<section class="header">
    <!-- title -->
    <div class="text-center title-container">
        <a href="#" class="title-back">
            <img class="title-back-img" src="../images/p2_01.png" alt="返回">
            <span class="title-back-text">返回</span>
        </a>
        <span class="title-text">账户充值</span>
    </div>
    <!-- title -->
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
            <span class=" pull-right mini-text-red">新客服专享优惠活动注册7天后结束<img src="../images/p6_01.png" class="img1"></span>
        </div>
        <div class="line"></div>
        <div>
            <ul class="recharge-ul">
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div class="money-block">
                        <div class="recharge-block_title mini-text-white">新客户专享</div>
                        <p class="text-48-grey recharge-block-text">充2元</p>
                        <p class="mini-text-red recharge-block-text">赠送1元</p>
                    </div>
                </li>
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div class="money-block">
                        <div class="recharge-block_title-hidden mini-text-white">新客户专享</div>
                        <p class="text-48-grey recharge-block-text">充2元</p>
                        <p class="mini-text-red recharge-block-text">赠送1元</p>
                    </div>
                </li>
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div class="money-block">
                        <div class="recharge-block_title mini-text-white">新客户专享</div>
                        <p class="text-48-grey recharge-block-text">充2元</p>
                        <p class="mini-text-red recharge-block-text">赠送1元</p>
                    </div>
                </li>
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div class="money-block">
                        <div class="recharge-block_title-hidden mini-text-white">新客户专享</div>
                        <p class="text-48-grey recharge-block-text">充2元</p>
                        <p class="mini-text-red recharge-block-text">赠送1元</p>
                    </div>
                </li>
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div class="money-block">
                        <div class="recharge-block_title mini-text-white">新客户专享</div>
                        <p class="text-48-grey recharge-block-text">充2元</p>
                        <p class="mini-text-red recharge-block-text">赠送1元</p>
                    </div>
                </li>
                <li class="col-xs-4 col-md-4 col-lg-4 recharge-block">
                    <div class="money-block">
                        <div class="recharge-block_title-hidden mini-text-white">新客户专享</div>
                        <p class="text-48-grey recharge-block-text">充2元</p>
                        <p class="mini-text-red recharge-block-text">赠送1元</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <p class="mini-text" style="margin-top: 0.7rem; margin-bottom: 0.6rem; margin-left: 1.4375rem; margin-right: 1.4375rem;">充值后账户余额可直接用于扫码充电，不必每次再进行付款操作，充值可享优惠，多充多送。</p>
    <div class="payway-div">
        <p class="borad-text-left">选择支付方式</p>

        <p class="pull-left borad-text-left">
            <img class="img-logo" src="../images/p6_04.png"> 微信支付
        </p>
        <img class="img-logo pull-right" src="../images/p6_05.png">

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

<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
<script src="../js/jquery.js"></script>
<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
<script src="../js/bootstrap.min.js"></script>
</body>

</html>
{{--onclick="callpay()"--}}
<script type="text/javascript">
    //调用微信JS api 支付
    function jsApiCall()
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',{"appId":"wx604f85d199ae04c9","timeStamp":"1535206291","nonceStr":"5b816393b54cc","package":"prepay_id=wx2522113121896933df54b5b91814180647","signType":"MD5","paySign":"B1B1BAE3C83619FC261D44D94F18BA63"},
            function(res){
                WeixinJSBridge.log(res.err_msg);
                alert(res.err_code+res.err_desc+res.err_msg);
            }
        );
    }

    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }
</script>