
@extends('layouts.default')

@section('title', '我要提现')
@section('system', '运营商管理系统')
@section('content')

<section class="header">
    <div style="height:14.6875rem;background: #F15A24;">
        @component('layouts._dealerheader')
            <strong>Whoops!</strong> Something went wrong!
        @endcomponent
        <!-- title -->
        <div style="height:14rem;">
            <div style="height: 7.75rem;padding-top: 1rem;" align="center">
                <p class="dealer-money-text" style="margin-bottom: 0.2rem;">88.23</p>
                <p class="mini-text-white">可提现金额</p>
            </div>
        </div>
    </div>

</section>
<section class="body">
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">提现金额</span>
            <input class="my-input1 borad-text-left" type="number" name="money" placeholder="请输提现金额" oninput="if(value.length>9)value=value.slice(0,9)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">提现密码</span>
            <input class="my-input1 borad-text-left" type="password" name="password" placeholder="请输提现密码" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">验证码</span>
            <input class="my-input2 borad-text-left" type="number" name="identifying-code" placeholder="请输验证码" oninput="if(value.length>6)value=value.slice(0,6)">
            <a href="#" onclick="" class="get-identifying-code pull-right">获取</a>
        </li>
    </ul>
</section>
<section class="footer">
    <div align="center" style="margin-top:3rem;">
        <a class="button-style2">确定</a>
    </div>
    <div align="center" style="margin-top:2.5rem;">
        <a href="#" onclick="" class="mini-text">我忘了提现密码</a>
    </div>
    <div align="center" >
        <a href="#" onclick="" class="mini-text">更换账户绑定手机号</a>
    </div>
</section>
@endsection