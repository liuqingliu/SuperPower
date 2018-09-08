@extends('layouts.default')

@section('title', '我的充电记录')
@section('system', '个人中心')
@section('content')
<section class="header">
    @component('layouts._userheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
</section>
<section class="body">
    <p class="mini-text" style="margin-top: 1.5625rem; margin-left: 3.125rem; ">扫码充电记录</p>

    <ul style="padding: 0;">
        @foreach($charge_list as $recharge)
        <li class="item">
            <img src="{{URL::asset('images/p8_01.png')}}" class="item-img">
            <span class="item-location mini-text">{{$recharge["device_address"]}}</span>
            <span class="rechargelog-item-date mini-text">{{$recharge["date"]}}</span>
            <span class="item-time-interval mini-text">{{$recharge["time_s"]}}~{{$recharge["time_e"]}}</span>
            <span class="item-money text-42-red">{{$recharge["recharge_price"]}}</span>
            <span class="item-time-total text-42-red">{{$recharge["recharge_time"]}}</span>
            <div class="item-line"><div class="line"></div></div>
        </li>
        @endforeach
    </ul>
</section>
<section class="footer" style="display: none">
    <div align="center" style="margin-top:1.5rem;">
        <button class="button-style">查看更多记录</button>
    </div>
</section>
@endsection