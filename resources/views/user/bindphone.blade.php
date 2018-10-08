@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/bindphone.js?1.0')}}"></script>
    {{--@if(($user_info->user_type!=0)&&(!$user_info->is_set_pwd))--}}
        {{--<script type="text/javascript">--}}
            {{--$(document).ready(function () {--}}
                {{--$('#myNormalDialog').modal({backdrop: 'static', keyboard: false});--}}
            {{--});--}}
            {{--$('.dialog-single-button').click(function () {--}}
                {{--window.location.href="/dealer/resetPassword";--}}
            {{--});--}}
        {{--</script>--}}
{{--@section('dialogMsg',"您还没有设置提现密码")--}}
{{--@section('buttonText',"去设置")--}}
{{--@endif--}}
@endsection

@section('title', '绑定手机号')
@section('system', '个人中心')
@section('content')
<section class="header">
    @component('layouts._userheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
</section>
@component('layouts._normaldialog')
    <strong>Whoops!</strong> Something went wrong!
@endcomponent
{{--@if($user_info->user_type==0)--}}
@section('dialogMsg',"您已成功绑定手机号")
@section('buttonText',"知道了")
<section class="body1">
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left">验证码</span>
            <input id="imageVcode" class="my-input2 borad-text-left" type="text"  placeholder="输入右侧验证码" oninput="if(value.length>4)value=value.slice(0,4)">
            <img id="identifying-img" class="identifying-img pull-right img-rounded" onclick="changeVcode()">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机号码</span>
            <input id="phonenum" class="my-input1 borad-text-left" type="number" placeholder="请输您的手机号" oninput="if(value.length>11)value=value.slice(0,11)">
            <input id="getPhoneVcode" type="button" onclick="getPhoneVcode()" class="text-45-red pull-right vcode-button" value="获取">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机验证码</span>
            <input id="phoneVcode" class="my-input7 borad-text-left" type="number" name="identifying-code" placeholder="输入收到的验证码" oninput="if(value.length>6)value=value.slice(0,6)">
        </li>
    </ul>
    <div style="margin-top:0.5rem;">
        <span class="info mini-text">绑定手机号后，可享受更多优惠政策，充电更便宜</span>
    </div>
    <div align="center" style="margin-top:1.5rem;"><button class="button-style" onclick="bindPhone()">提交</button></div>
</section>
{{--@else--}}
<section class="body2" style="display: none">
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
{{--@endif--}}
@endsection