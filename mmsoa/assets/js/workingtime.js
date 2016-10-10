/**
 * 奖励工时弹框
 */
function rewardButton(widStr) {
	var wid = widStr.replace("reward_button_", "");
	$("#myModalLabelTitle").text("工时奖励");
	$("#modalBody").html(
		"<form id='inputTime' class='input-group input-group-sm'>" +
			"<div class='form-group'>" +
	        	"<div class='col-sm-7 col-sm-offset-2'>" +
	        		"<span id='timeAjustArea' class='input-group-btn'>" +
	        			"<input type='text' id='rewardTime_" + wid + "' name='rewardTime' class='form-control' placeholder='请输入要增加的工时数'/>" +
	        			"<button type='button' id='reward_" + wid + "' name='reward' class='btn btn-primary' onclick='toReward(this.id)'> 增加 </button>" +
	        		"</span>" +
	        	"</div>" +
	        "</div>" +
        "</form>"
	);
}

/**
 * 减少工时弹框
 * @param widStr
 */
function reduceButton(widStr){
	var wid = widStr.replace("reduce_button_", "");
	$("#myModalLabelTitle").text("工时减少");
	$("#modalBody").html(
		"<form id='inputTime' class='input-group input-group-sm'>" +
		"<div class='form-group'>" +
		"<div class='col-sm-7 col-sm-offset-2'>" +
		"<span id='timeAjustArea' class='input-group-btn'>" +
		"<input type='text' id='reduceTime_" + wid + "' name='reduceTime' class='form-control' placeholder='请输入要减少的工时数'/>" +
		"<button type='button' id='reduce_" + wid + "' name='reduce' class='btn btn-danger' onclick='toReduce(this.id)'> 扣除 </button>" +
		"</span>" +
		"</div>" +
		"</div>" +
		"</form>"
	);
}

/**
 * 扣除工时弹框
 */
function penaltyButton(widStr) {
	var wid = widStr.replace("penalty_button_", "");
	$("#myModalLabelTitle").text("工时扣除");
	$("#modalBody").html(
			"<form id='inputTime' class='input-group input-group-sm'>" +
				"<div class='form-group'>" +
		        	"<div class='col-sm-7 col-sm-offset-2'>" +
		        		"<span id='timeAjustArea' class='input-group-btn'>" +
		        			"<input type='text' id='penaltyTime_" + wid + "' name='penaltyTime' class='form-control' placeholder='请输入要扣除的工时数'/>" +
		        			"<button type='button' id='penalty_" + wid + "' name='penalty' class='btn btn-danger' onclick='toPenalty(this.id)'> 扣除 </button>" +
		        		"</span>" +
		        	"</div>" +
	        	"</div>" +
	        "</form>"
		);
}

/**
 * 奖励工时
 */
function toReward(widStr) {
	var wid = widStr.replace("reward_", "");
	var input_id = "#rewardTime_" + wid;
	var reward_time_num = $(input_id).val();
	$.ajax({
		type: 'post',
		url: 'rewardAndReduce',
		data: {
			"wid": wid,
			"time_num": reward_time_num,
		},
		success: function(msg){
			var ret=JSON.parse(msg);
			if (ret['status']===true) {
				var total_contri = parseInt($("#total_contri_" + wid).text());
				var total_salary = parseInt($("#total_salary_" + wid).text());
				var month_contri = parseInt($("#month_contri_" + wid).text());
				var month_salari = parseInt($("#month_salary_" + wid).text());
				total_contri += reward_time_num * 1;
				total_salary += reward_time_num * 12;
				month_contri += reward_time_num * 1;
				month_salari += reward_time_num * 12;
				$("#total_contri_" + wid).text(total_contri);
				$("#total_salary_" + wid).text(total_salary);
				$("#month_contri_" + wid).text(month_contri);
				$("#month_salary_" + wid).text(month_salari);
			}else{
				alert("更新失败!");
			}
		},
		error: function(){
			alert(arguments[1]);
		}
	});
}

/**
 * 减少工时
 * @param widStr
 */
function toReduce(widStr){
	var wid = widStr.replace("reduce_", "");
	var input_id = "#reduceTime_" + wid;
	var reduce_time_num = $(input_id).val();
	$.ajax({
		type: 'post',
		url: 'rewardAndReduce',
		data: {
			"wid": wid,
			"time_num": -reduce_time_num,
		},
		success: function(msg){
			var ret=JSON.parse(msg);
			if (ret['status']===true) {
				var total_contri = parseInt($("#total_contri_" + wid).text());
				var total_salary = parseInt($("#total_salary_" + wid).text());
				var month_contri = parseInt($("#month_contri_" + wid).text());
				var month_salari = parseInt($("#month_salary_" + wid).text());
				total_contri -= reduce_time_num * 1;
				total_salary -= reduce_time_num * 12;
				month_contri -= reduce_time_num * 1;
				month_salari -= reduce_time_num * 12;
				$("#total_contri_" + wid).text(total_contri);
				$("#total_salary_" + wid).text(total_salary);
				$("#month_contri_" + wid).text(month_contri);
				$("#month_salary_" + wid).text(month_salari);
			}else{
				alert("更新失败!");
			}
		},
		error: function(){
			alert(arguments[1]);
		}
	});
}

/**
 * 扣除工时
 */
function toPenalty(widStr) {
	var wid = widStr.replace("penalty_", "");
	var input_id = "#penaltyTime_" + wid;
	var reduce_time_num = $(input_id).val();
	$.ajax({
		type: 'post',
		url: 'penalty',
		data: {
			"wid": wid,
			"time_num": reduce_time_num,
		},
		success: function(msg){
			var ret=JSON.parse(msg);
			console.log(ret);
			if (ret['status']===true) {
				alert("扣除成功!");
			}else{
				alert("更新失败!");
			}
		},
		error: function(){
			alert(arguments[1]);
		}
	});
}
