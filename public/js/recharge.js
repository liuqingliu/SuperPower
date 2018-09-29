
var t = $("#chargeTime").data("chargetime");
function closesocket(orderid) {
    $.ajax({
        type: 'GET',
        url: "/electric/closesocket",
        data: {"order_id":orderid},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                $('#myNormalDialog').modal({backdrop: 'static', keyboard: false});
            }
        },
    });
}
$("#chargeTime").text("已充"+parseInt(t/60)+"小时"+t%60+"分钟");
setInterval(function () {
    var hour = t/60;
    var sec = t%60;
    $("#chargeTime").text("已充"+parseInt(hour)+"小时"+sec+"分钟");
    t++;
}, 60*1000);
$(".dialog-single-button").click(function () {
    history.back(-1);
});