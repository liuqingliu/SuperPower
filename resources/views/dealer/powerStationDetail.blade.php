@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/psDetail.js?v=0.1')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery.scs.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/CNAddrArr.min.js')}}"></script>
@endsection
@section('title', '电站管理')
@section('system', '运营商管理系统')
@section('content')


<section class="header">
    @component('layouts._dealerheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
</section>
<section class="body">
    <ul style="padding-left: 0rem;background: #FFFFFF;">
        <li class="li-tips borad-text-left">
            电站信息
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站编号</span>
            <span class="my-input6 borad-text-right">{{$device_info->equipment_id}}</span>
            <!--<input class="my-input6 borad-text-left" type="number" name="identifying-code" placeholder="输入11位卡号查询" oninput="if(value.length>11)value=value.slice(0,11)">-->
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机号码</span>
            <span class="my-input6 borad-text-right">{{$device_info->phone}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">激活人员</span>
            <span class="my-input6 borad-text-right">{{$device_info->name}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站区域</span>
            <input id="psArea" data-key="23-385-4224" class="my-input5 borad-text-left" type="text" readonly placeholder="{{$device_info->province}}{{$device_info->city}}{{$device_info->area}}">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">街道名称</span>
            <span class="my-input6 borad-text-right">{{$device_info->street}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">具体位置</span>
            <span class="my-input6 borad-text-right">{{$device_info->address}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电价成本</span>
            <span class="my-input6 borad-text-right">{{$device_info->charging_cost}}元/度</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">充电计费</span>
            <span class="my-input6 borad-text-right">{{$device_info->charging_unit_second}}小时/元</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">激活时间</span>
            <span class="my-input6 borad-text-right">{{$device_info->active_time}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">联网状态</span>
            @if($device_info->net_status==0)
            <span class="text-45-red" style="margin-left: 1.3rem;">在线</span>
                @else
                <span class="text-45-red" style="margin-left: 1.3rem;">离线</span>
                @endif
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">电站状态</span>
            @if($device_info->equipment_status==0)
                <span id="status_on" data-equipmentStatus="{{$device_info->equipment_status}}" class="text-40-white equipment-swich-seclect" style="margin-left: 1.15rem;">已激活</span>
                <span id="status_off" class="text-40-b3 dealer-swich" style="margin-left: 2rem;">已停用</span>
            @else
                <span id="status_on" data-equipmentStatus="{{$device_info->equipment_status}}" class="text-40-b3 dealer-swich" style="margin-left: 1.15rem;">已激活</span>
                <span id="status_off"class="text-40-white equipment-swich-seclect"  style="margin-left: 2rem;">已停用</span>
            @endif
        </li>
    </ul>
</section>
<section class="footer">
    <div align="center" style="margin-top:1rem; width: 100%;">
        <button class="button-style-red" onclick="goback()">返回电站管理</button>
    </div>

    <div align="center" style="margin-top:1rem; width: 100%;">
        <button class="button-style-green">修改信息</button>
    </div>

</section>
@endsection