@extends('layouts.default')

@section('title', '绑定手机号')

@section('content')
<section class="header">
    @component('layouts._header')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
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
@endsection