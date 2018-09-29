@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/recharge.js')}}"></script>
@endsection
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
                <div class="big-text">1元/{{$unit_hour}}小时</div>
                <!--<span class="big-text">1元/6小时</span>-->
            </div>

        </div>
        <div class="line-dark"></div>
    </section>
    <section class="footer">
        <div id="close_button" class="recharge-container3"  data-toggle="modal" data-target="#confirmDialog">
            <img src="{{URL::asset('images/p16_07.png')}}" class="img-status"/>
        </div>
        <p class="mini-text fooet-des" style="margin-top: 2rem;">正在充电，点击上方按钮可停止充电</p>
        <p class="mini-text fooet-des">充满或到时间后，充电会自动停止</p>
    </section>
    {{--confirmDialog--}}
    <div class="modal" id="confirmDialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div style="min-height: 12.5rem;" class="center-dialog">
            <div style="min-height:9rem;width: 100%;padding: 1.5rem;margin-bottom: 3.5rem;" >
                <p class="borad-text-left" id="cardInfo">确定要停止充电吗？</p>
            </div>
            <div style="width: 100%;height: 1px;background:url('/images/p16_06.png');position: absolute;bottom: 3.535rem;"></div>
            <div style="height:3.4375rem;width: 100%; line-height: 3.4375rem;position:absolute;bottom: 0;">
                <div data-dismiss="modal" class="pull-left" style="height:3.4375rem;width: 50%;text-align: center;color: #777777;font-size: 1.65rem;">点错了
                    <div class="line-vertical pull-right" style="height: 3.4375rem;width: 1px;"></div>
                </div>
                <div class="pull-right" onclick="closesocket()" style="height:3.4375rem;width: 50%;text-align: center;color: #F15A24;font-size: 1.65rem;">确定</div>
            </div>
        </div>
    </div>
@endsection