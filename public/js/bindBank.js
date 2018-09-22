function confirmInfo() {
    if ($('#cardNum').val().length<11){
        Toast('请输入电卡号',2000);
        return;
    }
    if (recharge_money==0){
        Toast('请选择充值金额',2000)
        return;
    }
    $('#cardInfo').text('电卡卡号：'+$('#cardNum').val());
    $('#moneyInfo').text('充值金额：'+parseFloat(recharge_money).toFixed(2)+'元')
    $('#confirmDialog').modal('show')
}