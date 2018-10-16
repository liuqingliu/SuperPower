@extends('layouts.default')
@section('myjs')
    <script type="text/javascript" src="{{asset('/js/dealerDetail.js?v=1.2')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery.scs.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/CNAddrArr.min.js')}}"></script>
@endsection
@section('title', '经销商管理')
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
            经销商信息
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">姓名</span>
            <input id="addDealerName" class="borad-text-left my-input8" type="text" name="identifying-code" placeholder="{{$dealer_info->name}}" oninput="if(value.length>6)value=value.slice(0,6)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">身份证号</span>
            <input id="addDealerIdCard" class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="{{$dealer_info->id_card}}" oninput="if(value.length>18)value=value.slice(0,18)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">手机号码</span>
            <span class="my-input6 borad-text-right">{{$dealer_info->user->phone}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">所在区域</span>
            <input id="addDealerArea" class="my-input5 borad-text-left" data-key="23-385-4224" readonly type="text" name="addr" placeholder="{{$dealer_info->province}}{{$dealer_info->city}}{{$dealer_info->area}}">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">对方账号</span>
            <span class="my-input6 borad-text-right">{{$dealer_info->user->user_id}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">账户类别</span>
            @if($dealer_info->user->user_type==1)
            <span class="my-input6 borad-text-right">普通经销商</span>
                @elseif($dealer_info->user->user_type==2)
                <span class="my-input6 borad-text-right">超级经销商</span>
                @else
                <span class="my-input6 borad-text-right">厂商</span>
                @endif
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">抽成比例</span>
            <input id="addDealerProportion" class="my-input5 borad-text-left" type="number" placeholder="{{$dealer_info->give_proportion}}" oninput="if(value.length>6)value=value.slice(0,6)">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">创建时间</span>
            <span class="my-input6 borad-text-right">{{$dealer_info->created_at}}</span>
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">账户状态</span>
            @if($dealer_info->user->user_status==1)
                <span id="status_on" data-dealerStatus="{{$dealer_info->user->user_status}}" class="text-40-white dealer-swich-seclect" style="margin-left: 1.15rem;">正常</span>
                <span id="status_off" class="text-40-b3 dealer-swich" style="margin-left: 2rem;">冻结</span>
            @else
                <span id="status_on" data-dealerStatus="{{$dealer_info->user->user_status}}" class="text-40-white dealer-swich-seclect" style="margin-left: 1.15rem;">正常</span>
                <span id="status_off" class="text-40-b3 dealer-swich" style="margin-left: 2rem;">冻结</span>
            @endif
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left">备注信息</span>
            <input id="addDealerRemark" class="my-input5 borad-text-left" type="text" name="identifying-code" placeholder="{{$dealer_info->remark}}" oninput="if(value.length>15)value=value.slice(0,15)">
        </li>
    </ul>
</section>
<section class="footer">
    <div class="text-45-b3 tip-container">
        提示：抽成比例是针对流水总额的抽成
    </div>
    <div align="center" style="margin-top:1rem; width: 100%;">
        <button class="button-style-red" onclick="back()">返回经销商管理</button>
    </div>

    <div align="center" style="margin-top:1rem; width: 100%;">
        <button onclick="changeDealer()" class="button-style-blue">修改信息</button>
    </div>
</section>
@endsection