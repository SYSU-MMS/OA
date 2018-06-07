/**
 * Created by alcanderian on 21/11/2016.
 */


var link_time_stamp = function (timestamp) {
    var ret = timestamp.substr(0,4);
    ret += timestamp.substr(5,2);
    ret += timestamp.substr(8,2);
    ret += timestamp.substr(11,2);
    ret += timestamp.substr(14,2);
    ret += timestamp.substr(17,2);

    return ret;

};

var show_list = function () {
    var detailherf = "SamplingWeekly/showTable/";
    $.ajax({
        url: 'SamplingWeekly/getTableList',
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var table_temp = "";
                for (var i = 0; i < ret['sample_list'].length; i++) {
                    table_temp+=
                        "<tr>" +
                        "<td>" +
                        (ret['sample_list'].length - i) +
                        "</td>" +
                        "<td>" +
                        ret['sample_list'][i]['timestamp'] +
                        "</td>" +
                        "<td>" +
                        "<a href='" + detailherf + link_time_stamp(ret['sample_list'][i]['timestamp']) + "'>" +
                        ret['sample_list'][i]['title'] +
                        "</a>" +
                        "</td>" +
                        "<td>" +
                        "<a href='" + detailherf + link_time_stamp(ret['sample_list'][i]['timestamp']) + "'>" +
                        "<b class='manager'>查看/修改</b>" + "<b class='viewer'>查看</b>" + 
                        "</a>" +
                        "<button id='delete_" + link_time_stamp(ret['sample_list'][i]['timestamp']) +"' type='button' class='btn btn-xs btn-outline btn-danger manager' value='"+ret['sample_list'][i]['timestamp']+"' onclick='delete_table(this.value)' style='margin-left: 10px;'>" +
                        "<i class='fa fa-close'></i><span> 移除</span></button>" +
                        "</td>" +
                        "</tr>"
                }
                $("#sample-list").html(table_temp);
            }
            $(".users-dataTable").dataTable({"aaSorting": [[ 0, "desc" ]]});
        },
        error: function () {
            alert("error");
        }
    });
};

var delete_table = function (time) {
    console.log(time);
    if(time != undefined) {
        $.ajax({
            type: 'post',
            url: 'SamplingWeekly/deleteTable',
            data: {
                timestamp: time
            },
            success: function (msg) {
                ret = JSON.parse(msg);
                if (ret['status'] === true) {
                    alert(ret['msg']);
                    $(".users-dataTable").DataTable().row($("#delete_" + link_time_stamp(time)).parents('tr')).remove().draw();
                } else {
                    alert(ret['msg']);
                }
            },
            error: function () {
                alert("删除失败");
            }

        });
    }
};

var new_this_week_weekly = function () {
    $.ajax({
        type: 'post',
        url: 'SamplingWeekly/newTable',
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
            location.reload();
        },
        error: function () {
            alert(arguments[1]);
        }
    });
};

var new_last_week_weekly = function () {
    $.ajax({
        type: 'post',
        url: 'SamplingWeekly/newTable',
        data: {
          week: -1
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
            location.reload();
        },
        error: function () {
            alert(arguments[1]);
        }
    });
};

var new_n_week_weekly = function () {
    var n_week = $("#n_week option:selected").attr("value");
    $.ajax({
        type: 'post',
        url: 'SamplingWeekly/newTable',
        data: {
            week: n_week
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
            location.reload();
        },
        error: function () {
            alert(arguments[1]);
        }
    });
};

$(document).ready(show_list);