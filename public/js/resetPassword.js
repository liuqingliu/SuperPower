$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
changeVcode();
function doReset() {
    if ($('#verifyCode').val()==''){
        Toast("请输入验证码");
        return;
    }
    if ($('#password1').val()==''){
        Toast("请输入密码");
        return;
    }
    if ($('#password2').val()==''){
        Toast("请输入确认密码");
        return;
    }
    if ($('#idNum').val()==''){
        Toast("请输入身份证号码");
        return;
    }
    $.ajax({
        type: 'POST',
        url: "/dealer/doResetPassword",
        data: {"id_card":$('#idNum').val(),"password":$('#password1').val(),"verifyCode":$('#verifyCode').val(),"password_confirmation":$('#password2').val()},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                Toast("重置密码成功",2000);
                window.history.back(-1);
            }else {
                Toast(data.errmsg.result);
            }
        },
    });
}
