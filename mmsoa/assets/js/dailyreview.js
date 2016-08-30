/**
 * 常检审查（查找历史常检记录）
 */

$('#search_btn').click(function(){
	// 增加秒
	var start_time = $('#start_dtp').val() + ":00";
	var end_time = $('#end_dtp').val() + ":59";
	var roomid = $('#select_classroom').val();
	var wid = $('#select_name').val();
	
	$.ajax({
		type: "POST", 
		url: "historyDailyReview",
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
				
				// 装载新表数据-早检
				var m_data_arr = [];
				for (var i = 0; i < ret['m_count']; i++) {
					// 数据处理
					var m_room_list = ret['m_room_list'][i].replace(",", " ");
					var m_problem = ret['m_prob_list'][i];
					if (ret['m_prob_list'][i] == "") {
						m_problem = "正常";
					}
					
					// 各行数据
					m_data_arr.push([
					    "<tr>" + 
					    	"<td>" + (i + 1) +"</td>" + 
					    	"<td>" + ret['m_weekcount'] +"</td>" + 
					    	"<td>" + ret['m_weekday'] +"</td>" + 
					    	"<td>" + ret['m_name_list'][i] +"</td>" + 
					    	"<td>" + m_room_list +"</td>" + 
					    	"<td class='td-left'>" + m_problem +"</td>" + 
					    	"<td>" + ret['m_time_list'][i] +"</td>" + 
					    "</tr>"
					]);
				}
				
				// 表格
				$('#base').html(
					"<table class='table table-striped table-bordered table-hover users-dataTable'>" + 
	                    "<thead>" + 
	                        "<tr>" + 
	                        	"<th>序号</th>" + 
	                            "<th>周次</th>" + 
	                            "<th>星期</th>" + 
	                            "<th>姓名</th>" + 
	                            "<th>课室</th>" + 
	                            "<th>情况</th>" + 
	                            "<th>登记时间</th>" + 
	                        "</tr>" + 
	                    "</thead>" + 
	                    "<tbody>" + 
	                    	m_data_arr.join() + 
                        "</tbody>" + 
                    "</table>"
				);
				
				// 装载新表数据-午检
				var n_data_arr = [];
				for (var j = 0; j < ret['n_count']; j++) {
					// 数据处理
					var n_room_list = ret['n_room_list'][j].replace(",", " ");
					var n_problem = ret['n_prob_list'][j];
					if (ret['n_prob_list'][j] == "") {
						n_problem = "正常";
					}
					
					// 各行数据
					n_data_arr.push([
					    "<tr>" + 
					    	"<td>" + (j + 1) +"</td>" + 
					    	"<td>" + ret['n_weekcount'] +"</td>" + 
					    	"<td>" + ret['n_weekday'] +"</td>" + 
					    	"<td>" + ret['n_name_list'][j] +"</td>" + 
					    	"<td>" + n_room_list +"</td>" + 
					    	"<td class='td-left'>" + n_problem +"</td>" + 
					    	"<td>" + ret['n_time_list'][j] +"</td>" + 
					    "</tr>"
					]);
				}
				
				// 表格
				$('#integrated').html(
					"<table class='table table-striped table-bordered table-hover users-dataTable'>" + 
	                    "<thead>" + 
	                        "<tr>" + 
	                        	"<th>序号</th>" + 
	                            "<th>周次</th>" + 
	                            "<th>星期</th>" + 
	                            "<th>姓名</th>" + 
	                            "<th>课室</th>" + 
	                            "<th>情况</th>" + 
	                            "<th>登记时间</th>" + 
	                        "</tr>" + 
	                    "</thead>" + 
	                    "<tbody>" + 
	                    	n_data_arr.join() + 
                        "</tbody>" + 
                    "</table>"
				);
				
				// 装载新表数据-晚检
				var e_data_arr = [];
				for (var k = 0; k < ret['e_count']; k++) {
					// 数据处理
					var e_room_list = ret['e_room_list'][k].replace(",", " ");
					var e_problem = ret['e_prob_list'][k];
					if (ret['e_prob_list'][k] == "") {
						e_problem = "正常";
					}
					
					// 各行数据
					e_data_arr.push([
					    "<tr>" + 
					    	"<td>" + (k + 1) +"</td>" + 
					    	"<td>" + ret['e_weekcount'] +"</td>" + 
					    	"<td>" + ret['e_weekday'] +"</td>" + 
					    	"<td>" + ret['e_name_list'][k] +"</td>" + 
					    	"<td>" + e_room_list +"</td>" + 
					    	"<td class='td-left'>" + e_problem +"</td>" + 
					    	"<td>" + ret['e_time_list'][k] +"</td>" + 
					    "</tr>"
					]);
				}
				
				// 表格
				$('#expand').html(
					"<table class='table table-striped table-bordered table-hover users-dataTable'>" + 
	                    "<thead>" + 
	                        "<tr>" + 
	                        	"<th>序号</th>" + 
	                            "<th>周次</th>" + 
	                            "<th>星期</th>" + 
	                            "<th>姓名</th>" + 
	                            "<th>课室</th>" + 
	                            "<th>情况</th>" + 
	                            "<th>登记时间</th>" + 
	                        "</tr>" + 
	                    "</thead>" + 
	                    "<tbody>" + 
	                    	e_data_arr.join() + 
                        "</tbody>" + 
                    "</table>"
				);
				
				// 重新实例化datatable
				$('.users-dataTable').dataTable({
					"iDisplayLength": 25,
	        		"bProcessing": true
	            });
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});