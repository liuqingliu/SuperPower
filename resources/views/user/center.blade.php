@extends('layouts.default')

@section('title', '个人中心')

@section('content')
<section class="header">
    <div class="user-center-header">
        <img class="user-header pull-left img-rounded" src="{{URL::asset($user_info->headimgurl)}}" alt="头像">
        <div class="pull-left header-message">
            <span class="user-name">{{$user_info->nickname}}</span><br>
            <span class="user-account">账号：{{$user_info->user_id}}</span><br>
            @if (empty($user_info->phone))
                <span class="user-account">点击这里绑定手机领取优惠</span><br>
            @else
                <span class="user-account">{{$user_info->phone}}</span>
            @endif
            
        </div>
        <img src="{{URL::asset('images/p1_01.png')}}" class="pull-right img-rounded user-edit" alt="绑定手机号">
    </div>
</section>

<section class="body">
    <ul class="board1">
        <li class="borad-heigh ">
            <a href="{{route("user_order")}}">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_02.png')}}" alt="充值">
            <span class="borad-text-left">账户充值(</span>
            <span class="borad-text-right">余额{{$user_info->user_money}}元</span>
            <span class="borad-text-left">)</span>
            <span class="borad-text-right pull-right">充值优惠
                        <img class="red-dot pull-right" src="{{URL::asset('images/p1_03.png')}}"></span>
            </a>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <a href="{{route("electric_rechargelog")}}">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_04.png')}}" alt="充电记录">
            <span class="borad-text-left">我的充电记录</span>
            </a>
        </li>
    </ul>
    <ul class="board1">
        <li class="borad-heigh">
            <a href="{{route("electric_cardorderpay")}}">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_05.png')}}" alt="充值电卡">
            <span class="borad-text-left">电卡充值</span>
            <span class="borad-text-right pull-right">多充多送
                        <img class="red-dot pull-right" src="{{URL::asset('images/p1_03.png')}}"></span>
            </a>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <a href="{{route("electric_recharge")}}">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_06.png')}}" alt="正在充电">
            <span class="borad-text-left">正在充电</span>
            </a>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <a href="#">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_07.png')}}" alt="附近电站">
            <span class="borad-text-left">附近电站</span>
            </a>
        </li>
    </ul>
    <ul class="board1">
        <li class="borad-heigh">
            <a href="{{route("dealer_moneymanage")}}">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_08.png')}}" alt="运营商管理平台">
            <span class="borad-text-left">运营商管理平台</span>
            </a>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <a href="#">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_09.png')}}" alt="诚邀合伙人加盟">
            <span class="borad-text-left">诚邀合伙人加盟</span>
            <span class="borad-text-right pull-right">合作方式丰富多样
                        <img class="red-dot pull-right" src="{{URL::asset('images/p1_03.png')}}"></span>
            </a>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <a href="{{route("user_about")}}">
            <img class="borad-img pull-left img-rounded" src="{{URL::asset('images/p1_10.png')}}" alt="关于">
            <span class="borad-text-left">关于</span>
            </a>
        </li>
    </ul>
</section>

<section class="footer">
    <nav class="my-nav navbar navbar-default navbar-fixed-bottom " role="navigation">

        <div class="row my-footer">
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="{{route('electric_recharge')}}">
                    <img src="{{URL::asset('images/p1_11_on.png')}}" class="img-responsive center-block bottom-img">
                    <span class="bottom-text text-center center-block">正在充电</span>
                </a>
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="#">
                    <img src="{{URL::asset('images/p1_12_off.png')}}" class="img-responsive center-block bottom-img">
                    <span class="bottom-text text-center center-block">扫码充电</span>
                </a>
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
                <a href="#">
                    <img src="{{URL::asset('images/p1_13_on.png')}}" class="img-responsive center-block bottom-img">
                    <span class="bottom-text text-center center-block">个人中心</span>
                </a>
            </div>
        </div>
    </nav>
</section>

<!-- 如果要使用Bootstrap的js插件，必须先调入jQuery -->
<script src="js/jquery.js"></script>
<!-- 包括所有bootstrap的js插件或者可以根据需要使用的js插件调用　-->
<script src="js/bootstrap.min.js"></script>
</body>

</html>