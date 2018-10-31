//自定义弹框
function Toast(msg,duration){
    duration=isNaN(duration)?3000:duration;
    var m = document.createElement('div');
    m.innerHTML = msg;
    m.style.cssText="width:60%; min-width:150px; background:#000; opacity:0.5; height:40px; color:#fff; line-height:40px; text-align:center; border-radius:5px; position:fixed; top:80%; left:20%; z-index:999999; font-weight:bold;";
    document.body.appendChild(m);
    setTimeout(function() {
        var d = 0.5;
        m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
        m.style.opacity = '0';
        setTimeout(function() { document.body.removeChild(m) }, d * 1000);
    }, duration);
}
$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
//获取图片验证码
function changeVcode() {
    $.ajax({
        type: 'GET',
        url: "/api/getCaptcha",
        data: {},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                $('#identifying-img').attr("src",data.result);
            }
        },
    });
}
//获取短息验证码（传电话）
function getVcodewihtPhone(){
    if ($('#imageVcode').val()==''){
        Toast("请输入验证码");
        return;
    }
    if ($('#phonenum').val().length!=11){
        Toast("请输入正确的手机号码");
        return;
    }
    $.ajax({
        type: 'POST',
        url: "/api/sendMessage",
        data: {"user_phone":$('#phonenum').val(),"captcha":$('#imageVcode').val()},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                Toast("验证码已发送");
                settime();
            }else {
               Toast(data.errmsg);
            }
        },
    });
}
//获取短息验证码（不传电话）
function getVcodewihtoutPhone(){
    if ($('#imageVcode').val()==''){
        Toast("请输入验证码");
        return;
    }
    $.ajax({
        type: 'POST',
        url: "/api/sendMessage",
        data: {"captcha":$('#imageVcode').val()},
        dataType: "json",
        success: function(data){
            console.log(data);
            if (data.errno==0){
                Toast("验证码已发送");
                settime();
            }else {
                Toast(data.errmsg);
            }
        },
    });
}

//获取验证码倒计时
var countdown=120;
var _generate_code = $("#getPhoneVcode");
function settime() {

    if (countdown == 0) {
        _generate_code.attr("disabled",false);
        _generate_code.val("获取");
        countdown = 120;
        return false;
    } else {
        _generate_code.attr("disabled", true);
        _generate_code.val(countdown + "s");
        countdown--;
    }
    setTimeout(function() {
        settime();
    },1000);
}