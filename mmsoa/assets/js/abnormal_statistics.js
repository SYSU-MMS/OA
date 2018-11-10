/**
 * 管理异常助理
 */
var change_table = function(type){
	$.ajax({
		type: "POST", 
		url: "getAbnormalRank",
		data: {
			'type': type
		},
		success: function(msg) {
			//console.log(msg);
			$('#select_dealing').val(type);
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

				for (var i = 0; i < ret['data']['num']; i++) {
					// 各行数据
					var temp = 	"<tr>" + 
					    			"<td>" + (i + 1) +"</td>" + 
							    	"<td>" + ret['data']['name_list'][i] +"</td>" + 
							    	"<td>" + ret['data']['count_list'][i] +"</td>" + 
								"</tr>";
					w_data_arr.push(temp);
				}
				
				// 表格
				$('#table_container').empty().html(
					"<table class='table table-striped table-bordered table-hover users-dataTable'>" + 
	                    "<thead>" + 
	                        "<tr>" + 
	                        	"<th>序号</th>" + 
	                            "<th>姓名</th>" + 
	                            "<th>次数</th>" + 
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
};

var change = function() {
	var type = $('#select_dealing').val();
	change_table(type);
}

$(document).ready(function() {
	change_table(0);
});