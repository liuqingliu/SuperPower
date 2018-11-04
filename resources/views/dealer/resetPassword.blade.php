@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/resetPassword.js?1.1')}}"></script>
@endsection
@section('title', '重置提现密码')
@section('system', '运营商管理系统')
@section('content')

<section class="header">
   @component('layouts._dealerheader',['type'=>$type])
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
</section>
<section class="body">
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">新密码</span>
            <input class="my-input2 borad-text-left" type="password" id="password1" placeholder="输入新密码" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">确认密码</span>
            <input class="my-input1 borad-text-left" type="password" id="password2" placeholder="再次确认新密码" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
    </ul>
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">身份证号</span>
            <input class="my-input5 borad-text-left" type="text" id="idNum" placeholder="输入身份证号码以验证身份" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">验证码</span>
            <input id="imageVcode" class="my-input2 borad-text-left" type="text"  placeholder="输入右侧验证码" oninput="if(value.length>4)value=value.slice(0,4)">
            <img id="identifying-img" class="identifying-img pull-right img-rounded" onclick="changeVcode()">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机验证码</span>
            <input class="my-input7 borad-text-left" type="number" id="verifyCode" placeholder="请输验证码" oninput="if(value.length>6)value=value.slice(0,6)">
            <input id="getPhoneVcode" type="button" onclick="getVcodewihtoutPhone()"
                   class="text-45-red pull-right vcode-button" value="获取">
        </li>
    </ul>
</section>
<section class="footer">
    <div class="text-45-b3 tip-container" >
        若提示身份证号错误，请检查大小写。仍不能解决请联系您的账号创建者。
    </div>
    <div align="center" style="margin-top:1.5rem; width: 100%;">
        <a class="button-style-red" onclick="doReset()">确定</a>
    </div>
    <div align="center" style="margin-top: 1.5rem;display: none" >
        <a href="#" onclick="" class="mini-text">更换账户绑定手机号</a>
    </div>
</section>
@endsection