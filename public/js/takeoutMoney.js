$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
function setPassword() {
    if ($('#password1').val()==''){
        Toast("请输入密码");
        return;
    }
    if ($('#password2').val()==''){
        Toast("请输入确认密码");
        return;
    }
    $.ajax({
        type: 'POST',
        url: "/dealer/doSetPassword",
        data: {"password":$('#password1').val(),"password_confirmation":$('#password2').val()},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                Toast("密码设置成功");
                $('#passworddialog').modal('hide');
                window.location.reload();
                // if (!$('#isbindbank').val()){
                //     $('#bindbankdialog').modal({backdrop:'static',keyboard:false});
                // }
            }else {
               Toast(data.errmsg);
            }
        },
    });
}
function bindPhone() {
    if ($('#phoneVcode').val()==''){
        Toast("请输入验证码");
        return;
    }
    if ($('#phonenum').val().length!=11){
        Toast("请输入正确的手机号码");
        return;
    }
    $.ajax({
        type: 'GET',
        url: "/user/updateUserPhone",
        data: {"user_phone":$('#phonenum').val(),"verifyCode":$('#phoneVcode').val()},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                Toast("绑定电话成功",2000);
                changeVcode();
                $('#bindphonedialog').modal('hide');
                window.location.reload();
                // if (!$('#issetpassword').val()){
                //     $('#passworddialog').modal({backdrop:'static',keyboard:false});
                // }else if (!$('#isbindbank').val()){
                //     $('#bindbankdialog').modal({backdrop:'static',keyboard:false});
                // }
            }else {
               Toast(data.errmsg);
            }
        },
    });
}
function doCarry() {
    if ($('#verifyCode').val()==''){
        Toast("请输入验证码");
        return;
    }
    if ($('#password').val()==''){
        Toast("请输入提现密码");
        return;
    }
    if ($('#money').val()==''){
        Toast("请输入提现金额");
        return;
    }
    $.ajax({
        type: 'POST',
        url: "/dealer/doTixian",
        data: {"money":$('#money').val(),"password":$('#password').val(),"verifyCode":$('#verifyCode').val()},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                $('#myNormalDialog').modal({backdrop:'static',keyboard:false});
            }else {
               Toast(data.errmsg);
            }
        },
    });
}
$(".dialog-single-button").click(function () {
    $('#myNormalDialog').modal('hide');
    location.replace(document.referrer);
});
function keyPress() {
    var keyCode = event.keyCode;
    if ((keyCode >= 48 && keyCode <= 57))
    {
        event.returnValue = true;
    } else {
        event.returnValue = false;
    }
}