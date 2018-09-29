
@extends('layouts.default')
{{--is_set_password,is_bind_phone,is_bind_bank--}}
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
                <p class="dealer-money-text" style="margin-bottom: 0.2rem;">{{$income_withdraw}}</p>
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
{{--dialog--}}
<div class="modal" id="cardNumInput" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div style="min-height: 14.5rem;" class="center-dialog">
        <div style="min-height:11rem;width: 100%;padding: 1.5rem;margin-bottom: 3.5rem;" >
            <p class="borad-text-left">该账户微绑定手机号，请先绑定手机号再进行提现。</p>
            <input id="dialogInput" style="height:3.4625rem;border: 0;outline:none;" class="borad-text-left" data-toggle="modal" data-target="#newUserDialog" type="number" placeholder="请输入电卡卡号" oninput="if(value.length>11)value=value.slice(0,11)">
            <div><div class="line-dark"></div></div>

        </div>
        <div style="width: 100%;height: 1px;background:url('/images/p16_06.png');position: absolute;bottom: 3.535rem;"></div>
        <div style="height:3.4375rem;width: 100%; line-height: 3.4375rem;position:absolute;bottom: 0;">
            <div data-dismiss="modal" class="pull-left" style="height:3.4375rem;width: 50%;text-align: center;color: #777777;font-size: 1.65rem;">取消
                <div class="line-vertical pull-right" style="height: 3.4375rem;width: 1px;"></div>
            </div>
            <div class="pull-right" onclick="Values()" style="height:3.4375rem;width: 50%;text-align: center;color: #F15A24;font-size: 1.65rem;">确定</div>
        </div>
    </div>
</div>
@endsection