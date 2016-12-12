/**
 * Created by alcanderian on 22/11/2016.
 */
var table_tmp = [];
var duty_list = [
    "周一上午", "周一中午", "周一下午",
    "周二上午", "周二中午", "周二下午",
    "周三上午", "周三中午", "周三下午",
    "周四上午", "周四中午", "周四下午",
    "周五上午", "周五中午", "周五下午",

];

var score = [
    "未评分", "优秀", "良好", "一般", "差"
];

var table_len = 0;

var edit_text = function (i) {
    $("#problem_p_" + i).hide();

    $("#problem_edit_" + i).show();
};

var edit_fin = function (i) {
    $("#problem_edit_" + i).hide();
    var text = $("#problem_edit_" + i).val();
    if(text == "") {
        text = "暂无问题";
    }
    $("#problem_p_" + i).html(text);
    $("#problem_p_" + i).show();
};

var show_table = function () {
    var url = $("#baseurl").html() + "index.php/Sampling/getTable";
    console.log(url);
    $.ajax({
        url: url,
        type: 'post',
        data: {
            timestring: $("#timestring").html()
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var table_temp = "";
                table_len = ret['sample_table'].length;
                table_tmp = ret['sample_table'];
                for (var i = 0; i < ret['sample_table'].length; i++) {
                    table_temp +=
                        "<tr>" +
                        "<td>" +
                        (ret['sample_table'].length - i) +
                        "<a id='sid_" + i + "' style='display: none'>" + ret['sample_table'][i]["sid"] + "</a>" +
                        "</td>" +
                        "<td>" +
                        ret['sample_table'][i]['target_name'] +
                        "</td>" +


                        "<td><select class='form-control manager' id='time_point_" + i + "'>";
                    table_temp +=
                        "<option value='NULL'>未选择</option>";
                    for(var j = 0; j < duty_list.length; ++j) {
                        table_temp +=
                            "<option value='" + j +"' ";
                        if(ret['sample_table'][i]['target_time_point'] == j) {
                            table_temp += "selected='selected'";
                        }
                        table_temp += ">" + duty_list[j] + "</option>";
                    }
                    table_temp +=
                        "</select><div class='viewer'>";
                    if(ret['sample_table'][i]['target_time_point'] != undefined ) {
                        table_temp += duty_list[ret['sample_table'][i]['target_time_point']];
                    } else {
                        table_temp += "未选择";
                    }
                    table_temp +=
                        "</div></td>" +



                        "<td><select class='form-control manager' id='classroom_" + i + "'>";
                    table_temp +=
                        "<option value='NULL'>未选择</option>";
                    for(var j = 0; j < ret['sample_table'][i]['classroom'].length; ++j) {
                        table_temp +=
                            "<option value='" + ret['sample_table'][i]['classroom'][j] +"' ";
                        if(ret['sample_table'][i]['classroom'][j] == ret['sample_table'][i]['target_room']) {
                            table_temp += "selected='selected'";
                        }
                        table_temp += ">" + ret['sample_table'][i]['classroom'][j] + "</option>";
                    }
                    table_temp +=
                            "</select><div class='viewer'>";
                    if(ret['sample_table'][i]['target_room'] != undefined ) {
                        table_temp += ret['sample_table'][i]['target_room'];
                    } else {
                        table_temp += "未选择";
                    }
                    table_temp +=
                            "</div></td>" +


                        "<td>" +
                        ret['sample_table'][i]['operator_name'] +
                        "</td>" +


                        "<td><select class='form-control manager' id='state_" + i + "'>";
                    for(var j = 0; j < score.length; ++j) {
                        table_temp +=
                            "<option value='" + j +"' ";
                        if(ret['sample_table'][i]['state'] == j) {
                            table_temp += "selected='selected'";
                        }
                        table_temp += ">" + score[j] + "</option>";
                    }
                    table_temp +=
                        "</select><div class='viewer'>";
                    table_temp += score[ret['sample_table'][i]['state']];
                    table_temp +=
                        "</div></td>" +

                        "<td class='text-center' style='max-width: 25em;'><pre style='white-space:pre-wrap; background: none;border: none;font-family: \"open sans\", \"Helvetica Neue\", Helvetica, Arial, sans-serif' class='manager' id='problem_p_" + i + "' onclick='edit_text(" + i + ")'>";
                    if(ret['sample_table'][i]['problem'] == "") {
                        table_temp +="暂无问题"
                    } else {
                        table_temp +=ret['sample_table'][i]['problem'];
                    }
                    table_temp +=
                        "</pre><textarea class='form-control manager' onblur='edit_fin(" + i + ")' type='text' cols='40' rows='5' wrap='physical' style='display: none; word-break: break-all;' id='problem_edit_" + i +
                        "'>" + ret['sample_table'][i]['problem'] + "</textarea>" +
                        "<pre class='viewer' style='white-space:pre-wrap; background: none;border: none;font-family: \"open sans\", \"Helvetica Neue\", Helvetica, Arial, sans-serif'>";
                    if(ret['sample_table'][i]['problem'] == "") {
                        table_temp +="暂无问题"
                    } else {
                        table_temp +=ret['sample_table'][i]['problem'];
                    }
                    table_temp +=
                        "</pre>" +
                        "</td>" +

                        "</tr>"
                }
                $("#sample-list").html(table_temp);
            } else {
                alert(ret["msg"]);
            }
            $(".users-dataTable").dataTable({"aaSorting": [[ 0, "desc" ]], "paging": false});
        },
        error: function () {
            alert("error");
        }
    });
};

var post_table = function (num) {
    var search = $.trim($("#DataTables_Table_0_filter label input").val());
    if(search != "") {
        alert("请先清空查找条件");
        return;
    }
    if(num < table_len) {
        var sid = parseInt($("#sid_" + num).html());
        var ttp = $("#time_point_" + num + " option:selected").attr("value");
        var tr = $("#classroom_" + num + " option:selected").attr("value");
        if($("#classroom_" + num + " option:selected").attr("value") == "NULL") {
            tr = "NULL";
        }
        var st = $("#state_" + num + " option:selected").attr("value");
        var text = $.trim($("#problem_edit_" + num).val());

        console.log(num);
        console.log((ttp == "NULL" || ttp == table_tmp[num]['target_time_point']));
        console.log((tr == "NULL" || tr == table_tmp[num]['classroom']));
        console.log(st == table_tmp[num]['state']);
        console.log((text == table_tmp[num]['problem']));

        if((ttp == "NULL" || ttp == table_tmp[num]['target_time_point']) &&
            (tr == "NULL" || tr == table_tmp[num]['classroom']) &&
            st == table_tmp[num]['state'] &&
            (text == table_tmp[num]['problem'])) {
            post_table(num + 1);
        } else {
            console.log("post " + num);
            $.ajax({
                url: $("#baseurl").html() + "index.php/Sampling/upDateRecord",
                type: 'post',
                data: {
                    sid: sid,
                    target_time_point: ttp,
                    target_room: tr,
                    state: st,
                    problem: text
                },
                success: function (msg) {
                    ret = JSON.parse(msg);
                    if (ret['status'] != false) {
                        post_table(num + 1);
                    } else {
                        alert(ret['msg']);
                    }
                },
                error: function () {
                    alert("更改失败");
                }
            });
        }
    } else {
        alert("更改成功");
        location.reload();
    }
};

$(document).ready(show_table);