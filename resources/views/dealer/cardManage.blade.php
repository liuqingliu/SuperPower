@extends('layouts.default')

@section('title', '电卡管理')
@section('system', '运营商管理系统')
@section('content')

<section class="header">
   @component('layouts._dealerheader',['type'=>$type])
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
    <div class="swich-container" align="center">
        <div class="swich-bar1">
            <div class="col-xs-6 col-md-6 col-lg-6 text-45-white swich-text-container" align="center">
                电卡激活
            </div>
            <div class="col-xs-6 col-md-6 col-lg-6 text-45-b3 swich-text-container" align="center">
                电卡查询
            </div>
        </div>
    </div>
</section>
<section class="body1">
<ul class="board1">
    <li class="borad-heigh">
        <span class="borad-text-left">电卡卡号</span>
        <input class="my-input4 borad-text-left" type="number" name="identifying-code" placeholder="点击输入11位卡号" oninput="if(value.length>11)value=value.slice(0,11)">
        <img class="borad-img-right pull-right img-rounded" src="../images/p9_02.png">
    </li>
    <li class="line"></li>
    <li class="borad-heigh">
        <span class="borad-text-left">验证码</span>
        <input class="my-input2 borad-text-left" type="text" name="identifying-code" placeholder="输入右侧验证码" oninput="if(value.length>4)value=value.slice(0,4)">
        <img class="identifying-img pull-right img-rounded" src="../images/pm7_01.png">
    </li>
</ul>
<div align="center" style="margin-top:9rem;">
    <a class="button-style-blue">激活</a>
</div>

</section>

<section class="body2">
    <ul class="board1">
        <li class="li-tips borad-text-left">
            输入卡号进行查询
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电卡卡号</span>
            <input class="my-input5 borad-text-left" type="number" name="identifying-code" placeholder="输入11位卡号查询" oninput="if(value.length>11)value=value.slice(0,11)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">激活人员</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">激活时间</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电卡余额</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电卡状态</span>
            <span class="text-45-red" style="margin-left: 1.3rem;">-</span>
            <span class="text-45-blue pull-right">-</span>
        </li>
    </ul>
    <div class="text-45-b3 tip-container">
        提示：只能查询自己或下级经销商激活的电卡
    </div>

    <div align="center" style="margin-top:3rem;">
        <a class="button-style-blue">继续查询</a>
    </div>
</section>
@endsection