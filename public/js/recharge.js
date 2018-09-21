function closesocket(orderid) {
    $.ajax({
        type: 'GET',
        url: "/electric/closesocket",
        data: {"order_id":orderid},
        dataType: "json",
        success: function(data){
            alert(data.errno+data.errmsg);
        },
    });
}