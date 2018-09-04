@extends('layouts.default')

@section('title', '重置提现密码')
@section('system', '运营商管理系统')
@section('content')

<section class="header">
    @component('layouts._dealerheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
</section>
<section class="body">
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">新密码</span>
            <input class="my-input2 borad-text-left" type="password" name="identifying-code" placeholder="输入新密码" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">确认密码</span>
            <input class="my-input1 borad-text-left" type="password" name="identifying-code" placeholder="再次确认新密码" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
    </ul>
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">身份证号</span>
            <input class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="输入身份证号码以验证身份" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">验证码</span>
            <input class="my-input2 borad-text-left" type="password" name="identifying-code" placeholder="输入验证码" oninput="if(value.length>18)value=value.slice(0,18)">
            <span class="text-45-red pull-right">获取</span>
        </li>
    </ul>
</section>
<section class="footer">
    <div class="text-45-b3 tip-container" >
        若提示身份证号错误，请检查大小写。仍不能解决请联系您的账号创建者。
    </div>
    <div align="center" style="margin-top:1.5rem; width: 100%;">
        <a class="button-style-red">确定</a>
    </div>
    <div align="center" style="margin-top: 1.5rem;" >
        <a href="#" onclick="" class="mini-text">更换账户绑定手机号</a>
    </div>
</section>
@endsection