var recharge_money=0;
$(document).ready(function () {
    $(".money-block").click(function () {
        recharge_money = $(this).data("real_price");
        $("ul li div").removeClass("money-block-select");
        $("li div p.real_price").addClass("text-48-grey").removeClass("text-48-white");
        $("li div p.given_price").addClass("mini-text-red").removeClass("mini-text-white");
        if ($(this.getElementsByClassName('recharge-block_title')[0]).data("new_user")){
            $("ul li div div").css({'visibility':'visible'});
            this.getElementsByClassName('recharge-block_title')[0].style.visibility  ="hidden";
        }
        $(this).addClass("money-block-select");
        $(this.getElementsByClassName('real_price')[0]).addClass("text-48-white").removeClass("text-48-grey");
        $(this.getElementsByClassName('given_price')[0]).addClass("mini-text-white").removeClass("mini-text-red");
        // $(".given_price").style.visibility = "hidden";
    });
});


$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
var isClick = true;
function creatOrder() {
    if (isClick) {
        isClick = false;
        if (recharge_money!=0){
            $.ajax({
                type: 'POST',
                url: "/user/createOrder",
                data: {"pay_money_type":recharge_money},
                dataType: "json",
                success: function(data){
                    console.log(data);
                    callpay(data.result);
                },
            });
        }else {
            Toast("请选择充值金额",2000);
        }
    }
}
// //调用微信JS api 支付
function jsApiCall($res)
{
    // console.log(4);
    // console.log($res);
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',$res,
        function(answer){
            WeixinJSBridge.log(answer.err_msg);
            // console.log(answer);
            // alert(answer.err_code+">"+answer.err_desc+">"+answer.err_msg+">");
            isClick = true;
            if(answer.err_msg=='get_brand_wcpay_request:ok'){
            //     alert(answer.err_code+">"+answer.err_desc+">"+answer.err_msg+">");
                window.location.href = "/user/orderanswser";
            }else if (answer.err_msg=='get_brand_wcpay_request:cancel'){

            } else {
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