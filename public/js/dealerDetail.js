function back() {
    history.back(-1);
}
var dealer_status = $('#status_on').data('dealerStatus');
$('#status_on').click(function () {
    $('#status_on').addClass("text-40-white dealer-swich-seclect").removeClass("text-40-b3 dealer-swich");
    $('#status_off').addClass("text-40-b3 dealer-swich").removeClass("text-40-white dealer-swich-seclect");
    dealer_status = 1;
});
$('#status_off').click(function () {
    $('#status_on').addClass("text-40-b3 dealer-swich").removeClass("text-40-white dealer-swich-seclect");
    $('#status_off').addClass("text-40-white dealer-swich-seclect").removeClass("text-40-b3 dealer-swich");
    dealer_status = 2;
});