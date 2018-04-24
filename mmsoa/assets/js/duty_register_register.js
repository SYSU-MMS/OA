var drid = 0;

function load_table(drid) {
    $.ajax({
        type: 'post',
        url: '../GetDetailOfUser',
        data: {
            drid: drid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                $('#reg_note').html(ret['table']['note']);
                $('#table_title').html('<h5>' + ret['table']['title'] + ' —— 每个时段的报名限额：' + ret['table']['regmax'] +'，每人报名限额: '+ ret['table']['regmaxperuser']+'</h5>');
                var table_tmp = "";
                for(var i = 0; i < ret['table']['dutyperiod'].length; ++i) {
                    table_tmp += "<tr>" +
                        "<td>" +
                        ret['table']['dutyperiod'][i] +
                        "</td>";
                    for(var j = 0; j < 7; ++j)
                    {
                        table_tmp += "<td>";

                        var point = i + "," + j;
                        var state = ret['detail_list'][point];
                        var fa_icon = "";
                        var check_class = "";
                        var onclick = "";

                        if(state === 0)
                        {
                            check_class = "banned";
                            fa_icon ="fa-ban";
                        }

                        if(state === 1)
                        {
                            check_class = "can-be-canceled";
                            fa_icon = "fa-check-circle";
                            onclick = "unregister(\""+point+"\");";
                        }

                        if(state === 2)
                        {
                            check_class = "cannot-be-canceled";
                            fa_icon = "fa-check-circle";
                        }

                        if(state === 3)
                        {
                            check_class = "can-be-register";
                            fa_icon = "fa-check-circle";
                            onclick = "register(\""+point+"\");";
                        }

                        table_tmp += "<a onclick='"+onclick+"' class='btn btn-circle "+check_class+"'><i class='fa fa-2x "+fa_icon+"'></i></a>"
                        table_tmp += "</td>";
                    }
                    table_tmp += "</tr>";
                }
                $("#register-table").html(table_tmp);
            }
        },
        error: function () {
            alert("获取报名表，无法连接服务器");
        }
    });
}

function register(point) {
    console.log("reg "  + point);
    $.ajax({
        type: 'post',
        url: '../UserRegister',
        data: {
            drid: drid,
            point: point
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

function unregister(point) {
    console.log("unreg "  + point);
    $.ajax({
        type: 'post',
        url: '../UserUnregister',
        data: {
            drid: drid,
            point: point
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