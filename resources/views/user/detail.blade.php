<!DOCTYPE html>
<html lang="zh-Cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>我的账户</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!--你自己的样式文件 -->
    <link href="../css/userDetail.css" rel="stylesheet">
    <link href="../css/public.css" rel="stylesheet">
    <!-- 以下两个插件用于在IE8以及以下版本浏览器支持HTML5元素和媒体查询，如果不需要用可以移除 -->        <!--[if lt IE 9]>
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
            <img class="pull-right img-rounded header-img" src="../images/me.jpg">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">名字</span>
            <span class="borad-text-right pull-right">Ethan</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机号</span>
            <a class="pull-right" href="#"><span class="borad-text-right">未绑定，点击可绑定</span><img src="../images/p2_03.png" class="img-right"></a>
        </li>
    </ul>
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">累计为爱车充电</span>
            <span class="borad-text-right pull-right">10086次</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">累计充电时长</span>
            <span class="borad-text-right pull-right">10010小时</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">账户余额</span>
            <span class="text-important pull-right">5.5元</span>
        </li>
    </ul>
</section>

<section class="footer">
    <div align="center" style="margin-top:1.75rem;"><button class="button-style">马上充值</button></div>

</section>



<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
<script src="../js/jquery.js"></script>
<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
<script src="../js/bootstrap.min.js"></script>
</body>
</html>