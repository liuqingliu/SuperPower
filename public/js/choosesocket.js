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
    $(".div-big ul li").click(function () {
        if ($(this.getElementsByTagName("div")).hasClass('inner-block-yes')) {
            $(this.getElementsByTagName("div")).addClass("inner-block-select");
            key = $(this).data("port");
            $('#selected_port').text(key + "号");
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
        type: 'POST',
        url: "/electric/opensocket",
        data: {"equipment_id":equipment_id,"port":key,"recharge_type":recharge_type},
        dataType: "json",
        success: function(data){
            if(data.errno==0){
                $('#myNormalDialog').modal('show');
            }
           console.log(data.errno+data.errmsg);

        },
    });
}
function showPart2() {
    $('.part1').hide();
    $('.part2').show();
}
function hidePart2() {
    $('.part2').hide();
    $('.part1').show();
}
var recharge_type = 0;
$(document).ready(function () {
    $(".recharge-time").click(function () {
        $(".part2 ul li div").removeClass("money-block-select");
        $(".part2 ul li div p").removeClass("text-36-white").addClass("text-36");
        $(this).addClass("money-block-select");
        $(this).children().addClass("text-36-white").removeClass("text-36")
        recharge_type = $(this).data('time');
    });
});

$('.dialog-single-button').click(function () {
    history.back(-1);
})