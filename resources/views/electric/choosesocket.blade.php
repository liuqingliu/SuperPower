<!DOCTYPE html>
<html lang="zh-Cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>选择插座</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!--你自己的样式文件 -->
    <link href="../css/choosesocket.css" rel="stylesheet">
    <link href="../css/public.css" rel="stylesheet">
    <!-- 以下两个插件用于在IE8以及以下版本浏览器支持HTML5元素和媒体查询，如果不需要用可以移除 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function showHideCode() {
            $("#detail").toggle();
        }
    </script>
</head>

<body>
<section class="header">
    <!-- title -->
    <div class="text-center title-container">
        <a href="#" class="title-back">
            <img class="title-back-img" src="../images/p2_01.png" alt="返回">
            <span class="title-back-text">返回</span>
        </a>
        <span class="title-text">选择插座</span>
    </div>
    <!-- title -->
</section>
<section class="body1">
    <div class="borad-text-left borad-heigh location-title">钢铁领域2号充电站
        <a href="#" onclick="showHideCode()"><img src="../images/p17_01.png" class="up-down" /></a>
    </div>
    <div class="location-detail" id="detail">
        <div class="detail1">
            <img src="../images/p18_02.png" class="detail-img" />
            <span class="mini-text">成都市成华区龙潭总部经济城成交撸26号</span>
        </div>
        <div class="detail1" style="margin-top: 0.5rem;">
            <img src="../images/p18_03.png" class="detail-img" />
            <span class="mini-text">设备编号008616236</span>
        </div>
        <div class="detail1" style="margin-top: 0.5rem;">
            <img src="../images/p18_04.png" class="detail-img" />
            <span class="mini-text">故障报修电话18081881234</span>
            <img src="../images/p18_05.png" class="detail-img pull-right" />
        </div>
    </div>
    <div class="div-big">
        <div style="height: 3.125rem;line-height: 3.125rem;text-align: center;padding-left: 1.75rem;padding-right: 1.75rem;">
            <span class="middle-text pull-left">充电口状态</span>
            <a href="#" class="middle-text pull-right">使用方法</a>
        </div>
        <div style="height: 13.0625rem;">
            <ul class="choose-block" style="padding-left: 0.599rem; padding-right:0.599rem;height: 13.0625rem;">
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block">
                    <div class="inner-block-no">
                        <p class="number-red-text block-text1">1号</p>
                        <p class="mini-text-red block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block">
                    <div class="inner-block-yes">
                        <p class="number-green-text block-text1">2号</p>
                        <p class="mini-text-green block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block">
                    <div class="inner-block-no">
                        <p class="number-red-text block-text1">3号</p>
                        <p class="mini-text-red block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block">
                    <div class="inner-block-yes">
                        <p class="number-green-text block-text1">2号</p>
                        <p class="mini-text-green block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block">
                    <div class="inner-block-no">
                        <p class="number-red-text block-text1">5号</p>
                        <p class="mini-text-red block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block2">
                    <div class="inner-block-yes">
                        <p class="number-green-text block-text1">6号</p>
                        <p class="mini-text-green block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block2">
                    <div class="inner-block-no">
                        <p class="number-red-text block-text1">7号</p>
                        <p class="mini-text-red block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block2">
                    <div class="inner-block-yes">
                        <p class="number-green-text block-text1">8号</p>
                        <p class="mini-text-green block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block2">
                    <div class="inner-block-no">
                        <p class="number-red-text block-text1">9号</p>
                        <p class="mini-text-red block-text2">充电中</p>
                    </div>
                </li>
                <li class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block2">
                    <div class="inner-block-yes">
                        <p class="number-green-text block-text1">10号</p>
                        <p class="mini-text-green block-text2">充电中</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div style="height: 12rem;background: #FFFFFF;">
        <p class="count-way middle-text2">
            <span class="middle-text">计费方式</span>
            （按时间计费精确到分钟，充1分钟只收一分钟的费用，明明白白消费，不花冤枉钱）
        </p>
        <div style="padding-left: 1.75rem;padding-right: 1.75rem;">
            <div class="line"></div>
        </div>
        <div style="height: 7.7rem;">
            <p class="count-way2 middle-text2">
                <span class="middle-text">标准功率资费</span>
                （指300瓦充电功率以下，绝大多数车辆适用）
            </p>
            <div style="height: 3rem;">
                <div class="col-xs-4 col-md-4 col-lg-4" align="center">
                    <p class="middle-text2"><span class="big-red-text">1元</span>/4小时</p>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-4" align="center">
                    <p class="middle-text2"><span class="big-red-text">2元</span>/8小时</p>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-4" align="center">
                    <p class="middle-text2"><span class="big-red-text">3元</span>/12小时</p>
                </div>
            </div>
        </div>

    </div>
    <div class = "choose-tips"  style="height: 5.3125rem;padding-left: 1.5rem;padding-right: 1.5rem;background: #FFFFFF;margin-top: 1rem;">
        <img class="tips-img pull-left" src="../images/p17_03.png" />
        <div style="height: 5.3125rem;padding-top: 0.5rem;padding-bottom: 0.5rem;">
            <div class="pull-left" style="width: 1px;height: 4.3125rem;margin-left: 1rem;"><div class="line-vertical"></div></div>
            <div style="margin-left: 4rem;">
                <p class="mini-text2" style="margin-bottom: 0.3rem;">
                    若页面显示插座可使用，但他人车辆仍占着车位，可将其插头拔下并移开车辆。
                </p>
                <p class="mini-text2" style="margin-top: 0;">
                    注意，不要拔下他人显示为“充电中”的插头。
                </p>
            </div>
        </div>

    </div>
</section>

<section class="body2" style="display: none;">
    <div class="container1">
        <img class="img-faile" src="../images/p16_1_01.png" />

    </div>
    <div class="faile-text">获取联网设备状态</div>
</section>

<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
<script src="../js/jquery.js"></script>
<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
<script src="../js/bootstrap.min.js"></script>
</body>

</html>