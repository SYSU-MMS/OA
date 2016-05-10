/**
 * 周检签到、课室故障登记
 */

/**
 * 周检签到按钮点亮后，才允许填写输入框
 */
$("#week").change(function() {
	var is_signin = document.getElementById("week");
	if (is_signin.checked) {
		$("#week_0").attr("disabled", false);
		$("#week_1").attr("disabled", false);
		$("#week_2").attr("disabled", false);
		$("#lamp_0").attr("disabled", false);
		$("#lamp_1").attr("disabled", false);
		$("#lamp_2").attr("disabled", false);
		$("#submit_week").attr("disabled", false);
	} else {
		$("#week_0").attr("disabled", true);
		$("#week_1").attr("disabled", true);
		$("#week_2").attr("disabled", true);
		$("#lamp_0").attr("disabled", true);
		$("#lamp_1").attr("disabled", true);
		$("#lamp_2").attr("disabled", true);
		$("#submit_week").attr("disabled", true);
	}
})

/**
 * 周检情况提交
 */
$("#submit_week").click(function() {
	var room_count = 0;
	var desc_list = [];
	var lamp_count = 0;
	var lamp_list = [];
	
	if (document.getElementById("week_0")) {
		desc_list[room_count++] = $("#week_0").val();
	}
	if (document.getElementById("week_1")) {
		desc_list[room_count++] = $("#week_1").val();
	}
	if (document.getElementById("week_2")) {
		desc_list[room_count++] = $("#week_2").val();
	}
	
	if (document.getElementById("lamp_0")) {
		lamp_list[lamp_count++] = $("#lamp_0").val();
	}
	if (document.getElementById("lamp_1")) {
		lamp_list[lamp_count++] = $("#lamp_1").val();
	}
	if (document.getElementById("lamp_2")) {
		lamp_list[lamp_count++] = $("#lamp_2").val();
	}
	
	$.ajax({
		type: "POST", 
		url: "WeeklyCheck/weeklyCheck",
		data: {
			"cond_week": desc_list,
			"cond_lamp": lamp_list,
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret["status"] === false) {
				$("#submit_result").attr("style", "color:#ED5565;text-align:center;");
				$("#submit_result").html(ret["msg"]);
			} else {
				$("#submit_result").attr("style", "color:#1AB394;text-align:center;");
				$("#submit_result").html(ret["msg"]);
				// 锁定所有按钮和输入框
				$("#week").attr("disabled", true);
				$("#week_0").attr("disabled", true);
				$("#week_1").attr("disabled", true);
				$("#week_2").attr("disabled", true);
				$("#lamp_0").attr("disabled", true);
				$("#lamp_1").attr("disabled", true);
				$("#lamp_2").attr("disabled", true);
				$("#submit_week").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});