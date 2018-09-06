@extends('layouts.default')

@section('title', '经销商管理')
@section('system', '运营商管理系统')
@section('content')
<section class="header">
    @component('layouts._dealerheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
    <div class="swich-container" align="center">
        <div class="swich-bar1">
            <div class="col-xs-6 col-md-6 col-lg-6 text-45-white swich-text-container" align="center">
                添加经销商
            </div>
            <div class="col-xs-6 col-md-6 col-lg-6 text-45-b3 swich-text-container" align="center">
                查询经销商
            </div>
        </div>
    </div>
</section>
<section class="body1">
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">姓名</span>
            <input class="borad-text-left" style=" border: 0;width:16rem ;margin-left: 3.9rem;" name="identifying-code" placeholder="请输入经销商姓名" oninput="if(value.length>6)value=value.slice(0,6)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">身份证号</span>
            <input class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="若含有字母请大写" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">所在区域</span>
            <input class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="点击选择经销商所在区域" oninput="if(value.length>11)value=value.slice(0,11)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">对方账号</span>
            <input class="my-input5 borad-text-left" type="number" name="identifying-code" placeholder="对方个人中心11位数字" oninput="if(value.length>11)value=value.slice(0,11)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">账户类别</span>
            <span class="text-40-white dealer-swich-seclect" style="margin-left: 1.15rem;">普通经销商</span>
            <span class="text-40-b3 dealer-swich" style="margin-left: 2rem;">超级经销商</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">抽成比例</span>
            <input class="my-input5 borad-text-left" type="number" name="identifying-code" placeholder="如5%，则输入0.05" oninput="if(value.length>6)value=value.slice(0,6)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">备注信息</span>
            <input class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="输入备注信息，非必填项" oninput="if(value.length>15)value=value.slice(0,15)">
        </li>
        <li class="line"></li>
    </ul>
    <div class="text-45-b3 tip-container" >
        提示：抽成比例是针对流水总额的抽成
    </div>

    <div align="center" style="margin-top:2rem;">
        <a class="button-style-blue">确定</a>
    </div>
</section>
<section class="body2-step1">
    <ul class="board1">
        <li class="li-tips borad-text-left">
            输入以下任意一项进行查询
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">姓名</span>
            <input class="borad-text-left" type="text" style=" border: 0;width:16rem ;margin-left: 3.9rem;" name="dealer-name" placeholder="请输入经销商姓名" oninput="if(value.length>6)value=value.slice(0,6)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机号码</span>
            <input class="my-input5 borad-text-left" type="number" name="identifying-code" placeholder="请输入经销商手机号 " oninput="if(value.length>11)value=value.slice(0,11)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">对方账号</span>
            <input class="my-input5 borad-text-left" type="number" name="identifying-code" placeholder="对方个人中心11位数字 " oninput="if(value.length>11)value=value.slice(0,11)">
        </li>
    </ul>
    <div class="text-45-b3 tip-container" >
        注：只能查询自己创建的经销商账户。
    </div>

    <div align="center" style="margin-top:2rem; width: 100%;">
        <a class="button-style-blue">查询</a>
    </div>
    <div align="center" style="margin-top:1rem; width: 100%;">
        <a class="button-style-red">查看所有经销商</a>
    </div>
</section>

<section class="body2-step2">
    <ul style="padding: 0;background: #FFFFFF; margin-top: 1.4375rem;">
        <li style="position: relative;height: 6.25rem;">
            <span class="borad-text-left" style="position: absolute;bottom: 1.25rem;left: 1.75rem;">查询结果列表</span>
            <span class="mini-text-b3" style="position: absolute;bottom: 1.25rem;right: 1.75rem">（点击该经销商可进行编辑）</span>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1rem;">
                <span class="pull-left text-36">周杰伦</span>

            </div>
            <div class="revenus-item-row" style="top:2.5rem;">
                <span class="pull-left mini-text">18081884874</span>
                <span class="pull-right mini-text">四川省成都市锦江区</span>
            </div>
            <div class="revenus-item-row" style="top:4rem;">
                <span class="pull-left mini-text">510922199111055612</span>
                <span class="pull-right mini-text-red">冻结</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1rem;">
                <span class="pull-left text-36">王五</span>

            </div>
            <div class="revenus-item-row" style="top:2.5rem;">
                <span class="pull-left mini-text">13808254743</span>
                <span class="pull-right mini-text">四川省成都市锦江区</span>
            </div>
            <div class="revenus-item-row" style="top:4rem;">
                <span class="pull-left mini-text">510922199005232586</span>
                <span class="pull-right mini-text-red">冻结</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
        <li class="revenus-item">
            <div class="revenus-item-row" style="top: 1rem;">
                <span class="pull-left text-36">张三</span>

            </div>
            <div class="revenus-item-row" style="top:2.5rem;">
                <span class="pull-left mini-text">13808257471</span>
                <span class="pull-right mini-text">四川省成都市锦江区</span>
            </div>
            <div class="revenus-item-row" style="top:4rem;">
                <span class="pull-left mini-text">510922199510255678</span>
                <span class="pull-right mini-text">正常</span>
            </div>
            <div class="item-line">
                <div class="line-dark"></div>
            </div>
        </li>
    </ul>
    <div align="center" style="margin-top:3rem; width: 100%;">
        <a class="button-style-blue">加载更多</a>
    </div>
</section>
@endsection