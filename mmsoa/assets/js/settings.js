/**
 * Created by alcanderian on 27/11/2016.
 */



var put_year = function () {
    var year = (new Date).getFullYear();
    for (var i = year - 3; i < year + 3; ++i) {
        $("#year_a").append("<option value='" + i + "'>" + i + "</option>");
        $("#year_b").append("<option value='" + i + "'>" + i + "</option>");
    }
};

var new_term = function () {
    var year_a = $("#year_a option:selected").attr("value");
    var year_b = $("#year_a option:selected").attr("value");

    var year = year_a + "-" + year_b;

    var term = $("#term option:selected").attr("value");

    var start = $("#start_dtp").attr("value") + " 00:00:00";
    var end = $("#end_dtp").attr("value") + " 23:59:59";

    $.ajax({
        type: 'post',
        url: 'Settings/newTerm',
        data: {
            schoolyear: year,
            schoolterm: term,
            termbeginstamp: start,
            termendstamp: end
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
        },
        error: function() {
            alert("新建学期失败，无法连接服务器")
        }
    });
};

var get_term_list = function () {
    $.ajax({
        type: 'post',
        url: 'Settings/getTermList',
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var list_tmp = "";
                for (var i = 0; i < ret['term_list'].length; i++) {
                    list_tmp +=
                        "<tr>" +
                            "<td>" +
                                i +
                            "</td>" +
                            "<td>" +
                                ret['term_list'][i]['schoolyear'] +
                            "</td>" +
                            "<td>" +
                                ret['term_list'][i]['schoolterm'] +
                            "</td>" +
                            "<td>" +
                                ret['term_list'][i]['termbeginstamp'] +
                            "</td>" +
                            "<td>" +
                                ret['term_list'][i]['termendstamp'] +
                            "</td>" +
                            "<td>" +
                                "<button type='button' class='btn btn-xs btn-outline btn-danger manager' value='" + ret['term_list'][i]['termid'] + "' onclick='delete_term(this.value)' style='margin-left: 10px;'>" +
                                "<i class='fa fa-close'></i><span> 移除</span></button>" +
                            "</td>" +
                        "</tr>"
                }
                $("#term-list").html(list_temp);
            } else {
                alert(ret['msg']);
            }
            $(".users-dataTable").dataTable({"aaSorting": [[ 0, "desc" ]]});
        },
        error: function() {
            alert("获取历史学期失败，无法连接服务器")
        }
    });
};

var delete_term = function (tid) {
    if(tid == undefined) {
        alert("删除学期失败");
        return;
    }
    $.ajax({
        type: 'post',
        url: 'Settings/deleteTerm',
        data: {
            termid: tid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
        },
        error: function() {
            alert("删除学期失败，无法连接服务器")
        }
    });
};