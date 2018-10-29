changeVcode();
//获取短信验证码
$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
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
                $('#myNormalDialog').modal('show')
            }else {
                Toast(data.result);
            }
        },
    });
}
$('.dialog-single-button').click(function () {
    // history.go(-1);
    self.location=document.referrer;
});
