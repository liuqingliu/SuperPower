
@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/takeoutMoney.js?1.4')}}"></script>
    @if(!$is_bind_phone)
        <script type="text/javascript">
            $(document).ready(function () {
                $('#bindphonedialog').modal({backdrop:'static',keyboard:false});
                changeVcode();
            });
        </script>
    @elseif(!$is_set_password)
        <script type="text/javascript">
            $(document).ready(function () {
                $('#passworddialog').modal({backdrop:'static',keyboard:false});
            });
        </script>
    @elseif(!$is_bind_bank)
        <script type="text/javascript">
            {{--alert({{$is_bind_phone}}{{$is_set_password}}{{$is_bind_bank}})--}}
            $(document).ready(function () {
                $('#bindbankdialog').modal({backdrop:'static',keyboard:false});
            });
        </script>
    @else
        <script type="text/javascript">
            $(document).ready(function () {
                changeVcode();
            });
        </script>
    @endif
@endsection

@section('dialogMsg', '已提交。根据银行处理时间不同，资金约在1-2个工作日内转入您绑定的银行卡。')
@section('buttonText', '好的')
@section('title', '我要提现')
@section('system', '运营商管理系统')
@section('content')

<section class="header">
    <input id="isbindphone" style="display: none" value="{{$is_bind_phone}}">
    <input id="isbindbank" style="display: none" value="{{$is_bind_bank}}">
    <input id="issetpassword" style="display: none" value="{{$is_set_password}}">
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
            <input class="my-input1 borad-text-left" type="number" id="money" placeholder="请输提现金额" oninput="if(value.length>9)value=value.slice(0,9)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">提现密码</span>
            <input class="my-input1 borad-text-left" type="password" id="password" placeholder="请输提现密码" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
        <li class="line"></li>
        @if($is_bind_phone)
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
        @endif
    </ul>
</section>
<section class="footer">
    <div align="center" style="margin-top:3rem;">
        <a class="button-style2" onclick="doCarry()">确定</a>
    </div>
    <div align="center" style="margin-top:2.5rem;">
        <a href="{{route("dealer_resetPassword")}}" class="mini-text">我忘了提现密码</a>
    </div>
    <div align="center" style="display: none">
        <a href="#" onclick="" class="mini-text">更换账户绑定手机号</a>
    </div>
</section>
{{--bindphonedialog--}}
@if(!$is_bind_phone)
<div class="modal" id="bindphonedialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div style="min-height: 19rem;" class="center-dialog">
        <div style="min-height:11rem;width: 100%;margin-bottom: 3.5rem;">
            <p class="borad-text-left" style="margin:1.5rem;">该账户未绑定手机号，请先绑定手机号再进行提现。</p>
            <ul style=" padding-left: 0rem; margin-bottom: 5rem;">
                <li class="dialog-li">
                    <input id="imageVcode" class="input-dialog borad-text-left" type="text" placeholder="输入右侧验证码"
                           oninput="if(value.length>4)value=value.slice(0,4)">
                    <img id="identifying-img" class="identifying-img-dialog pull-right img-rounded"
                         onclick="changeVcode()">
                </li>
                <li class="line"></li>
                <li class="dialog-li">
                    <input id="phonenum" class="input-dialog borad-text-left" type="number" placeholder="请输您的手机号"
                           oninput="if(value.length>11)value=value.slice(0,11)">
                    <input id="getPhoneVcode" type="button" onclick="getVcodewihtPhone()"
                           class="text-45-red pull-right vcode-button" value="获取">
                </li>
                <li class="line"></li>
                <li class="dialog-li">
                    <input id="phoneVcode" class="input-dialog borad-text-left" type="number" name="identifying-code"
                           placeholder="输入手机验证码" oninput="if(value.length>6)value=value.slice(0,6)">
                </li>
                <li class="line"></li>

            </ul>
            <div style="width: 100%;height: 1px;background:url('/images/p16_06.png');position: absolute;bottom: 3.535rem;"></div>
            <div style="height:3.4375rem;width: 100%; line-height: 3.4375rem;position:absolute;bottom: 0;">
                <div onclick="javascript:history.back(-1);" data-dismiss="modal" class="pull-left"
                     style="height:3.4375rem;width: 50%;text-align: center;color: #777777;font-size: 1.65rem;">取消
                    <div class="line-vertical pull-right" style="height: 3.4375rem;width: 1px;"></div>
                </div>
                <div class="pull-right" onclick="bindPhone()"
                     style="height:3.4375rem;width: 50%;text-align: center;color: #F15A24;font-size: 1.65rem;">确定
                </div>
            </div>
        </div>
    </div>
</div>
@endif
{{--passworddialog--}}
<div class="modal" id="passworddialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div style="min-height: 19rem;" class="center-dialog">
        <div style="min-height:11rem;width: 100%;margin-bottom: 3.5rem;">
            <p class="borad-text-left" style="margin:1.5rem;">为保障您的资金安全，请先设置提现密码。必须包含大小写字母及数字。</p>
            <ul style="padding-left:0rem;margin-bottom:5rem;">
                <li class="dialog-li">
                    <input id="password1" class="input-dialog2 borad-text-left" type="password" placeholder="请输入至少8位密码"
                           oninput="if(value.length>18)value=value.slice(0,18)">
                </li>
                <li class="line"></li>
                <li class="dialog-li">
                    <input id="password2" class="input-dialog2 borad-text-left" type="password" placeholder="请再次输入密码"
                           oninput="if(value.length>18)value=value.slice(0,18)">
                </li>
                <li class="line"></li>
            </ul>
            <div style="width: 100%;height: 1px;background:url('/images/p16_06.png');position: absolute;bottom: 3.535rem;"></div>
            <div style="height:3.4375rem;width: 100%; line-height: 3.4375rem;position:absolute;bottom: 0;">
                <div onclick="javascript:history.back(-1);" data-dismiss="modal" class="pull-left"
                     style="height:3.4375rem;width: 50%;text-align: center;color: #777777;font-size: 1.65rem;">取消
                    <div class="line-vertical pull-right" style="height: 3.4375rem;width: 1px;"></div>
                </div>
                <div class="pull-right" onclick="setPassword()"
                     style="height:3.4375rem;width: 50%;text-align: center;color: #F15A24;font-size: 1.65rem;">确定
                </div>
            </div>
        </div>
    </div>
</div>
{{--bindbankdialog--}}
<div class="modal" id="bindbankdialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div style="min-height: 7rem;" class="center-dialog">
        <div style="min-height:7rem;width: 100%;margin-bottom: 3.5rem;">
            <p class="borad-text-left" style="margin:1.5rem;">需先绑定银行卡才能进行提现操作。提现成功后，资金直接转入您绑定的银行卡。</p>
            <div style="width: 100%;height: 1px;background:url('/images/p16_06.png');position: absolute;bottom: 3.535rem;"></div>
            <div style="height:3.4375rem;width: 100%; line-height: 3.4375rem;position:absolute;bottom: 0;">
                <div onclick="javascript:history.back(-1);" data-dismiss="modal" class="pull-left"
                     style="height:3.4375rem;width: 50%;text-align: center;color: #777777;font-size: 1.65rem;">取消
                    <div class="line-vertical pull-right" style="height: 3.4375rem;width: 1px;"></div>
                </div>
                <a class="pull-right" href="{{route('bindBank')}}"
                   style="height:3.4375rem;width: 50%;text-align: center;color: #F15A24;font-size: 1.65rem;">现在绑定</a>
            </div>
        </div>
    </div>
</div>
@component('layouts._normaldialog')
    <strong>Whoops!</strong> Something went wrong!
@endcomponent
@endsection