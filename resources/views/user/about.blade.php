@extends('layouts.default')

@section('title', '充小满')

@section('content')
<section class="header">
    @component('layouts._header')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent
</section>
<section class="body">
    <div class="container">
        <img src="{{URL::asset('images/p15_01.png')}}" class="img-status" />
        <div align="center">
            <span class="mini-text">V1.0.0</span>
        </div>
    </div>
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left pull-left">免责申明</span>
            <img class="img-getin pull-right img-rounded" src="{{URL::asset('images/p15_02.png')}}">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left pull-left">意见反馈</span>
            <img class="img-getin pull-right img-rounded" src="{{URL::asset('images/p15_02.png')}}">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left pull-left">客服热线</span>
            <span class="borad-text-left pull-right">028-62676344</span>
        </li>
    </ul>
</section>
<section class="footer">
    <div class="footer">
				<span class="borad-text-right">
					 ©2018 朗畅科技.保留所有权限
				</span>
    </div>
</section>
@endsection
