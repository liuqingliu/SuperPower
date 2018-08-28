@extends('layouts.default')

@section('title', '充小满')

@section('content')
<section class="header">
    <!-- title -->
    <div class="text-center title-container">
        <a href="javascript:history.back(-1);" class="title-back">
            <img class="title-back-img" src="{{URL::asset('images/p2_01.png}}" alt="返回">
            <span class="title-back-text">返回</span>
        </a>
        <span class="title-text">充小满</span>
    </div>
    <!-- title -->
</section>
<section class="body">
    <div class="container">
        <img src="{{URL::asset('images/p15_01.png}}" class="img-status" />
        <div align="center">
            <span class="mini-text">V1.0.0</span>
        </div>
    </div>
    <ul class="board1">
        <li class="borad-heigh">
            <span class="borad-text-left pull-left">免责申明</span>
            <img class="img-getin pull-right img-rounded" src="{{URL::asset('images/p15_02.png}}">
        </li>
        <li class="line"></li>
        <li class="borad-heigh">
            <span class="borad-text-left pull-left">意见反馈</span>
            <img class="img-getin pull-right img-rounded" src="{{URL::asset('images/p15_02.png}}">
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
