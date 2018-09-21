@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/choosesocket.js')}}"></script>
@endsection
@section('title', '选择插座')
@section('system', '个人中心')
@section('content')

    <section class="header">
        @component('layouts._userheader')
            <strong>Whoops!</strong> Something went wrong!
        @endcomponent
    </section>
    {{--@if(($device_info->ebquipment_status==1)&&($device_info->net_status==0))--}}
    <section class="body1">
        <div class="borad-text-left borad-heigh location-title">{{$device_info->address}}
            <a href="#" onclick="showHideCode()"><img id="choosesocke_updownimg" src="{{URL::asset('images/p17_01.png')}}" class="up-down"/></a>
        </div>
        <div class="location-detail" id="detail" style="display: none">
            <div class="detail1">
                <img src="{{URL::asset('images/p18_02.png')}}" class="detail-img"/>
                <span class="mini-text">{{$device_info->city}}{{$device_info->area}}{{$device_info->street}}{{$device_info->address}}</span>
            </div>
            <div class="detail1" style="margin-top: 0.5rem;">
                <img src="{{URL::asset('images/p18_03.png')}}" class="detail-img"/>
                <span class="mini-text">设备编号{{$device_info->equipment_id}}</span>
            </div>
            <div class="detail1" style="margin-top: 0.5rem;">
                <img src="{{URL::asset('images/p18_04.png')}}" class="detail-img"/>
                <span class="mini-text">故障报修电话{{$device_info->manager_phone}}</span>
                <img src="{{URL::asset('images/p18_05.png')}}" class="detail-img pull-right"/>
            </div>
        </div>
        <div class="div-big">
            <div style="height: 2.4rem;position: relative">
                <span class="middle-text pull-left" style="position: absolute;left: 1.75rem;bottom: 0;">充电口状态</span>
                <a href="#" class="middle-text pull-right" style="position: absolute;right: 1.75rem;bottom: 0;">使用方法</a>
            </div>
            <div style="height: 13.0625rem;">

                <ul class="choose-block " style="padding-left: 0.599rem; padding-right:0.599rem;height: 13.0625rem;">
                   @foreach($portInfo as $key => $value)
                    <li data-toggle="modal" class="col-xs-1-5 col-md-1-5 col-lg-1-5 socket-block">
                        <div @if($value==1) class="inner-block-no" @elseif($value==0) class="inner-block-yes" @endif>
                            <p class="number-red-text block-text1">{{$key}}号</p>
                            @if($value==1)
                            <p class="mini-text-red block-text2">充电中</p>
                            @elseif($value==0)
                                <p class="mini-text-red block-text2">可使用</p>
                            @endif
                        </div>
                    </li>
                       @endforeach
                </ul>
            </div>
        </div>
        <div style="height: 12rem;background: #FFFFFF;">
            <p class="count-way middle-text2">
                <span class="middle-text">计费方式</span>
                （按时间计费精确到分钟，充1分钟只收一分钟的费用，明明白白消费，不花冤枉钱）
            </p>
            <div style="padding-left: 1.75rem;padding-right: 1.75rem;">
                <div class="line"></div>
            </div>
            <div style="height: 7.7rem;">
                <p class="count-way2 middle-text2">
                    <span class="middle-text">标准功率资费</span>
                    （指300瓦充电功率以下，绝大多数车辆适用）
                </p>
                <div style="height: 3rem;">
                    <div class="col-xs-4 col-md-4 col-lg-4" align="center">
                        <p class="middle-text2"><span class="big-red-text">{{$device_info->charging_unit_second}}元</span>/4小时</p>
                    </div>
                    <div class="col-xs-4 col-md-4 col-lg-4" align="center">
                        <p class="middle-text2"><span class="big-red-text">{{($device_info->charging_unit_second)*2}}元</span>/8小时</p>
                    </div>
                    <div class="col-xs-4 col-md-4 col-lg-4" align="center">
                        <p class="middle-text2"><span class="big-red-text">{{($device_info->charging_unit_second)*3}}元</span>/12小时</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="choose-tips"
             style="height: 5.3125rem;padding-left: 1.5rem;padding-right: 1.5rem;background: #FFFFFF;margin-top: 1rem;">
            <img class="tips-img pull-left" src="{{URL::asset('images/p17_03.png')}}"/>
            <div style="height: 5.3125rem;padding-top: 0.5rem;padding-bottom: 0.5rem;">
                <div class="pull-left" style="width: 1px;height: 4.3125rem;margin-left: 1rem;">
                    <div class="line-vertical"></div>
                </div>
                <div style="margin-left: 4rem;">
                    <p class="mini-text2" style="margin-bottom: 0.3rem;">
                        若页面显示插座可使用，但他人车辆仍占着车位，可将其插头拔下并移开车辆。
                    </p>
                    <p class="mini-text2" style="margin-top: 0;">
                        注意，不要拔下他人显示为“充电中”的插头。
                    </p>
                </div>
            </div>
        </div>
        {{--dialog1--}}
        <div class="modal" id="chooseDialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div style="height:30.625rem;width: 100%; position: absolute;bottom: 0;background: #ffffff">
                <div style="height:6.5rem;width: 100%;padding-top: 3rem" >
                   <img data-dismiss="modal" style="width: 1.875rem;height: 1.875rem;position: absolute;top: 1.5rem;left: 1.5rem;" src="{{URL::asset('images/p19_01.png')}}">
                   <div class="borad-text-left" style="text-align: center;">
                       您已选择<span class="text-45-red">2号</span>插座
                   </div>
                </div>
                <div class="line-dark"></div>
                <section class="part1">
                    <P class="borad-text-left" style="text-align: center;margin-top: 1rem;">请确认充电器与插座及车辆已插好</P>
                    <div align="center">
                        <img style="margin: auto;height:8.5rem;width:25.375rem;" src="{{URL::asset('images/p19_02.png')}}" >
                    </div>
                    <div>
                        <span class="borad-text-left" style="position: absolute;left: 3.5rem">插座</span>
                        <span class="borad-text-left" style="position: absolute;left: 9.5rem">充电器</span>
                        <span class="borad-text-left" style="position: absolute;left: 20rem">电动车</span>
                    </div>
                    <div class="line-dark" style="margin-top: 3rem"></div>
                    <button class="button-style" style="margin-left: 10%;margin-top: 2rem;">插好了</button>
                </section>
                <section class="part2">

                </section>

            </div>
        </div>


    </section>
{{--@else--}}
    <section class="body2">
        <div class="container1">
            <img class="img-faile" src="{{URL::asset('images/p16_1_01.png')}}"/>

        </div>
        <div class="faile-text">获取联网设备状态</div>
    </section>
{{--@endif--}}
@endsection