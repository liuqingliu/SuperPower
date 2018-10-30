$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
querySummary(2)
$("#bydevice").click(function () {
    querySummary(2);
    $("#bydevice").removeClass('borad-text-right').addClass('borad-text-red')
    $("#bydealer").addClass('borad-text-right').removeClass('borad-text-red')
});
$("#bydealer").click(function () {
    querySummary(1);
    $("#bydealer").removeClass('borad-text-right').addClass('borad-text-red')
    $("#bydevice").addClass('borad-text-right').removeClass('borad-text-red')
});

//营销查询
function querySummary(type) {
    $.ajax({
        type: 'GET',
        url: "/dealer/getRevenueSummaryList",
        data: {"type":type},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                $('.footer ul li').remove();
                $("#sum").text(data.result.sum_price);
                // console.log(data);
                var arry = data.result.revenue_summary_list;
                if (type==2){
                    loadbydevice(arry)
                }else {
                    loadbydealer(arry)
                }
            }else {
                Toast(data.result);
            }
        },
    });
}
function loadbydealer(arry) {
    for (var i = 0; i <arry.length; i++) {
        var item = arry[i];
        var html = '';//遍历拼接html
        html += ' <li class="revenus-item">';
        html += '<div class="revenus-item-row" style="top: 1rem;">';
        html += '<span class="pull-left text-36">'+item.name+'</span>';
        html += '<span class="pull-right text-36-red">'+item.sum_cash_price+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:2.5rem;">';
        html += '<span class="pull-left mini-text">'+item.phone+'</span>';
        html += ' <span class="pull-right mini-text">'+item.address+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:4rem;">';
        html += '<span class="pull-left mini-text">'+item.id_card+'</span>';
        if (item.user_status =="0"){
            html += ' <span class="pull-right mini-text">正常</span>';
        }else {
            html += '<span class="pull-right mini-text-red">冻结</span>';
        }
        html += ' </div>';
        html += '<div class="item-line">';
        html += '<div class="line-dark"></div>';
        html += '</div>';
        html += '</li>';
        $(".footer ul").append(html);

    }
}
function loadbydevice(arry) {
    for (var i = 0; i <arry.length; i++) {
        var item = arry[i];
        var html = '';//遍历拼接html
        html += ' <li class="revenus-item">';
        html += '<div class="revenus-item-row" style="top: 1rem;">';
        html += '<span class="pull-left text-36">'+item.name+'</span>';
        html += '<span class="pull-right text-36-red">'+item.sum_cash_price+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:2.5rem;">';
        html += '<span class="pull-left mini-text">'+item.equipment_id+'</span>';
        html += ' <span class="pull-right mini-text">'+item.address+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:4rem;">';
        // html += '<div class="pull-left"><span class="mini-text-red">'+item.use_port_num+'</span><span class="mini-text">/'+item.total_port+'</span></div>';
        if (item.equipment_status =="0"){
            html += ' <span class="pull-right mini-text">正常</span>';
        }else {
            html += '<span class="pull-right mini-text-red">冻结</span>';
        }
        html += ' </div>';
        html += '<div class="item-line">';
        html += '<div class="line-dark"></div>';
        html += '</div>';
        html += '</li>';
        $(".footer ul").append(html);

    }
}