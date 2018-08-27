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
<section class="body1" style="display: none;">
    <div class="img-container">
        <img src="../images/p13_01.png" class="img-status" />
    </div>
    <div align="center" style="margin-top:1rem;">
        <span class="text-48-grey">已成功充值，金额实时到账</span>
    </div>
    <div style="margin-top: 50px;">
        <button class="button-style">返回个人中心</button>
    </div>
</section>
<section class="body2">
    <div class="img-container">
        <img src="../images/p14_01.png" class="img-status" />
    </div>
    <div align="center" style="margin-top:1rem;">
				<span class="text-48-grey">获取充值结果失败，请重试
        		</span>
    </div>
    <div style="margin-top: 50px;">
        <button class="button-style">重新获取</button>
    </div>
</section>

<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
<script src="../js/jquery.js"></script>
<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
<script src="../js/bootstrap.min.js"></script>
</body>

</html>