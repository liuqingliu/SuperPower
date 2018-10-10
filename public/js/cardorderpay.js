var recharge_money = 0;
var recharge_cardNum = 0;
$(document).ready(function () {
    $(".money-block").click(function () {
        $("ul li div").removeClass("money-block-select");
        $("li div p.real_price").addClass("text-48-grey").removeClass("text-48-white");

        $(this).addClass("money-block-select");
        $(this.getElementsByClassName('real_price')[0]).addClass("text-48-white").removeClass("text-48-grey");
        // $(".given_price").style.visibility = "hidden";
        var text = $(this.getElementsByClassName('real_price')[0]).text();
        recharge_money = parseInt(text.substring(1,text.length-1)) ;
    });
});

function Values() {
    if ($('#dialogInput').val().length<11){
        Toast('请输入正确的电卡号',2000);
        return;
    }
    $('#cardNum').val($('#dialogInput').val());
    recharge_cardNum = $('#dialogInput').val();
    $('#cardNumInput').modal('hide')
}
function confirmInfo() {
    if ($('#cardNum').val().length<11){
      Toast('请输入电卡号',2000);
      return;
    }
    if (recharge_money==0){
        Toast('请选择充值金额',2000)
        return;
    }
    $('#cardInfo').text('电卡卡号：'+$('#cardNum').val());
    $('#moneyInfo').text('充值金额：'+parseFloat(recharge_money).toFixed(2)+'元')
    $('#confirmDialog').modal('show')
}
function confirmedRecharge() {
    $('#confirmDialog').modal('hide')
    creatCardOrder();
}

// wx.config(<?php echo $wxjssdk; ?>);
function scanCard(){
    wx.scanQRCode({
        needResult : 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
        scanType : [ "qrCode"], // 可以指定扫二维码还是一维码，默认二者都有
        success : function(res) {
            var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
            window.location.href = result;//因为我这边是扫描后有个链接，然后跳转到该页面
        }
    });
}
$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
function creatCardOrder() {
    if (recharge_money!=0){
        $.ajax({
            type: 'POST',
            url: "/electric/createOrder",
            data: {"pay_money_type":recharge_money,"card_id":recharge_cardNum},
            dataType: "json",
            success: function(data){
                console.log(data.errno);
                callpay(data.result);
            },
        });
    }else {
        Toast("请选择充值金额",2000);
    }
}

//调用微信JS api 支付
function jsApiCall($res)
{
    // console.log(4);
    // console.log($res);
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',$res,
        function(answer){
            WeixinJSBridge.log(answer.err_msg);
            // alert(answer.err_code+">"+answer.err_desc+">"+answer.err_msg+">");
            if(answer.err_msg.contains("ok")){
               window.location.href = "/electric/cardorderpayanswer";
            }else {
                alert('微信支付异常请，稍后再试！')
            }
        }
    );
}

function callpay($res)
{
    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            // console.log(2);
            document.addEventListener('WeixinJSBridgeReady', jsApiCall($res), false);
        }else if (document.attachEvent){
            // console.log(3);
            document.attachEvent('WeixinJSBridgeReady', jsApiCall($res));
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall($res));
        }
    }else{
        // console.log(1);
        jsApiCall($res);
    }
}