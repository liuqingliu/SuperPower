function closesocket(orderid) {
    $.ajax({
        type: 'POST',
        url: "/electric/closesocket",
        data: {"order_id":orderid},
        dataType: "json",
        success: function(data){
            alert(data.errno+data.errmsg);
        },
    });
}