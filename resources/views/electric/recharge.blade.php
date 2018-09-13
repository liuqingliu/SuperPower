@extends('layouts.default')

@section('title', '正在充电')
@section('system', '个人中心')
@section('content')
    <section class="header">
        @component('layouts._userheader')
            <strong>Whoops!</strong> Something went wrong!
        @endcomponent
    </section>
    <section class="body">
        <p class="mini-text tip">电力正在源源不断的充入你的爱车。</p>
        <div class="bigimg-container">
            <img src="{{URL::asset('images/p16_01.gif')}}" class="recharge-img"/>
        </div>
        <div style="height: 9.5rem;">
            <div class="pull-left recharge-container1">
					<span class="content1">
						<img src="{{URL::asset('images/p16_02.png')}}" class="content-img"/>
                        {{$socket_info}}
					</span>
                <span class="content2">
						<img src="{{URL::asset('images/p16_03.png')}}" class="content-img"/>
                    {{$charge_time}}
					</span>
            </div>
            <div class="recharge-container2 pull-right">
                <div class="pull-left" style="height: 9.5rem; padding-bottom: 1rem;padding-top: 1rem;">
                    <div class="line-vertical"></div>
                </div>
                <div class="big-text" style="margin-top: 2.5rem;">计费标准</div>
                <div class="big-text">{{$charge_price}}</div>
                <!--<span class="big-text">1元/6小时</span>-->
            </div>

        </div>
        <div class="line-dark"></div>
    </section>
    <section class="footer">
        <div class="recharge-container3">
            <img src="{{URL::asset('images/p16_07.png')}}" class="img-status"/>
        </div>
        <p class="mini-text fooet-des" style="margin-top: 2rem;">正在充电，点击上方按钮可停止充电</p>
        <p class="mini-text fooet-des">充满或到时间后，充电会自动停止</p>
    </section>
@endsection