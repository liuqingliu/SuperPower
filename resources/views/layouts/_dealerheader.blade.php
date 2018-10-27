<div class="text-center title-container">
    {{--<a href="#" class="title-back">--}}
        {{--<img class="op-img" src="{{URL::asset('images/pm1_01.png')}}" alt="更多">--}}
    {{--</a>--}}
    <div class="dropdown title-back">
        <a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <img class="op-img" src="{{URL::asset('images/pm1_01.png')}}" alt="更多">
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <a href="{{route('user_center')}}">
                <li>
                    <img class="dealer-option-img img-rounded" src="{{URL::asset('images/p1_13_off.png')}}">
                    <span class="borad-text-left">用户中心</span>
                </li>
            </a>
            <li role="separator" class="divider"></li>
            <a href="{{route('dealer_center')}}">
                <li>
                    <img class="dealer-option-img img-rounded" src="{{URL::asset('images/pm2_01.png')}}">
                    <span class="borad-text-left">首页</span>
                </li>
            </a>
            {{--<li role="separator" class="divider"></li>--}}
            {{--<a href="{{route('dealer_electriccardmanage')}}">--}}
                {{--<li>--}}
                    {{--<img class="dealer-option-img img-rounded" src="{{URL::asset('images/pm2_02.png')}}">--}}
                    {{--<span class="borad-text-left">电卡管理</span>--}}
                {{--</li>--}}
            {{--</a>--}}
            <li role="separator" class="divider"></li>
            <a href="{{route('dealer_powerStationManage')}}">
                <li>
                    <img class="dealer-option-img img-rounded" src="{{URL::asset('images/pm2_03.png')}}">
                    <span class="borad-text-left">电站管理</span>
                </li>
            </a>
            @if($type>1)
            <li role="separator" class="divider"></li>
            <a href="{{route('dealer_manage')}}">
                <li>
                    <img class="dealer-option-img img-rounded" src="{{URL::asset('images/pm2_04.png')}}">
                    <span class="borad-text-left">经销商管理</span>
                </li>
            </a>
            @endif
            <li role="separator" class="divider"></li>
            <a href="{{route('dealer_moneymanage')}}">
                <li>
                    <img class="dealer-option-img img-rounded" src="{{URL::asset('images/pm2_05.png')}}">
                    <span class="borad-text-left">资金管理</span>
                </li>
            </a>
            <li role="separator" class="divider"></li>
            <a href="#">
                <li>
                    <img class="dealer-option-img img-rounded" src="{{URL::asset('images/pm2_06.png')}}">
                    <span class="borad-text-left">运营参谋</span>
                </li>
            </a>
            <li role="separator" class="divider"></li>
            <a href="#">
                <li>
                    <img class="dealer-option-img img-rounded" src="{{URL::asset('images/pm2_07.png')}}">
                    <span class="borad-text-left">通知公告</span>
                </li>
            </a>


        </ul>
    </div>
    <span class="title-text">@yield('title')</span>
</div>