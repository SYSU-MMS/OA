/**
 * Created by alcanderian on 22/11/2016.
 */
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

var show_table = function () {
    var time = $("#timestring").val();
    $.ajax({
        url: ("Sampling/getTable/" + time),
        success: function () {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var table_temp = "";
                for (var i = 0; i < ret['sample_table'].length; i++) {
                    table_temp+=
                        "<tr>" +
                            "<td>" +
                                (ret['sample_table'].length - i) +
                                "<a id='sid_" + i + "' style='display: none'>" + ret['sample_table'][i]["sid"] + "</a>" +
                            "</td>" +
                            "<td>" +
                                ret['sample_table'][i]['target_name'] +
                            "</td>" +


                            "<td><select class='form-control' id='time_point_" + i + "'>";
                    for(var j = 0; j < duty_list.length; ++j) {
                            table_temp +=
                                "<option value='" + j +"' ";
                            if(ret['sample_table'][i]['target_time_point'] == j) {
                                table_temp += "selected='selected'";
                            }
                            table_temp += ">" + duty_list[j] + "</option>"
                    }
                    table_temp+=
                            "</select></td>" +



                            "<td><select class='form-control' id='classroom_" + i + "'>";
                    for(var j = 0; j < ret['sample_table'][i]['classroom'].length; ++j) {
                            table_temp +=
                                "<option value='" + j +"' ";
                            if(ret['sample_table'][i]['classroom'][j] == ret['sample_table'][i]['target_room']) {
                                table_temp += "selected='selected'";
                            }
                            table_temp += ">" + ret['sample_table'][i]['classroom'][j] + "</option>"
                    }
                    table_temp+=
                            "</select></td>" +


                            "<td>" +
                            ret['sample_table'][i]['operator_name'] +
                            "</td>" +


                            "<td><select class='form-control' id='state_" + i + "'>";
                    for(var j = 0; j < score.length; ++j) {
                            table_temp +=
                                "<option value='" + j +"' ";
                            if(ret['sample_table'][i]['score'] == j) {
                                table_temp += "selected='selected'";
                            }
                            table_temp += ">" + score[j] + "</option>"
                    }
                    table_temp+=
                            "</select></td>" +

                            "<td><p id='problem_p_" + i + "' onclick='edit_text(" + i + ")'>" +
                                ret['sample_table'][i]['problem'] +
                                "</p><input type='text' style='display: none;' id='problem_edit_" + i +
                                "' value='" + ret['sample_table'][i]['problem'] + "'>" +
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

$(document).ready(show_table);