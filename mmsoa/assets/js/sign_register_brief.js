
function load_tables() {
    $.ajax({
        type: 'post',
        url: 'Sign/GetTables',
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var list_tmp = "";
                for (var i = 0; i < ret['table_list'].length; i++) {
                    list_tmp +=
                        "<tr>" +
                        "<td>" +
                        ret['table_list'][i]['signid'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['createtime'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['sign_start'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['sign_end'] +
                        "</td>" +
                        "<td>" +
                        ret['table_list'][i]['title'] +
                        "</td>" +
                        "<td>" +
                        + ret['table_list'][i]['is_signed'] + ' / ' + ret['table_list'][i]['sign_num'] +
                        "</td>" +
                        "<td>" +
                        "<a class='btn btn-xs btn-outline btn-primary' href='sign/Register/" + ret['table_list'][i]['signid'] + "' style='margin-left: 10px;'><span>签到</span></a>" +
                        "<a class='btn btn-xs btn-outline btn-primary' href='sign/Operate/" + ret['table_list'][i]['signid'] + "' style='margin-left: 10px;'><span>增添人员</span></a>" +
                        "<button type='button' class='btn btn-xs btn-outline btn-danger manager' value='" + ret['table_list'][i]['signid'] + "' onclick='delete_sign(this.value)' style='margin-left: 10px;'><i class='fa fa-close'></i><span> 移除</span></button>" +
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
    var start_point = $.trim($("#sign_start").val());
    var end_point = $.trim($("#sign_end").val());
    start_point += " " + $("#sign_start_0").val() + ":00";
    end_point += " " + $("#sign_end_0").val() + ":00";
    $.ajax({
        type: 'post',
        url: 'Sign/AddTable',
        data: {
            title: $.trim($("#table_title").val()),
            sign_num: $("#sign_num").val(),
            sign_start: start_point,
            sign_end: end_point,
            note: $("#sign_note").val()
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

function delete_sign(signid) {
    if(window.confirm('你确定要删除吗？')){
        $.ajax({
            type: 'post',
            url: 'Sign/DeleteSign',
            data: {
                signid: signid
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
    
}