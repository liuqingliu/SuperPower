<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0,user-scalable=0" />
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>@yield('title')</title>
    <!-- Bootstrap -->
{{--<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
<!-- 私有 -->
    {{--<link href="{{URL::asset('css/index.css?v=1.4')}}" rel="stylesheet">--}}
    <link rel="stylesheet" href="/css/app.css?v=1.5">
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div style="margin:auto; width: 50%; height: auto; overflow: hidden;">
    <div class="box box-default" style="margin-top: 20%;">
        <div class="box-header with-border">
            <i class="fa fa-bullhorn"></i>
            <h3 class="box-title">提示</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if ($data['status']=='error')
                <div class="callout callout-danger">
                    <h4>错误</h4>
                    <p>{{$data['message']}}</p>
                    <p>浏览器页面将在<b id="loginTime_error">{{ $data['jumpTime'] }}</b>秒后跳转......<a href="javascript:void(0);" class="jump_now">立即跳转</a> </p>
                </div>
            @endif
            @if ($data['status']=='continue')
                <div class="callout callout-info">
                    <h4>未完成，继续</h4>
                    <p>{{$data['message']}}</p>
                    <p>浏览器页面将在<b id="loginTime_continue">{{ $data['jumpTime'] }}</b>秒后跳转......<a href="javascript:void(0);" class="jump_now">立即跳转</a> </p>
                </div>
            @endif
            @if ($data['status']=='warning')
                <div class="callout callout-warning">
                    <h4>警告</h4>
                    <p>{{$data['message']}}</p>
                    <p>浏览器页面将在<b id="loginTime_warning">{{ $data['jumpTime'] }}</b>秒后跳转......<a href="javascript:void(0);" class="jump_now">立即跳转</a> </p>
                </div>
            @endif
            @if ($data['status']=='success')
                <div class="callout callout-success">
                    <h4>成功</h4>
                    <p>{{$data['message']}}</p>
                    <p>浏览器页面将在<b id="loginTime_success">{{ $data['jumpTime'] }}</b>秒后跳转......<a href="javascript:void(0);" class="jump_now">立即跳转</a> </p>
                </div>
            @endif
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
</body>
<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>
<!--本页JS-->
<script type="text/javascript">
    $(function(){
        //循环倒计时，并跳转
        var url = "{{ $data['url'] }}";
        var loginTimeID='loginTime_'+'{{$data['status']}}';
        //alert(loginTimeID);return;
        var loginTime = parseInt($('#'+loginTimeID).text());
        console.log(loginTime);
        var time = setInterval(function(){
            loginTime = loginTime-1;
            $('#'+loginTimeID).text(loginTime);
            if(loginTime==0){
                clearInterval(time);
                window.location.href=url;
            }
        },1000);
    });
    //点击跳转
    $('.jump_now').click(function () {
        var url = "{{ $data['url'] }}";
        window.location.href=url;
    });

</script>