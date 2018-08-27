<!DOCTYPE html>
<html lang="zh-Cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>绑定手机号</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!--你自己的样式文件 -->
    <link href="../css/userBindphone.css" rel="stylesheet">
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
        <span class="title-text">绑定手机号</span>
    </div>
    <!-- title -->
</section>
<section class="body1">
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">手机号码</span>
            <input class="my-input1 borad-text-left" type="number" name="identifying-code" placeholder="请输您的手机号" oninput="if(value.length>11)value=value.slice(0,11)">
            <a href="#" onclick="" class="borad-text-left pull-right">获取验证码</a>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">验证码</span>
            <input class="my-input2 borad-text-left" type="number" name="identifying-code" placeholder="请输6位验证码" oninput="if(value.length>6)value=value.slice(0,6)">
        </li>
    </ul>
    <div style="margin-top:0.5rem;">
        <span class="info mini-text">绑定手机号后，可享受更多优惠政策，充电更便宜</span>
    </div>
    <div align="center" style="margin-top:1.5rem;"><button class="button-style">提交</button></div>
</section>
<section class="body2">
    <div style="margin-top: 2.5rem;">
        <span class="info borad-text-left">为确保资金安全，请验证您的提现密码</span>
    </div>
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">提现密码</span>
            <input class="my-input3" type="password" name="password" placeholder="请输入提现密码" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
    </ul>
    <div align="center" style="margin-top:2rem;">
        <button class="button-style">提交</button>
    </div>
    <div align="center" style="margin-top:1.5rem;">
        <a href="#" onclick="" class="mini-text">我忘了提现密码</a>
    </div>
</section>

<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
<script src="../js/jquery.js"></script>
<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
<script src="../js/bootstrap.min.js"></script>
</body>

</html>