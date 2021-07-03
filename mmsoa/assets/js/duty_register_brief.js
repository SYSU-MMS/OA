var start_point_arr = ["", ""];
var end_point_arr = ["", ""];

function construct_duty_point_array() {
    var obj = $("#time_point_group");
    $(".time_point_item").remove();
    for (var i = 0; i < start_point_arr.length; ++i) {
        obj.append(
            '<div class="form-group time_point_item">' +
            '<label class="col-sm-2 control-label">' + (i === 0 ? '每天时段' : ' ') + '</label>' +
            '<div class="col-sm-3">' +
            '<input type="text" id="duty_start_' + i + '" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" />' +
            '</div>' +
            '<div class="col-sm-2 text-center">' +
            '<a class="form-control" style="border: hidden;">到</a>' +
            '</div>' +
            '<div class="col-sm-3">' +
            '<input type="text" id="duty_end_' + i + '" class="input-sm form-control dtp-input-div" name="end" placeholder="结束时间" />' +
            '</div>' +
            '<div class="col-sm-2 text-center">' +
            (i === 0 ? '<button class="btn btn-primary" onclick="append_tp();">添加</button>' : '<button class="btn btn-danger" onclick="remove_tp(' + i + ');">删除</button>') +
            '</div>' +
            '</div>');
        $("#duty_start_" + i).timepicker({"timeFormat": "H:i"}).val(start_point_arr[i]);
        $("#duty_end_" + i).timepicker({"timeFormat": "H:i"}).val(end_point_arr[i]);
    }
}

function append_tp() {
    for (var i = 0; i < start_point_arr.length; ++i) {
        start_point_arr[i] = $("#duty_start_" + i).val();
        end_point_arr[i] = $("#duty_end_" + i).val();
    }
    start_point_arr.splice(start_point_arr.length, 0, "");
    end_point_arr.splice(end_point_arr.length, 0, "");
    construct_duty_point_array();
}

function remove_tp(index) {
    start_point_arr.splice(index, 1);
    end_point_arr.splice(index, 1);
    construct_duty_point_array();
}

function load_tables() {
    $.ajax({
        type: 'post',
        url: 'DutyRegister/GetTables',
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var list_tmp = "";
                for (var i = 0; i < ret['table_list'].length; i++) {
                    list_tmp +=
                        "<tr>" +
                        "<td>" +
                        ret['table_list'][i]['drid'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['createtime'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['regstarttimestamp'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['regendtimestamp'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['title'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['regmax'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['regmaxperuser'] +
                        "</td>" +
                        "<td>" +
                        "<a class='btn btn-xs btn-outline btn-primary' href='DutyRegister/Register/" + ret['table_list'][i]['drid'] + "' style='margin-left: 10px;'><span>报名</span></a>" +
                        "<a class='btn btn-xs btn-outline btn-primary' href='DutyRegister/Detail/" + ret['table_list'][i]['drid'] + "' style='margin-left: 10px;'><span>报名情况</span></a>" +
                        "<button type='button' class='btn btn-xs btn-outline btn-danger manager' value='" + ret['table_list'][i]['drid'] + "' onclick='delete_table(this.value)' style='margin-left: 10px;'><i class='fa fa-close'></i><span> 移除</span></button>" +
                        "</td>" +
                        "</tr>"
                }
                $("#register-list").html(list_tmp);

            }

            $(".users-dataTable").dataTable({"aaSorting": [[ 0, "desc" ]]});
        },
        error: function() {
            alert("获取报名表列表，无法连接服务器");
        }
    });
}

function add_table() {
    var start_point = $("#duty_start_0").val();
    var end_point = $("#duty_end_0").val();
    for (var i = 1; i < start_point_arr.length; ++i) {
        start_point += "," + $("#duty_start_" + i).val();
        end_point += "," + $("#duty_end_" + i).val();
    }

    $.ajax({
        type: 'post',
        url: 'DutyRegister/AddTable',
        data: {
            title: $.trim($("#table_title").val()),
            reg_max: $("#reg_max").val(),
            reg_max_per_user: $("#reg_max_per_user").val(),
            register_start: $.trim($("#reg_start").val()) + " 23:59:59",
            register_stop: $.trim($("#reg_end").val()) + " 23:59:59",
            duty_start: start_point,
            duty_end: end_point,
            note: $("#reg_note").val()
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
            location.reload();
        },
        error: function() {
            alert("无法连接服务器");
        }
    });
}

function delete_table(drid) {
    $.ajax({
        type: 'post',
        url: 'DutyRegister/DeleteTable',
        data: {
            drid: drid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
            location.reload();
        },
        error: function() {
            alert("无法连接服务器");
        }
    });
}