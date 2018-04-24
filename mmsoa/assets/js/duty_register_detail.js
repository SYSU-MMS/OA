
function load_table(drid) {
    $.ajax({
        type: 'post',
        url: '../GetTableWithDetail',
        data: {
            drid: drid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                $('#table_title').html('<h5>' + ret['table']['title'] + ' —— 每个时段的报名限额：' + ret['table']['regmax'] +'</h5>');
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
                        for(var k = 0; k < ret['detail_list'][point].length; ++k )
                        {
                            table_tmp += ret['detail_list'][point][k] + '<br>'
                        }

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
