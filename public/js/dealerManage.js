$('#adddealer').click(function () {
    $('.swich-bar1').css("background-image","url(/images/pm3_01_l.png)");
    $('#querydealer').addClass('text-45-b3').removeClass('text-45-white');
    $('#adddealer').addClass('text-45-white').removeClass('text-45-b3');
    $('.body1').show();
    $('.body2-step1').hide();
    $('.body2-step2').hide();
});
$('#querydealer').click(function () {
    $('.swich-bar1').css("background-image","url(/images/pm3_01_r.png)");
    $('#querydealer').addClass('text-45-white').removeClass('text-45-b3');
    $('#adddealer').addClass('text-45-b3').removeClass('text-45-white');
    $('.body1').hide();
    $('.body2-step1').show();
    $('.body2-step2').hide();
});
var dealer_type = "";
$('#normalDealer').click(function () {
    $('#normalDealer').addClass("text-40-white dealer-swich-seclect").removeClass("text-40-b3 dealer-swich");
    $('#superDealer').addClass("text-40-b3 dealer-swich").removeClass("text-40-white dealer-swich-seclect");
    dealer_type = 1;
});
$('#superDealer').click(function () {
    $('#normalDealer').addClass("text-40-b3 dealer-swich").removeClass("text-40-white dealer-swich-seclect");
    $('#superDealer').addClass("text-40-white dealer-swich-seclect").removeClass("text-40-b3 dealer-swich");
    dealer_type = 2;
});