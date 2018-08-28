@extends('layouts.default')

@section('title', '电卡充值')

@section('content')
<section class="header">
    <!-- title -->
    <div class="text-center title-container">
        <a href="javascript:history.back(-1);" class="title-back">
            <img class="title-back-img" src="{{URL::asset('images/p2_01.png')}}" alt="返回">
            <span class="title-back-text">返回</span>
        </a>
        <span class="title-text">电卡充值</span>
    </div>
    <!-- title -->
</section>
@if ($success_flag))
    <section class="body1" style="display: none;">
        <div class="img-container">
            <img src="{{URL::asset('images/p13_01.png')}}" class="img-status" />
        </div>
        <div align="center" style="margin-top:1rem;">
            <span class="text-48-grey">已成功充值，金额实时到账</span>
        </div>
        <div style="margin-top: 50px;">
            <button class="button-style">返回个人中心</button>
        </div>
    </section>
@else
    <section class="body2">
        <div class="img-container">
            <img src="{{URL::asset('images/p14_01.png')}}" class="img-status" />
        </div>
        <div align="center" style="margin-top:1rem;">
				<span class="text-48-grey">获取充值结果失败，请重试
        		</span>
        </div>
        <div style="margin-top: 50px;">
            <button class="button-style">重新获取</button>
        </div>
    </section>
@endif
@endsection