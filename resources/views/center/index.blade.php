<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0,user-scalable=0" />
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>个人中心</title>

    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- 私有 -->
    <link href="{{URL::asset('css/index.css?v=1.4')}}" rel="stylesheet">
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
<section class="header container">
    <img src="{{URL::asset('images/header.png')}}" alt="头像" class="img-rounded header-img pull-left">
    <div class="header-title pull-left">
        <span class="higher-title">Tristan</span>
        <span class="lower-title sub-title-1">账号：15701160070</span>
        <span class="lower-title">点这里绑定手机号，享更多优惠</span>
    </div>
    <img src="{{URL::asset('images/p1_01.png')}}" alt="绑定手机号" class="img-rounded bind-phone pull-right">
</section>
<section class="main">
    <ul class="list-group">
        <li class="list-group-item">
            <img src="{{URL::asset('images/p1_02.png')}}" alt="头像" class="img-rounded header-img pull-left">
            <span class="pull-left img-left font-1">账户充值(<span class="font-2">余额：18.261元</span>)</span>
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
        <div class="row container">
            <div class="col-xs-4">
                <a href="#">
                    <img src="{{URL::asset('images/p1_11_on.png')}}" class="bottom-img img-responsive center-block">
                    <span class="text-center center-block font-3">正在充电</span>
                </a>
            </div>
            <div class="col-xs-4">
                <a href="#">
                    <img src="{{URL::asset('images/p1_12_off.png')}}" class="bottom-img img-responsive center-block">
                    <span class="text-center center-block font-3">扫码充电</span>
                </a>
            </div>
            <div class="col-xs-4">
                <a href="#">
                    <img src="{{URL::asset('images/p1_13_on.png')}}" class="bottom-img img-responsive center-block">
                    <span class="text-center center-block font-4">个人中心</span>
                </a>
            </div>
        </div>
    </nav>
</section>
<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>