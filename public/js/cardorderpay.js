var rechageMoney = 0;
var rechargeCardNum = 0;
$(document).ready(function () {
    $(".money-block").click(function () {
        $("ul li div").removeClass("money-block-select");
        $("li div p.real_price").addClass("text-48-grey").removeClass("text-48-white");

        $(this).addClass("money-block-select");
        $(this.getElementsByClassName('real_price')[0]).addClass("text-48-white").removeClass("text-48-grey");
        // $(".given_price").style.visibility = "hidden";
        var text = $(this.getElementsByClassName('real_price')[0]).text();
        rechageMoney =parseInt(text.substring(1,text.length-1)) ;
    });
});

function Values() {
    if ($('#dialogInput').val().length<11){
        Toast('请输入正确的电卡号',2000);
        return;
    }
    $('#cardNum').val($('#dialogInput').val());
    rechargeCardNum = $('#dialogInput').val();
    $('#cardNumInput').modal('hide')
}
function confirmInfo() {
    if ($('#cardNum').val().length<11){
      Toast('请输入电卡号',2000);
      return;
    }
    if (rechageMoney==0){
        Toast('请选择充值金额',2000)
        return;
    }
    $('#cardInfo').text('电卡卡号：'+rechargeCardNum);
    $('#moneyInfo').text('充值金额：'+parseFloat(rechageMoney).toFixed(2)+'元')
    $('#confirmDialog').modal('show')
}
function confirmedRecharge() {

    $('#confirmDialog').modal('hide')
}

// wx.config(<?php echo $wxjssdk; ?>);
function scanCard(){
    wx.scanQRCode({
        needResult : 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
        scanType : [ "qrCode"], // 可以指定扫二维码还是一维码，默认二者都有
        success : function(res) {
            var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
            parent.location.href = result;//因为我这边是扫描后有个链接，然后跳转到该页面
        }
    });
}