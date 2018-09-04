@extends('layouts.default')

@section('title', '经销商管理')
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
            经销商信息
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">姓名</span>
            <span class="borad-text-right" style=" border: 0;width:16rem ;margin-left: 3.9rem;">-</span>
            <!--<input class="my-input6 borad-text-left" type="number" name="identifying-code" placeholder="输入11位卡号查询" oninput="if(value.length>11)value=value.slice(0,11)">-->
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">身份证号</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机号码</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">所在区域</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">对方账号</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">账户类别</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">抽成比例</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">创建时间</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">账户状态</span>
            <span class="text-45-red" style="margin-left: 1.3rem;">-</span>
            <span class="text-45-blue pull-right">-</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">备注信息</span>
            <span class="my-input6 borad-text-right">-</span>
        </li>
    </ul>
</section>
<section class="footer">
    <div class="text-45-b3 tip-container">
        提示：抽成比例是针对流水总额的抽成
    </div>
    <div align="center" style="margin-top:1rem; width: 100%;">
        <a class="button-style-red">返回经销商管理</a>
    </div>

    <div align="center" style="margin-top:1rem; width: 100%;">
        <a class="button-style-blue">修改信息</a>
    </div>
</section>
@endsection