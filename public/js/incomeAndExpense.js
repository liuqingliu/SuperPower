$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
querySummary();
//营销查询
function querySummary() {
    $.ajax({
        type: 'GET',
        url: "/dealer/getCashLogList",
        data:{},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                // $('.footer ul li').remove();
                console.log(data);
                var arry = data.result.cash_log_list;
                loadlog(arry)
            }else {
               Toast(data.errmsg);
            }
        },
    });
}
function loadlog(arry) {
    for (var i = 0; i <arry.length; i++) {
        var item = arry[i];
        var html = '';//遍历拼接html
        html += ' <li class="revenus-item">';
        html += '<div class="revenus-item-row" style="top: 1rem;">';
        if (item.cash_type==1){
            if (item.cash_status==1) {
                html += '<span class="pull-left text-36">提成收入</span>';
            }else {
                html += '<span class="pull-left text-36">提成支出</span>';
            }
        } else if (item.cash_type==2) {
            if (item.cash_status==1) {
                html += '<span class="pull-left text-36">充电收入</span>';
            }else {
                html += '<span class="pull-left text-36">充电支出</span>';
            }
        }else if (item.cash_type==3) {
            if (item.cash_status==1) {
                // html += '<span class="pull-left text-36">账户提现</span>';
            }else {
                html += '<span class="pull-left text-36">账户提现</span>';
            }
        }
        html += '<span class="pull-right text-36-b3">'+item.created_at+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:3rem;">';
        // html += '<span class="pull-left text-36">余额</span>';
        if (item.cash_status==1) {
            html += '<span class="pull-right text-36">+'+item.cash_price+'元</span>';
        }else {
            html += '<span class="pull-right text-36">-'+item.cash_price+'元</span>';
        }
        html += '</div>';
        html += '<div class="item-line">';
        html += '<div class="line-dark"></div>';
        html += '</div>';
        html += '</li>';
        $(".body ul").append(html);

    }
}
