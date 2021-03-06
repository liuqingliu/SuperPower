@extends('layouts.default')

@section('title', '账户充值')
@section('system', '个人中心')
@section('content')
<section class="header">
    @component('layouts._userheader')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
</section>

    <section class="body1">
        <div class="img-container">
            <img src="{{URL::asset('images/p13_01.png')}}" class="img-status" />
        </div>
        <div align="center" style="margin-top:1rem;">
            <span class="text-48-grey">已成功充值，金额稍后到账</span>
        </div>
        <div style="margin-top: 3.125rem;" align="center">
            <a href="{{route('user_center')}}" class="button-style">返回个人中心</a>
        </div>
    </section>

    {{--<section class="body2">--}}
        {{--<div class="img-container">--}}
            {{--<img src="{{URL::asset('images/p14_01.png')}}" class="img-status" />--}}
        {{--</div>--}}
        {{--<div align="center" style="margin-top:1rem;">--}}
				{{--<span class="text-48-grey">获取充值结果失败，请重试--}}
        		{{--</span>--}}
        {{--</div>--}}
        {{--<div style="margin-top: 3.125rem;">--}}
            {{--<a class="button-style">重新获取</a>--}}
        {{--</div>--}}
    {{--</section>--}}

@endsection