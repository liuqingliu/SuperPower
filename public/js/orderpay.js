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