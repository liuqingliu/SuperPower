<!DOCTYPE html>
<html lang="zh-Cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>正在充电</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!--你自己的样式文件 -->
    <link href="../css/recharge.css" rel="stylesheet">
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
        <span class="title-text">正在充电</span>
    </div>
    <!-- title -->
</section>
<section class="body">
    <p class="mini-text tip">电力正在源源不断的充入你的爱车。</p>
    <div class="bigimg-container">
        <img src="../images/p16_01.gif" class="recharge-img"/>
    </div>
    <div style="height: 9.5rem;">
        <div class="pull-left container1">
					<span class="content1">
						<img src="../images/p16_02.png" class="content-img"/>
						钢铁领街3号充电站20号插座
					</span>
            <span class="content2">
						<img src="../images/p16_03.png" class="content-img"/>
						已充3小时25分钟
					</span>
        </div>
        <div class="container2 pull-right">
            <div class="pull-left" style="height: 9.5rem; padding-bottom: 1rem;padding-top: 1rem;"><div class="line-vertical"></div></div>
            <div class="big-text" style="margin-top: 2.5rem;">计费标准</div>
            <div class="big-text">1元/6小时</div>
            <!--<span class="big-text">1元/6小时</span>-->
        </div>

    </div>
    <div class="line-dark"></div>
</section>
<section class="footer">
    <div class="container3">
        <img src="../images/p16_07.png" class="img-status" />
    </div>
    <p class="mini-text fooet-des" style="margin-top: 2rem;">正在充电，点击上方按钮可停止充电</p>
    <p class="mini-text fooet-des">充满或到时间后，充电会自动停止</p>
</section>


<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
<script src="../js/jquery.js"></script>
<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
<script src="../js/bootstrap.min.js"></script>
</body>
</html>