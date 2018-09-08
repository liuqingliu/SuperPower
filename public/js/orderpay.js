$(document).ready(function () {
    $(".money-block").click(function () {
        $(this).parent().parent().find("li div").removeClass("money-block-select");
        $(this).parent().parent().find("li div div").style.visibility = "visible";;
        $(this).parent().parent().find("li div p:eq(0)").addClass("text-48-grey").removeClass("text-48-white");


        $(this).addClass("money-block-select");
        $(".order_tag").style.visibility = "hidden";
        $(".real_price").addClass("text-48-white").removeClass("text-48-grey");
        // $(".given_price").style.visibility = "hidden";
    });
});