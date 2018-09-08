@extends('layouts.default')

@section('title', '电站管理')
@section('system', '运营商管理系统')
@section('content')


<section class="header">
    @component('layouts._dealerheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
</section>
<section class="body">
    <ul style="padding-left: 0rem;background: #FFFFFF;">
        <li class="li-tips borad-text-left">
            电站信息
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站编号</span>
            <span class="my-input6 borad-text-right">11835694572</span>
            <!--<input class="my-input6 borad-text-left" type="number" name="identifying-code" placeholder="输入11位卡号查询" oninput="if(value.length>11)value=value.slice(0,11)">-->
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机号码</span>
            <span class="my-input6 borad-text-right">18081884784</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">激活人员</span>
            <span class="my-input6 borad-text-right">刘三浪</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站区域</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">街道名称</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">具体位置</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电价成本</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">充电计费</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">激活时间</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">联网状态</span>
            <span class="text-45-red" style="margin-left: 1.3rem;">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站状态</span>
            <span class="text-45-red" style="margin-left: 1.3rem;">-</span>
            <span class="text-45-blue pull-right">-</span>
        </li>
    </ul>
</section>
<section class="footer">
    <div align="center" style="margin-top:1rem; width: 100%;">
        <a class="button-style-red">返回电站管理</a>
    </div>

    <div align="center" style="margin-top:1rem; width: 100%;">
        <a class="button-style-green">修改信息</a>
    </div>

</section>
@endsection