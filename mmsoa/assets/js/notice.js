/**
 * Created by alcanderian on 01/10/2016.
 */
/**
 * Created by alcanderian on 21/09/2016.
 */
var list_notice = function () {
    var notice_href = "Notify/readNotice";
    $.ajax({
        type: 'get',
        url: 'Notify/getNotice/0/1',
        data: {
            "base_date": "0",
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var table_temp = "";
                for (var i = 0; i < ret['notice_list'].length; i++) {
                    table_temp+=
                        "<tr>" +
                        "<td>" +
                        (ret['notice_list'].length - i) +
                        "</td>" +
                        "<td>" +
                        "<a href='" + notice_href + "?nid=" + ret['notice_list'][i]['nid'] + "' id='notice_id_" + ret['notice_list'][i]['nid'] + "'>" +
                        ret['notice_list'][i]['title'] +
                        "</a>" +
                        "</td>" +
                        "<td>" +
                        ret['notice_list'][i]['name'] +
                        "</td>" +
                        "<td>" +
                        ret['notice_list'][i]['splited_date']['year'] + "-" + ret['notice_list'][i]['splited_date']['month'] + "-" +
                        ret['notice_list'][i]['splited_date']['day'] +
                        "</td>" +
                        "<td>" +
                        "<a href='" + notice_href + "?nid=" + ret['notice_list'][i]['nid'] + "' id='notice_id_" + ret['notice_list'][i]['nid'] + "'>" +
                        "<b>详情</b>" +
                        "</a>" +
                        "<button id='delete_" + ret['notice_list'][i]['nid'] +"' type='button' class='btn btn-xs btn-outline btn-danger manager' onclick='delete_notice("+ ret['notice_list'][i]['nid'] +")' style='margin-left: 10px;'>" +
                        "<i class='fa fa-close'></i><span> 移除</span></button>" +
                        "</td>" +
                        "</tr>"
                }
                $("#notice-list").html(table_temp);
            }
            $(".users-dataTable").dataTable({"aaSorting": [[ 0, "desc" ]]});
        },
        error: function () {
            alert(arguments[1]);
        }

    });
};

var delete_notice = function (nid) {
    if(nid != undefined) {
        $.ajax({
            type: 'post',
            url: 'Notify/deleteNotice/',
            data: {
                "nid": nid || 0,
            },
            success: function (msg) {
                ret = JSON.parse(msg);
                if (ret['status'] === true) {
                    alert(ret['msg']);
                    $(".users-dataTable").DataTable().row($("#delete_" + nid).parents('tr')).remove().draw();
                }
            },
            error: function () {
                alert(arguments[1]);
            }

        });
    }
};

$(document).ready(list_notice);