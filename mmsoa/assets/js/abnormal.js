/**
 * 管理异常助理
 */

var search = function(){
	// 增加秒
	var start_time = $('#start_dtp').val() + "00:00:00";
	var end_time = $('#end_dtp').val() + "23:59:59";
	var wid = $('#select_name').val();
	var dealing = $('#select_dealing').val();
	var dealer = $('#select_dealer').val();
	$.ajax({
		type: "POST", 
		url: "searchAbnormalRecords",
		data: {
			"start_time": start_time,
			"end_time": end_time,
			"actual_wid": wid,
			"dealing": dealing,
			"dealer": dealer
		},
		success: function(msg) {
			//console.log(msg);
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
				var add_btn1 = "<a data-toggle=\"modal\" data-target=\"#modal-new-table-check\" onclick=\"get_record_by_id(";
				var add_btn2 = "," + ret['level'] + ")\"><b>";
				var add_btn3 = "</b></a>";
				var delete_btn1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick=\"delete_by_id(";
				var delete_btn2 = ")\"><b>删除</b></a>";
				for (var i = 0; i < ret['data']['w_count']; i++) {
					// 各行数据
					var temp = 	"<tr>" + 
					    			"<td>" + (i + 1) +"</td>" + 
							    	"<td>" + ret['data']['w_day_list'][i] +"</td>" + 
							    	"<td>" + ret['data']['w_name_list'][i] +"</td>" + 
							    	"<td>" + ret['data']['w_problem_list'][i] +"</td>" + 
							    	"<td>" + ret['data']['w_dealing_list'][i] +"</td>" + 
							    	"<td>" + ret['data']['w_dealer_list'][i] +"</td>" + 
							    	"<td>" + ret['data']['w_comment_list'][i] +"</td>" +
							    	"<td>";
					var operate_btn = add_btn1 + ret['data']['w_id_list'][i] + add_btn2;
					if (ret['level'] >= 1) {
						operate_btn += "查看\\更改";
					}
					else {
						operate_btn += "查看";
					}
					operate_btn += add_btn3;
					if (ret['level'] >= 1) {
						operate_btn += delete_btn1;
						operate_btn += ret['data']['w_id_list'][i];
						operate_btn += delete_btn2;
					}
					temp += operate_btn;
					temp += "</td>" + "</tr>";
					w_data_arr.push(temp);
				}
				
				// 表格
				$('#table_container').empty().html(
					"<table class='table table-striped table-bordered table-hover users-dataTable'>" + 
	                    "<thead>" + 
	                        "<tr>" + 
	                        	"<th>序号</th>" + 
	                            "<th>时间</th>" + 
	                            "<th>姓名</th>" + 
	                            "<th>行为</th>" + 
	                            "<th>处理方法</th>" + 
	                            "<th>处理人</th>" + 
	                            "<th>备注</th>" +
	                            "<th>操作</th>" +
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

var delete_by_id = function(id) {
	//console.log("you click delete!");
	if (id == null) {
		alert("请选择正确的记录");
		return;
	}
	$.ajax({
		type: 'POST',
		url: "deleteAbnormalRecord",
		data: {
			'id': id
		},
		success: function(msg) {
			console.log(msg);
			alert(JSON.parse(msg)['msg'].toString());
			location.reload();
		},
		error: function() {
			alert(arguments[1]);
			location.reload();
		}
	});
}

var get_record_by_id = function(id, level) {
	if (id == null) {
		alert("请选择正确的记录");
		return;
	}
	$.ajax({
		type: 'POST',
		url: "getAbnormalRecord",
		data: {
			"id": id
		},
		success: function(msg) {
			//console.log(msg);
			ret = JSON.parse(msg);
			if (ret['status'] === false) {
				alert(ret['msg']);
			} else {
				if (level >= 1)
					$('#modal_header_check').text("查看，更改信息");
				else
					$('#modal_header_check').text("查看信息");
				$('#start_w_dtp_check').val(ret['data']['time']);
				if (level < 1) $('#start_w_dtp_check').attr("disabled", true);
				else $('#start_w_dtp_check').attr("disabled", false);

				$('#reg_assistant_check').val(ret['data']['wid'].toString());
				if (level < 1) $('#reg_assistant_check').attr("disabled", true);
				else $('#reg_assistant_check').attr("disabled", false);

				$('#reg_pro_check').val(ret['data']['problem'].toString());
				if (level < 1) $('#reg_pro_check').attr("disabled", true);
				else $('#reg_pro_check').attr("disabled", false);

				$('#reg_dealing_check').val(ret['data']['dealing'].toString());
				if (level < 1) $('#reg_dealing_check').attr("disabled", true);
				else $('#reg_dealing_check').attr("disabled", false);

				$('#reg_dealer_check').val(ret['data']['dealer'].toString());
				if (level < 1) $('#reg_dealer_check').attr("disabled", true);
				else $('#reg_dealer_check').attr("disabled", false);

				$('#reg_note_check').val(ret['data']['comment'].toString());
				if (level < 1) $('#reg_note_check').attr("disabled", true);
				else $('#reg_note_check').attr("disabled", false);

				if (level < 1) {
					$('#update_check').text('确定');
				}
				else {
					$('#update_check').text('更改');
					$('#update_check').attr("onclick", "update_record_by_id("+id.toString()+")");
				}
			}
		},
		error: function() {
			alert(arguments[1]);
		}
	});
}

var update_record_by_id = function(id) {
	//console.log("you click update!");
	if (id == null) {
		alert("请选择正确的记录");
		return;
	}
	// 增加秒
	var time = $('#start_w_dtp_check').val() + "00:00:00";
	var wid = $('#reg_assistant_check').val();
	var problem = $('#reg_pro_check').val();
	var dealing = $('#reg_dealing_check').val();
	var dealer = $('#reg_dealer_check').val();
	var comment = $('#reg_note_check').val();
	console.log(dealing);
	if (wid == -1 || problem == "" || dealing == -1 || dealer == -1) {
		alert("请检查选择和输入是否正确");
		return;
	}
	$.ajax({
		type: 'POST',
		url: "updateAbnormalRecord",
		data: {
			"id": id,
			"time": time,
			"actual_wid": wid,
			"problem": problem,
			"dealing": dealing,
			"dealer": dealer,
			"comment": comment
		},
		success: function(msg) {
			//console.log(msg);
			ret = JSON.parse(msg);
			if (ret['status'] == false) {
				alert(ret['msg']);
			}
			else 
				alert(ret['msg']);
			location.reload();
		},
		error: function() {
			alert(arguments[1]);
		}
	});
};

$(document).ready(search);

$('#search_btn').click(search);

$('#add').click(function() {
	// 增加秒
	var time = $('#start_w_dtp').val() + "00:00:00";
	var wid = $('#reg_assistant').val();
	var problem = $('#reg_pro').val();
	var dealing = $('#reg_dealing').val();
	var dealer = $('#reg_dealer').val();
	var comment = $('#reg_note').val();
	if (wid == -1 || problem == "" || dealing == -1 || dealer == -1) {
		alert("请检查选择和输入是否正确");
		return;
	}
	$.ajax({
		type: 'POST',
		url: "addAbnormalRecord",
		data: {
			"time": time,
			"actual_wid": wid,
			"problem": problem,
			"dealing": dealing,
			"dealer": dealer,
			"comment": comment
		},
		success: function(msg) {
			//console.log(msg);
			ret = JSON.parse(msg);
			if (ret['status'] == false) {
				alert(ret['msg']);
			}
			else alert(ret['msg']);
			location.reload();
		},
		error: function() {
			alert(arguments[1]);
			location.reload();
		}
	});
});

var clearConditions = function() {
	var now = new Date();
	var year, month, day;
	var weekago = new Date;
	weekago.setDate(weekago.getDate()-7);
	var year = now.getFullYear();
	var month = now.getMonth()+1;
	var day = now.getDate() ;
	var now_str = year + '-' + ( month < 10 ? ( '0' + month ) : month ) + '-' + ( day < 10 ? ( '0' + day ) : day);
	var year = weekago.getFullYear();
	var month = weekago.getMonth()+1;
	var day = weekago.getDate() ;
	var ago_str = year + '-' + ( month < 10 ? ( '0' + month ) : month ) + '-' + ( day < 10 ? ( '0' + day ) : day);
	$("#start_dtp").val(ago_str);
	$("#end_dtp").val(now_str);
	var ori = $("#select_name").val();
	$("#select_name").find("option[value='"+ ori.toString() +"']").attr("selected", false);
	$("#select_name").find("option[value='-1']").attr("selected", true);
	ori = $("#select_dealing").val();
	$("#select_dealing").find("option[value='"+ ori.toString() +"']").attr("selected", false);
	$("#select_dealing").find("option[value='-1']").attr("selected", true);
	ori = $("#select_dealer").val();
	$("#select_dealer").find("option[value='"+ ori.toString() +"']").attr("selected", false);
	$("#select_dealer").find("option[value='-1']").attr("selected", true);
	alert($("#select_dealer").val());
}