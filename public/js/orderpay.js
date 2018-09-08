$(document).ready(function () {
    $("div ul li").click(function () {
        $(this).getElem("order_block").addClass("money-block-select");
        // $(this.getElementsByTagName("div")).children().addClass("text-select");
        // $(this.getElementById("order_tag")).style.visibility = "hidden";
        // $(this.getElementById("real_price")).addClass("text-48-white").removeClass("text-48-grey");
        // $(this.getElementById("given_price")).style.visibility = 'hidden';

            // for (var i = 0; i < $(this).siblings().length; i++) {
            //     var arry = $(this).siblings();
            //     $(arry[i].getElementsByTagName("div")).removeClass("money-block-select");
            //     $(arry[i].getElementsByTagName("div")).children().removeClass("text-select")
            // }
    });
});