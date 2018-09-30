@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/psManage.js?v=2.0')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery.scs.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/CNAddrArr.min.js')}}"></script>
@endsection
@section('title', '电站管理')
@section('system', '运营商管理系统')
@section('dialogMsg',"电站激活成功")
@section('buttonText',"知道了")
@section('content')
    @component('layouts._normaldialog')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent

<section class="header">
    @component('layouts._dealerheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
    <div class="swich-container" align="center">
        <div class="swich-bar2">
            <div class="col-xs-6 col-md-6 col-lg-6 text-45-white swich-text-container" align="center" id="activePS" onclick="activePS()">
                电站激活
            </div>
            <div class="col-xs-6 col-md-6 col-lg-6 text-45-b3 swich-text-container" align="center" id="queryPS" onclick="queryPS()">
                电站查询
            </div>
        </div>
    </div>
</section>
<section class="body1-step1" >
    <ul class="board1">
        <li class="li-tips borad-text-left">
            1、填写电站基本信息
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站编号</span>
            <input id="input1" class="my-input5 borad-text-left" type="number" name="identifying-code" placeholder="请输入电站机箱内15位编码" oninput="if(value.length>15)value=value.slice(0,15)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站区域</span>
            <input id="input2" class="my-input5 borad-text-left" data-key="23-385-4224" type="text" readonly name="addr" placeholder="点击选择电站安装区域 ">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">街道名称</span>
            <input id="input3" class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="输入街道名，如成宏路23号 " oninput="if(value.length>15)value=value.slice(0,15)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">具体位置</span>
            <input id="input4" class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="输入小区名，如万科海岸3号机 " oninput="if(value.length>15)value=value.slice(0,15)">
        </li>
    </ul>
    <div class="text-45-b3 tip-container">
        为方便查找，上述信息将展示给所有用户，请准确填写
    </div>

    <div align="center" style="margin-top:2rem;">
        <button id="activePS1" class="button-style-green">下一步</button>
    </div>
</section>
<section class="body1-step2" style="display: none">
    <ul class="board1">
        <li class="li-tips borad-text-left">
            2、填写电站计费方式
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电价成本</span>
            <input id="input5" class="my-input1 borad-text-left" type="number" name="identifying-code" placeholder="输入电费成本" oninput="if(value.length>4)value=value.slice(0,4)">
            <span class="borad-text-right pull-right">单位：元/度</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">充电计费</span>
            <input id="input6" class="my-input1 borad-text-left" type="number" name="identifying-code" placeholder="1元可充电时长 " oninput="if(value.length>4)value=value.slice(0,4)">
            <span class="borad-text-right pull-right">单位：小時/元</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">验证码</span>
            <input id="imageVcode" class="my-input2 borad-text-left" type="text" name="identifying-code" placeholder="输入右侧验证码" oninput="if(value.length>4)value=value.slice(0,4)">
            <img id="identifying-img" class="identifying-img pull-right img-rounded" onclick="changeVcode()">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机验证码</span>
            <input id="input7" class="my-input7 borad-text-left" type="number" name="identifying-code" placeholder="输入收到的验证码" oninput="if(value.length>4)value=value.slice(0,4)">
            <input id="getPhoneVcode" type="button" class="getvcode-green pull-right vcode-button" value="获取">
        </li>
    </ul>
    <div class="text-45-b3 tip-container" >
        1.普通电瓶车充电功率约为150-300瓦，充满约需6小时。
    </div>
    <div class="text-45-b3 tip-container" >
        2.考虑车辆的电池电量残存、电池容量损耗等因素，72V/20Ah的车平均消耗1度电左右。
    </div>

    <div align="center" style="margin-top:3rem;">
        <button id="activeFinish" class="button-style-green" onclick="addPowerStation()">完成</button>
    </div>
    <div align="center" style="margin-top:1rem;">
        <button id="activePrevious" class="button-style-green">上一步</button>
    </div>
</section>

<section class="body2-step1" style="display: none">
    <div style="text-align: center;margin-top: 3rem;">
        <img src="../images/p16_1_01.png" style="margin: 0 auto;width:  7.8125rem;height: 9.875rem;" />
        <div align="center">
            <span class="borad-text-right" style="margin-top: 1rem;">您还没有任何电站</span>
        </div>
        <div align="center" style="margin-top:2rem; width: 100%;">
            <a class="button-style-green">去激活电站</a>
        </div>
    </div>

</section>

<section class="body2-step2" style="display: none">
    <ul class="board1">
        <li class="li-tips borad-text-left">
            输入以下详情进行查询
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站编号</span>
            <input id="input8" class="my-input5 borad-text-left" type="number" name="identifying-code" placeholder="输入电站编号" oninput="if(value.length>15)value=value.slice(0,15)">
        </li>
        {{--<li class="line"></li>--}}
        {{--<li class="borad-heigh">--}}
            {{--<span class="borad-text-left">手机号码</span>--}}
            {{--<input id="input9" class="my-input5 borad-text-left" type="number" name="identifying-code" placeholder="输入激活人员手机号 " oninput="if(value.length>11)value=value.slice(0,11)">--}}
        {{--</li>--}}
        {{--<li class="line"></li>--}}
        {{--<li class="borad-heigh">--}}
            {{--<span class="borad-text-left">激活人员</span>--}}
            {{--<input id="input10" class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="输入激活人员姓名 " oninput="if(value.length>6)value=value.slice(0,6)">--}}
        {{--</li>--}}
    </ul>
    <div class="text-45-b3 tip-container" >
        提示：只能查询自己或下级经销商激活过的电站。
    </div>

    <div align="center" style="margin-top:2rem; width: 100%;">
        <button class="button-style-green" onclick="querySingleEquipment()">继续查询</button>
    </div>
    <div align="center" style="margin-top:1rem; width: 100%;">
        <button class="button-style-red" onclick="queryAllEquipment()">查看所有电站</button>
    </div>
</section>

<section class="body2-step3" style="display: none">
    <ul id="queryResult" style="padding: 0;background: #FFFFFF; margin-top: 1.4375rem;">
        <li style="position: relative;height: 6.25rem;">
            <span class="borad-text-left" style="position: absolute;bottom: 1.25rem;left: 1.75rem;">查询结果列表</span>
            <span class="mini-text-b3" style="position: absolute;bottom: 1.25rem;left: 11rem;">（点击该电站可进行编辑）</span>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
        <li class="revenus-item" style="display: none">
            <div class="revenus-item-row" style="top: 1rem;">
                <span class="pull-left text-36">锦江城市花园2号机</span>

            </div>
            <div class="revenus-item-row" style="top:2.5rem;">
                <span class="pull-left mini-text">23479654532</span>
                <span class="pull-right mini-text">四川省成都市锦江区</span>
            </div>
            <div class="revenus-item-row" style="top:4rem;">
                <span class="pull-left mini-text">周杰伦</span>
                <span class="pull-right mini-text-red">离线</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
    </ul>
    <div align="center" style="margin-top:3rem; width: 100%;">
        <a class="button-style-green" onclick="backToQuery()">返回查询</a>
    </div>
    <div align="center" style="margin-top:3rem; width: 100%;display: none">
        <a class="button-style-green">加载更多</a>
    </div>
</section>


@endsection