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
            $(this.getElementsByTagName("div")).children().addClass("text-select");
            for (var i = 0; i < $(this).siblings().length; i++) {
                var arry = $(this).siblings();
                $(arry[i].getElementsByTagName("div")).removeClass("inner-block-select");
                $(arry[i].getElementsByTagName("div")).children().removeClass("text-select")
            }
        }else {
            Toast("这个插头有大哥在用！",2000)
        }
    });
});
