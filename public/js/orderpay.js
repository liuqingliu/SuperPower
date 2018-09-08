$(document).ready(function () {
    $("div ul li").click(function () {
            $("div ul li div").addClass("money-block-select");
        //     // $(this.getElementsByTagName("div")).children().addClass("text-select");
        // $(this.getElementsByTagName("div")).children().style.visibility="hidden";
        //     $("ul li div p").addClass("text-select");
        //     if ($("ul li div p").hasClass("mini-text-red")){
        //         $("ul li div p").style.visibility='hidden';
        //     }


            // for (var i = 0; i < $(this).siblings().length; i++) {
            //     var arry = $(this).siblings();
            //     $(arry[i].getElementsByTagName("div")).removeClass("money-block-select");
            //     $(arry[i].getElementsByTagName("div")).children().removeClass("text-select")
            // }
    });
});