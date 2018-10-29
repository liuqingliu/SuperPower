$(function() {
    /**
     * 通过数组id获取地址列表数组
     *
     * @param {Number} id
     * @return {Array}
     */
    function getAddrsArrayById(id) {
        var results = [];
        if (addr_arr[id] != undefined)
            addr_arr[id].forEach(function(subArr) {
                results.push({
                    key: subArr[0],
                    val: subArr[1]
                });
            });
        else {
            return;
        }
        return results;
    }
    /**
     * 通过开始的key获取开始时应该选中开始数组中哪个元素
     *
     * @param {Array} StartArr
     * @param {Number|String} key
     * @return {Number}
     */
    function getStartIndexByKeyFromStartArr(startArr, key) {
        var result = 0;
        if (startArr != undefined)
            startArr.forEach(function(obj, index) {
                if (obj.key == key) {
                    result = index;
                    return false;
                }
            });
        return result;
    }

    //bind the click event for 'input' element
    $("#input2").click(function() {
        var PROVINCES = [],
            startCities = [],
            startDists = [];
        //Province data，shall never change.
        addr_arr[0].forEach(function(prov) {
            PROVINCES.push({
                key: prov[0],
                val: prov[1]
            });
        });
        //init other data.
        var $input = $(this),
            dataKey = $input.attr("data-key"),
            provKey = 1, //default province 北京
            cityKey = 36, //default city 北京
            distKey = 37, //default district 北京东城区
            distStartIndex = 0, //default 0
            cityStartIndex = 0, //default 0
            provStartIndex = 0; //default 0

        if (dataKey != "" && dataKey != undefined) {
            var sArr = dataKey.split("-");
            if (sArr.length == 3) {
                provKey = sArr[0];
                cityKey = sArr[1];
                distKey = sArr[2];

            } else if (sArr.length == 2) { //such as 台湾，香港 and the like.
                provKey = sArr[0];
                cityKey = sArr[1];
            }
            startCities = getAddrsArrayById(provKey);
            startDists = getAddrsArrayById(cityKey);
            provStartIndex = getStartIndexByKeyFromStartArr(PROVINCES, provKey);
            cityStartIndex = getStartIndexByKeyFromStartArr(startCities, cityKey);
            distStartIndex = getStartIndexByKeyFromStartArr(startDists, distKey);
        }
        var navArr = [{//3 scrollers, and the title and id will be as follows:
            title: "省",
            id: "scs_items_prov"
        }, {
            title: "市",
            id: "scs_items_city"
        }, {
            title: "区",
            id: "scs_items_dist"
        }];
        SCS.init({
            navArr: navArr,
            onOk: function(selectedKey, selectedValue) {
                $input.val(selectedValue).attr("data-key", selectedKey);
            }
        });
        var distScroller = new SCS.scrollCascadeSelect({
            el: "#" + navArr[2].id,
            dataArr: startDists,
            startIndex: distStartIndex
        });
        var cityScroller = new SCS.scrollCascadeSelect({
            el: "#" + navArr[1].id,
            dataArr: startCities,
            startIndex: cityStartIndex,
            onChange: function(selectedItem, selectedIndex) {
                distScroller.render(getAddrsArrayById(selectedItem.key), 0); //re-render distScroller when cityScroller change
            }
        });
        var provScroller = new SCS.scrollCascadeSelect({
            el: "#" + navArr[0].id,
            dataArr: PROVINCES,
            startIndex: provStartIndex,
            onChange: function(selectedItem, selectedIndex) { //re-render both cityScroller and distScroller when provScroller change
                cityScroller.render(getAddrsArrayById(selectedItem.key), 0);
                distScroller.render(getAddrsArrayById(cityScroller.getSelectedItem().key), 0);
            }
        });
    });
});
$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
//点击激活电站
function activePS() {
    $('.swich-bar2').css("background-image","url(/images/pm5_01_l.png)");
    $('#queryPS').addClass('text-45-b3').removeClass('text-45-white');
    $('#activePS').addClass('text-45-white').removeClass('text-45-b3');
    $('.body2-step1').hide();
    $('.body2-step2').hide();
    $('.body2-step3').hide();
    $('.body1-step1').show();
    $('.body1-step2').hide();
    $('.body2-step3 ul a').remove();
}
// 点击电站查询
function queryPS() {
    $('.swich-bar2').css("background-image","url(/images/pm5_01_r.png)");
    $('#queryPS').addClass('text-45-white').removeClass('text-45-b3');
    $('#activePS').addClass('text-45-b3').removeClass('text-45-white');
    $('.body2-step1').hide();
    $('.body2-step2').show();
    $('.body2-step3').hide();
    $('.body1-step1').hide();
    $('.body1-step2').hide();
    $('.body2-step3 ul a').remove();
}
//跳到激活电站第二步
$('#activePS1').click(function () {
    if ($('#input1').val().length<15){
        Toast('请输入正确的机箱编码', 2000);
        return;
    }
    if ($('#input2').val().length==0){
        Toast('请选择设备所在区域', 2000);
        return;
    }
    if ($('#input3').val().length==0){
        Toast('请输入设备所在街道', 2000);
        return;
    }
    if ($('#input4').val().length==0){
        Toast('请输入设备具体地址', 2000);
        return;
    }
    $('.body1-step1').hide();
    $('.body1-step2').show();
    changeVcode();
});
//回到激活电站第一步
$('#activePrevious').click(function () {
    $('.body1-step2').hide();
    $('.body1-step1').show();
});
//提交电站激活数据
function addPowerStation() {
    if ($('#input5').val().length==0){
        Toast('请输入电价成本', 2000);
        return;
    }
    if ($('#input6').val().length==0){
        Toast('请输入计费标准', 2000);
        return;
    }
    if ($('#input7').val().length<4){
        Toast('请输入完整验证码', 2000);
        return;
    }
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: 'POST',
        url: "/dealer/doUpdateEquipment",
        data: {"street":$('#input3').val(),"address":$('#input4').val(),"province":$('#input2').val().split(" ")[0],"city":$('#input2').val().split(" ")[1]
            ,"area":$('#input2').val().split(" ")[2],"charging_cost":$('#input5').val(),"charging_unit_min":$('#input6').val(),"equipment_id":$('#input1').val()
            ,"equipment_status":"1" ,"verifyCode":$('#input7').val()},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                $('#myNormalDialog').modal({backdrop: 'static', keyboard: false})
            }else {
                Toast(data.result);
            }
        },
    });
}

$('.dialog-single-button').click(function () {
    history.back(-1);
});

//电站查询
function querySingleEquipment() {
    if ($('#input8').val()==''&&$('#input9').val()==''&&$('#input10').val()==''){
        Toast("请输入至少一个查询条件");
        return;
    }
    var querydata = "";

    if ($('#input10').val()!=''){
        querydata = {"name":$('#input10').val()};
    }
    if ($('#input9').val()!=''){
        querydata = {"phone":$('#input9').val()};
    }
    if ($('#input8').val()!=''){
        querydata = {"equipment_id":$('#input8').val()};
    }
    $.ajax({
        type: 'GET',
        url: "/dealer/getEquipmentInfo",
        data: querydata,
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                var arry = data.result;
                if (arry.length==0){
                    $('.body2-step1').show();
                    $('.body2-step2').hide();
                    $('.body2-step3').hide();
                    $('.body1-step1').hide();
                    $('.body1-step2').hide();
                }else {
                    $('.body2-step1').hide();
                    $('.body2-step2').hide();
                    $('.body2-step3').show();
                    $('.body1-step1').hide();
                    $('.body1-step2').hide();
                    loaddealer(arry)
                }
            }else {
                Toast(data.result);
            }
        },
    });
}
function loaddealer(arry) {
    for (var i = 0; i <arry.length; i++) {
        var equipment = arry[i];
        var html = '';//遍历拼接html
        html += '<a href="../dealer/powerStationDetail?devid='+equipment.equipment_id+'">';
        html += '<li class="revenus-item">';
        html += '<div class="revenus-item-row" style="top: 1rem;">';
        html += '<span class="pull-left text-36">'+equipment.street+equipment.address+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:2.5rem;">';
        html += '<span class="pull-left mini-text">'+equipment.equipment_id+'</span>';
        html += ' <span class="pull-right mini-text">'+equipment.province+equipment.city+equipment.area+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:4rem;">';
        html += '<div class="pull-left"><span class="mini-text-red">'+equipment.use_port_num+'</span><span class="mini-text">/'+equipment.total_port+'</span></div>';
        if (equipment.net_status =="0"){
            html += ' <span class="pull-right mini-text">在线</span>';
        }else {
            html += '<span class="pull-right mini-text-red">离线</span>';
        }
        html += ' </div>';
        html += '<div class="item-line">';
        html += '<div class="line-dark"></div>';
        html += '</div>';
        html += '</li>';
        html += '</a>';
        $("#queryResult").append(html);

    }
}
//查询所有电站
function queryAllEquipment() {
    $.ajax({
        type: 'GET',
        url: "/dealer/getEquipmentInfoList",
        data: {"type":2},
        dataType: "json",
        success: function(data){
            if (data.errno==0){
                console.log(data)
                var arry = data.result
                if (arry.length==0){
                    $('.body2-step1').show();
                    $('.body2-step2').hide();
                    $('.body2-step3').hide();
                    $('.body1-step1').hide();
                    $('.body1-step2').hide();
                }else {
                    $('.body2-step1').hide();
                    $('.body2-step2').hide();
                    $('.body2-step3').show();
                    $('.body1-step1').hide();
                    $('.body1-step2').hide();
                    dealerLoader(arry);
                }
            }else {
                Toast(data.result);
            }
        },
    });
}

function dealerLoader(arry) {
    for (var i = 0; i <arry.length; i++) {
        var equipment = arry[i];
        var html = '';//遍历拼接html
        html += '<a href="../dealer/powerStationDetail?devid=869300034342473">';
        html += '<li class="revenus-item">';
        html += '<div class="revenus-item-row" style="top: 1rem;">';
        html += '<span class="pull-left text-36">'+equipment.street+equipment.address+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:2.5rem;">';
        html += '<span class="pull-left mini-text">'+equipment.equipment_id+'</span>';
        html += ' <span class="pull-right mini-text">'+equipment.province+equipment.city+equipment.area+'</span>';
        html += '</div>';
        html += ' <div class="revenus-item-row" style="top:4rem;">';
        html += '<div class="pull-left"><span class="mini-text-red">'+equipment.use_port_num+'</span><span class="mini-text">/'+equipment.total_port+'</span></div>';
        if (equipment.net_status =="0"){
            html += ' <span class="pull-right mini-text">在线</span>';
        }else {
            html += '<span class="pull-right mini-text-red">离线</span>';
        }
        html += ' </div>';
        html += '<div class="item-line">';
        html += '<div class="line-dark"></div>';
        html += '</div>';
        html += '</li>';
        html += '</a>';
        $("#queryResult").append(html);

    }
}

function backToQuery() {
    $('.body2-step1').hide();
    $('.body2-step2').show();
    $('.body2-step3').hide();
    $('.body1-step1').hide();
    $('.body1-step2').hide();
    $('.body2-step3 ul a').remove();
}
