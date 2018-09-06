function showHideCode() {
    $("#detail").toggle();
    if ($("#detail").is(":none")){
        $("choosesocke_updownimg").src="/images/p18_01.png";
    }else {
        $("choosesocke_updownimg").src="/images/p17_01.png";
    }
}