@extends('layouts.default')

@section('title', '绑定银行卡')
@section('system', '运营商管理系统')
@section('content')

    <section class="header">
        @component('layouts._dealerheader')
            <strong>Whoops!</strong> Something went wrong!
        @endcomponent
    </section>
    <section class="body1">
        <div class="tip-container" style="margin-top: 1rem;" >
            <p class="text-40-b3" style="margin-bottom:0;" >以下信息请务必准确填写，若信息错误可能导致提现失败或将您的资金提现至他人的银行卡。</p>
            <p class="text-40-b3" style="margin-bottom:1rem;">提现成功后，资金将直接转入绑定的银行卡。</p>
        </div>
        <ul class="board1">
            <li class="borad-heigh">
                <span class="borad-text-left">卡号</span>
                <input class="my-input8 borad-text-left" type="number"  placeholder="输入银行卡号" oninput="if(value.length>18)value=value.slice(0,18)">
            </li>
            <li class="line"></li>
            <li class="borad-heigh">
                <span class="borad-text-left">开户名</span>
                <input class="my-input2 borad-text-left" type="text" placeholder="输入卡户人姓名" oninput="if(value.length>10)value=value.slice(0,10)">
            </li>
            <li class="borad-heigh">
                <span class="borad-text-left">开户行</span>
                <input class="my-input2 borad-text-left" type="text" placeholder="输入开户银行" oninput="if(value.length>10)value=value.slice(0,10)">
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
                <input class="my-input7 borad-text-left" type="password" name="identifying-code" placeholder="输入收到的验证码" oninput="if(value.length>18)value=value.slice(0,18)">
                <span class="text-45-red pull-right">获取</span>
            </li>
        </ul>
        <div align="center" style="margin-top:1.5rem; width: 100%;">
            <a class="button-style-red" onclick="confirmInfo()">确定</a>
        </div>
        <div align="center" style="margin-top: 1.5rem;display: none" >
            <a href="#" onclick="" class="mini-text">更换账户绑定手机号</a>
        </div>
        {{--confirmDialog--}}
        <div class="modal" id="confirmDialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div style="min-height: 12.5rem;" class="center-dialog">
                <div style="min-height:9rem;width: 100%;padding: 1.5rem;margin-bottom: 3.5rem;" >
                    <p class="borad-text-left" id="cardNUm"></p>
                    <p class="borad-text-left" id="userName"></p>
                    <p class="borad-text-left" style="margin-bottom: 0;" id="bankName"></p>
                </div>
                <div style="width: 100%;height: 1px;background:url('/images/p16_06.png');position: absolute;bottom: 3.535rem;"></div>
                <div style="height:3.4375rem;width: 100%; line-height: 3.4375rem;position:absolute;bottom: 0;">
                    <div data-dismiss="modal" class="pull-left" style="height:3.4375rem;width: 50%;text-align: center;color: #777777;font-size: 1.65rem;">取消
                        <div class="line-vertical pull-right" style="height: 3.4375rem;width: 1px;"></div>
                    </div>
                    <div class="pull-right" onclick="confirmedRecharge()" style="height:3.4375rem;width: 50%;text-align: center;color: #F15A24;font-size: 1.65rem;">确定</div>
                </div>
            </div>
        </div>
    </section>


    <section class="body2">
        <div class="tip-container" style="margin-top: 1rem;" >
            <p class="text-40-b3" style="margin-bottom: 1rem;">您已绑定的银行卡</p>
        </div>
        <ul class="board1">
            <li class="borad-heigh">
                <span class="borad-text-left">卡号</span>
                <input class="my-input2 borad-text-left" type="number" readonly placeholder="输入银行卡号">
            </li>
            <li class="line"></li>
            <li class="borad-heigh">
                <span class="borad-text-left">开户名</span>
                <input class="my-input1 borad-text-left" type="text" readonly placeholder="输入卡户人姓名" >
            </li>
            <li class="borad-heigh">
                <span class="borad-text-left">开户行</span>
                <input class="my-input5 borad-text-left" type="text" readonly placeholder="输入开户银行">
            </li>
        </ul>
        <div align="center" style="margin-top:1.5rem; width: 100%;">
            <a class="button-style-red">修改</a>
        </div>
        <div align="center" style="margin-top: 1.5rem;display: none" >
            <a href="#" onclick="" class="mini-text">更换账户绑定手机号</a>
        </div>
    </section>
@endsection