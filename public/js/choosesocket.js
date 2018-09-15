var key = 0;

function showHideCode() {
    $("#detail").toggle();
    var img = document.getElementById("choosesocke_updownimg");
    if ($("#detail").is(":hidden")) {
        img.src = "/images/p17_01.png";
    } else {
        img.src = "/images/p18_01.png";
    }
}

$(document).ready(function () {
    $("ul li").click(function () {
        if ($(this.getElementsByTagName("div")).hasClass('inner-block-yes')) {
            $(this.getElementsByTagName("div")).addClass("inner-block-select");
            key = $(this).data("port");
            $(this.getElementsByTagName("div")).children().addClass("text-select");
            for (var i = 0; i < $(this).siblings().length; i++) {
                var arry = $(this).siblings();
                $(arry[i].getElementsByTagName("div")).removeClass("inner-block-select");
                $(arry[i].getElementsByTagName("div")).children().removeClass("text-select")
            }
            $('#chooseDialog').modal('show');
        }
    });
});

function opensocket(equipment_id) {
    $.ajax({
        type: 'GET',
        url: "/electric/opensocket",
        data: {"equipment_id":equipment_id,"port":key,"recharge_type":"0"},
        dataType: "json",
        success: function(data){
           alert(data.errno+data.errmsg);
        },
    });
}
