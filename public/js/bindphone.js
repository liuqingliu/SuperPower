changeVcode();
//获取短信验证码
function getPhoneVcode() {
    if ($('#imageVcode').val()==''){
        Toast("请输入验证码");
        return;
    }
    if ($('#phonenum').val().length!=11){
        Toast("请输入正确的手机号码");
        return;
    }
    $.ajax({
        type: 'GET',
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
function bindPhone() {
    if ($('#phoneVcode').val()==''){
        Toast("请输入验证码");
        return;
    }
    if ($('#phonenum').val().length!=11){
        Toast("请输入正确的手机号码");
        return;
    }
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: 'POST',
        url: "/user/updateUserPhone",
        data: {"user_phone":$('#phonenum').val(),"verifyCode":$('#phoneVcode').val()},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                $('#myNormalDialog').modal('show')
            }else {
                Toast(data.errmsg);
            }
        },
    });
}
$('.dialog-single-button').click(function () {
    history.back(-1);
});
