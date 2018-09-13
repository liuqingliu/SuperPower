$(document).ready(function () {
    $(".money-block").click(function () {
        $("ul li div").removeClass("money-block-select");
        $("ul li div div").css({'visibility':'visible'});
        $("li div p.real_price").addClass("text-48-grey").removeClass("text-48-white");

        $(this).addClass("money-block-select");
        this.getElementsByClassName('order_tag')[0].style.visibility  ="hidden";
        $(this.getElementsByClassName('real_price')[0]).addClass("text-48-white").removeClass("text-48-grey");
        // $(".given_price").style.visibility = "hidden";
    });
});

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
function creatOrder() {
    $.ajax({
        type: 'POST',
        url: "/api/user/createOrder",
        data: {"pay_money_type":"2"},
        dataType: "json",
        success: function(data){
            console.log(data.errno);
            callpay(data.result);
        },
    });


}

// //调用微信JS api 支付
function jsApiCall($res)
{
    console.log(4);
    console.log($res);
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',$res,
        function(answer){
            WeixinJSBridge.log(answer.err_msg);
            // alert(answer.err_code+answer.err_desc+answer.err_msg);
        }
    );
}

function callpay($res)
{
    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            console.log(2);
            document.addEventListener('WeixinJSBridgeReady', jsApiCall($res), false);
        }else if (document.attachEvent){
            console.log(3);
            document.attachEvent('WeixinJSBridgeReady', jsApiCall($res));
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall($res));
        }
    }else{
        console.log(1);
        jsApiCall($res);
    }
}