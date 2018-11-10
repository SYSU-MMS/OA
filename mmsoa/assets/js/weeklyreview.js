/**
 * 周检审查（查找历史周检记录）
 */

$('#search_btn').click(function(){
	// 增加秒
	var start_time = $('#start_dtp').val() + ":00";
	var end_time = $('#end_dtp').val() + ":59";
	var roomid = $('#select_classroom').val();
	var wid = $('#select_name').val();
	
	$.ajax({
		type: "POST", 
		url: "historyweeklyReview",
		data: {
			"start_time": start_time,
			"end_time": end_time,
			"roomid": roomid,
			"actual_wid": wid
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
				
				// 装载新表数据-周检
				var w_data_arr = [];
				for (var i = 0; i < ret['data']['w_count']; i++) {
					// 数据处理
					var w_room_list = ret['data']['w_room_list'][i].replace(/,/g, " ");
					var w_problem = ret['data']['w_prob_list'][i];
					if (ret['data']['w_prob_list'][i] == "") {
						w_problem = "正常";
					}
					
					// 各行数据
					w_data_arr.push(
					    "<tr>" + 
					    	"<td>" + (i + 1) +"</td>" + 
					    	"<td>" + ret['data']['w_weekcount_list'][i] +"</td>" + 
					    	"<td>" + ret['data']['w_weekday_list'][i] +"</td>" + 
					    	"<td>" + ret['data']['w_name_list'][i] +"</td>" + 
					    	"<td>" + w_room_list +"</td>" + 
					    	"<td class='td-left'>" + w_problem +"</td>" + 
					    	"<td>" + ret['data']['w_lamp_list'][i] +"</td>" + 
					    	"<td>" + ret['data']['w_time_list'][i] +"</td>" + 
					    "</tr>"
					);
				}
				
				// 表格
				$('#table_container').empty().html(
					"<table class='table table-striped table-bordered table-hover users-dataTable'>" + 
	                    "<thead>" + 
	                        "<tr>" + 
	                        	"<th>序号</th>" + 
	                            "<th>周次</th>" + 
	                            "<th>星期</th>" + 
	                            "<th>姓名</th>" + 
	                            "<th>课室</th>" + 
	                            "<th>情况</th>" + 
	                            "<th>灯时</th>" + 
	                            "<th>登记时间</th>" + 
	                        "</tr>" + 
	                    "</thead>" + 
	                    "<tbody>" + 
	                    	w_data_arr.join("") + 
                        "</tbody>" + 
                    "</table>"
				);
				
				// 重新实例化datatable
				$('.users-dataTable').dataTable({
					"iDisplayLength": 25,
	        		"bProcessing": false
	            });
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});