<!DOCTYPE html>
<html lang="zh-Cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>电卡充值</title>
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
        <span class="title-text">电卡充值</span>
    </div>
    <!-- title -->
</section>

<section class="body">
    <ul class="board1">
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="../images/p1_05.png" alt="电卡卡号">
            <span class="borad-text-left">电卡卡号</span>
            <input class="my-input1 borad-text-left" type="number" name="identifying-code" placeholder="点击输入卡号" oninput="if(value.length>11)value=value.slice(0,11)">
            <img class="borad-img-right pull-right img-rounded" src="../images/p9_02.png">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <img class="borad-img pull-left img-rounded" src="../images/p9_05.png" alt="电卡余额">
            <span class="borad-text-left">电卡余额</span>
            <span class="borad-text-right" style="margin-left: 1.15rem;">10.08元</span>
        </li>
    </ul>
    <p class="mini-text" style="margin-top: 0.7rem; margin-bottom: 0.6rem; margin-left: 1.4375rem; margin-right: 1.4375rem;">提示：充值前请仔细核对卡号，若因卡号输错等原因造成充值不到账，平台概不负责。</p>
    <div class="big-div">
        <div class="borad-heigh">
            <span class="pull-left borad-text-left">选择充值金额</span>
            <span class=" pull-right mini-text-red" style="visibility: hidden;">新客服专享优惠活动注册7天后结束<img src="../images/p6_01.png" class="img1"></span>
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
    <div class="payway-div" style="margin-top: 1rem;">
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
        <a href="#" onclick="" class="mini-text">为账户充值，点击这里</a>
    </div>
</section>

<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
<script src="../js/jquery.js"></script>
<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
<script src="../js/bootstrap.min.js"></script>
</body>

</html>