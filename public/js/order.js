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
            console.log(data.errno)
        },
    });


}

// //调用微信JS api 支付
// function jsApiCall()
// {
//     WeixinJSBridge.invoke(
//         'getBrandWCPayRequest',{"appId":"wx604f85d199ae04c9","timeStamp":"1535206291","nonceStr":"5b816393b54cc","package":"prepay_id=wx2522113121896933df54b5b91814180647","signType":"MD5","paySign":"B1B1BAE3C83619FC261D44D94F18BA63"},
//         function(res){
//             WeixinJSBridge.log(res.err_msg);
//             alert(res.err_code+res.err_desc+res.err_msg);
//         }
//     );
// }
//
// function callpay()
// {
//     if (typeof WeixinJSBridge == "undefined"){
//         if( document.addEventListener ){
//             document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
//         }else if (document.attachEvent){
//             document.attachEvent('WeixinJSBridgeReady', jsApiCall);
//             document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
//         }
//     }else{
//         jsApiCall();
//     }
// }