/**
 * 常检签到、课室故障登记
 */

/**
 * 早检签到按钮点亮后，才允许填写输入框
 */
$("#morning").change(function() {
	var is_signin = document.getElementById("morning");
	if (is_signin.checked) {
		$("#morning_0").attr("disabled", false);
		$("#morning_1").attr("disabled", false);
		$("#morning_2").attr("disabled", false);
		$("#morning_3").attr("disabled", false);
		$("#morning_4").attr("disabled", false);
		$("#morning_5").attr("disabled", false);
		$("#submit_morning").attr("disabled", false);
	} else {
		$("#morning_0").attr("disabled", true);
		$("#morning_1").attr("disabled", true);
		$("#morning_2").attr("disabled", true);
		$("#morning_3").attr("disabled", true);
		$("#morning_4").attr("disabled", true);
		$("#morning_5").attr("disabled", true);
		$("#submit_morning").attr("disabled", true);
	}
})

/**
 * 午检签到按钮点亮后，才允许填写输入框
 */
$("#noon").change(function() {
	var is_signin = document.getElementById("noon");
	if (is_signin.checked) {
		$("#noon_0").attr("disabled", false);
		$("#noon_1").attr("disabled", false);
		$("#noon_2").attr("disabled", false);
		$("#noon_3").attr("disabled", false);
		$("#noon_4").attr("disabled", false);
		$("#noon_5").attr("disabled", false);
		$("#submit_noon").attr("disabled", false);
	} else {
		$("#noon_0").attr("disabled", true);
		$("#noon_1").attr("disabled", true);
		$("#noon_2").attr("disabled", true);
		$("#noon_3").attr("disabled", true);
		$("#noon_4").attr("disabled", true);
		$("#noon_5").attr("disabled", true);
		$("#submit_noon").attr("disabled", true);
	}
})

/**
 * 晚检签到按钮点亮后，才允许填写输入框
 */
$("#evening").change(function() {
	var is_signin = document.getElementById("evening");
	if (is_signin.checked) {
		$("#evening_0").attr("disabled", false);
		$("#evening_1").attr("disabled", false);
		$("#evening_2").attr("disabled", false);
		$("#evening_3").attr("disabled", false);
		$("#evening_4").attr("disabled", false);
		$("#evening_5").attr("disabled", false);
		$("#submit_evening").attr("disabled", false);
	} else {
		$("#evening_0").attr("disabled", true);
		$("#evening_1").attr("disabled", true);
		$("#evening_2").attr("disabled", true);
		$("#evening_3").attr("disabled", true);
		$("#evening_4").attr("disabled", true);
		$("#evening_5").attr("disabled", true);
		$("#submit_evening").attr("disabled", true);
	}
})

/**
 * 早检情况提交
 */
$("#submit_morning").click(function() {
	var room_count = 0;
	var desc_list = [];
	
	if (document.getElementById("morning_0")) {
		desc_list[room_count++] = $("#morning_0").val();
	}
	if (document.getElementById("morning_1")) {
		desc_list[room_count++] = $("#morning_1").val();
	}
	if (document.getElementById("morning_2")) {
		desc_list[room_count++] = $("#morning_2").val();
	}
	if (document.getElementById("morning_3")) {
		desc_list[room_count++] = $("#morning_3").val();
	}
	if (document.getElementById("morning_4")) {
		desc_list[room_count++] = $("#morning_4").val();
	}
	if (document.getElementById("morning_5")) {
		desc_list[room_count++] = $("#morning_5").val();
	}
	
	$.ajax({
		type: "POST", 
		url: "DailyCheck/dailyCheckMorning",
		data: {
			"cond_morning": desc_list,
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
				$("#morning").attr("disabled", true);
				$("#morning_0").attr("disabled", true);
				$("#morning_1").attr("disabled", true);
				$("#morning_2").attr("disabled", true);
				$("#morning_3").attr("disabled", true);
				$("#morning_4").attr("disabled", true);
				$("#morning_5").attr("disabled", true);
				$("#submit_morning").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});

/**
 * 午检情况提交
 */
$("#submit_noon").click(function() {
	var room_count = 0;
	var desc_list = [];
	
	if (document.getElementById("noon_0")) {
		desc_list[room_count++] = $("#noon_0").val();
	}
	if (document.getElementById("noon_1")) {
		desc_list[room_count++] = $("#noon_1").val();
	}
	if (document.getElementById("noon_2")) {
		desc_list[room_count++] = $("#noon_2").val();
	}
	if (document.getElementById("noon_3")) {
		desc_list[room_count++] = $("#noon_3").val();
	}
	if (document.getElementById("noon_4")) {
		desc_list[room_count++] = $("#noon_4").val();
	}
	if (document.getElementById("noon_5")) {
		desc_list[room_count++] = $("#noon_5").val();
	}
	
	$.ajax({
		type: "POST", 
		url: "DailyCheck/dailyCheckNoon",
		data: {
			"cond_noon": desc_list,
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
				$("#noon").attr("disabled", true);
				$("#noon_0").attr("disabled", true);
				$("#noon_1").attr("disabled", true);
				$("#noon_2").attr("disabled", true);
				$("#noon_3").attr("disabled", true);
				$("#noon_4").attr("disabled", true);
				$("#noon_5").attr("disabled", true);
				$("#submit_noon").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});

/**
 * 晚检情况提交
 */
$("#submit_evening").click(function() {
	var room_count = 0;
	var desc_list = [];
	
	if (document.getElementById("evening_0")) {
		desc_list[room_count++] = $("#evening_0").val();
	}
	if (document.getElementById("evening_1")) {
		desc_list[room_count++] = $("#evening_1").val();
	}
	if (document.getElementById("evening_2")) {
		desc_list[room_count++] = $("#evening_2").val();
	}
	if (document.getElementById("evening_3")) {
		desc_list[room_count++] = $("#evening_3").val();
	}
	if (document.getElementById("evening_4")) {
		desc_list[room_count++] = $("#evening_4").val();
	}
	if (document.getElementById("evening_5")) {
		desc_list[room_count++] = $("#evening_5").val();
	}
	
	$.ajax({
		type: "POST", 
		url: "DailyCheck/dailyCheckEvening",
		data: {
			"cond_evening": desc_list,
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
				$("#evening").attr("disabled", true);
				$("#evening_0").attr("disabled", true);
				$("#evening_1").attr("disabled", true);
				$("#evening_2").attr("disabled", true);
				$("#evening_3").attr("disabled", true);
				$("#evening_4").attr("disabled", true);
				$("#evening_5").attr("disabled", true);
				$("#submit_evening").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});
