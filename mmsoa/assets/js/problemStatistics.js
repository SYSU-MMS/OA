/**
 * 周检审查（查找历史周检记录）
 */

$('#search_btn').click(function(){
    var start_time = $('#start_dtp').val() + ":00";
	  var end_time = $('#end_dtp').val() + ":59";
    $.ajax({
        type: "POST",
        url: "getStatisticsByTime",
        data: {
          "start_time": start_time,
          "end_time": end_time,
        },
        success: function(msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === false) {
                alert(ret['msg']);
            } else {
                // 销毁原来的datatable
                $('.users-dataTable').dataTable({
                    "filter": false,
                    "destroy": true
                });



                var statistics_list = ret['data'];

                var view_statistics_list = [];

                statistics_list.forEach(function(item, index) {
                    var room = item.room;
                    var times = item.times + ''; /*转为字符串*/
                    if(times == "") {
                      times = "无故障";
                    }
                    // 各行数据
                    view_statistics_list.push(
                        "<tr>" +
                            "<td>" + (index + 1) +"</td>" +
                            "<td>" + room +"</td>" +
                            "<td>" + times +"</td>" +
                        "</tr>"
                    );

                });

                // 表格
                $('#table_container').empty().html(
                    "<table class='table table-striped table-bordered table-hover users-dataTable'>" +
                        "<thead>" +
                            "<tr>" +
                                "<th>序号</th>" +
                                "<th>课室</th>" +
                                "<th>故障发生次数</th>" +
                            "</tr>" +
                        "</thead>" +
                        "<tbody>" +
                            view_statistics_list.join("") +
                        "</tbody>" +
                    "</table>"
                );

                // 重新实例化datatable
                $('.users-dataTable').dataTable({
                    "iDisplayLength": 10,
                    "bProcessing": false
                });
            }
        },
        error: function(){
            alert(arguments[1]);
        }
    });
});
