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

		$("#replaced_yes_morning").iCheck('enable');
		$("#replaced_no_morning").iCheck('enable');
		$('.chosen-morning').prop('disabled', false).trigger("chosen:updated");
	} else {
		$("#morning_0").attr("disabled", true);
		$("#morning_1").attr("disabled", true);
		$("#morning_2").attr("disabled", true);
		$("#morning_3").attr("disabled", true);
		$("#morning_4").attr("disabled", true);
		$("#morning_5").attr("disabled", true);
		$("#submit_morning").attr("disabled", true);

		$("#replaced_yes_morning").iCheck('disable');
		$("#replaced_no_morning").iCheck('disable');
		$('.chosen-morning').prop('disabled', true).trigger("chosen:updated");
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

		$("#replaced_yes_noon").iCheck('enable');
		$("#replaced_no_noon").iCheck('enable');
		$('.chosen-noon').prop('disabled', false).trigger("chosen:updated");
	} else {
		$("#noon_0").attr("disabled", true);
		$("#noon_1").attr("disabled", true);
		$("#noon_2").attr("disabled", true);
		$("#noon_3").attr("disabled", true);
		$("#noon_4").attr("disabled", true);
		$("#noon_5").attr("disabled", true);
		$("#submit_noon").attr("disabled", true);

		$("#replaced_yes_noon").iCheck('disable');
		$("#replaced_no_noon").iCheck('disable');
		$('.chosen-noon').prop('disabled', true).trigger("chosen:updated");
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


		$("#replaced_yes_evening").iCheck('enable');
		$("#replaced_no_evening").iCheck('enable');
		$('.chosen-evening').prop('disabled', false).trigger("chosen:updated");
	} else {
		$("#evening_0").attr("disabled", true);
		$("#evening_1").attr("disabled", true);
		$("#evening_2").attr("disabled", true);
		$("#evening_3").attr("disabled", true);
		$("#evening_4").attr("disabled", true);
		$("#evening_5").attr("disabled", true);
		$("#submit_evening").attr("disabled", true);


		$("#replaced_yes_evening").iCheck('disable');
		$("#replaced_no_evening").iCheck('disable');
		$('.chosen-evening').prop('disabled', true).trigger("chosen:updated");
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

	var is_replaced = null;
	var obj = document.getElementsByName("group_radio_morning");
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			is_replaced = obj[i].value;
		}
	}

	var replaced_wid = $("#select_replaced_morning").val();
	
	$.ajax({
		type: "POST", 
		url: "DailyCheck/dailyCheckMorning",
		data: {
			"cond_morning": desc_list,
			"is_replaced": is_replaced,
			"replaced_wid": replaced_wid
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

				$("#replaced_yes_morning").iCheck('disable');
				$("#replaced_no_morning").iCheck('disable');
				$('.chosen-morning').prop('disabled', true).trigger("chosen:updated");
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


	var is_replaced = null;
	var obj = document.getElementsByName("group_radio_noon");
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			is_replaced = obj[i].value;
		}
	}

	var replaced_wid = $("#select_replaced_noon").val();
	
	$.ajax({
		type: "POST", 
		url: "DailyCheck/dailyCheckNoon",
		data: {
			"cond_noon": desc_list,
			"is_replaced": is_replaced,
			"replaced_wid": replaced_wid
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

				$("#replaced_yes_noon").iCheck('disable');
				$("#replaced_no_noon").iCheck('disable');
				$('.chosen-noon').prop('disabled', true).trigger("chosen:updated");
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

	var is_replaced = null;
	var obj = document.getElementsByName("group_radio_evening");
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			is_replaced = obj[i].value;
		}
	}

	var replaced_wid = $("#select_replaced_evening").val();
	
	$.ajax({
		type: "POST", 
		url: "DailyCheck/dailyCheckEvening",
		data: {
			"cond_evening": desc_list,
			"is_replaced": is_replaced,
			"replaced_wid": replaced_wid
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


				$("#replaced_yes_evening").iCheck('disable');
				$("#replaced_no_evening").iCheck('disable');
				$('.chosen-evening').prop('disabled', true).trigger("chosen:updated");
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});

var set_room = function (wid, disable, daytime) {
	if(!wid || !daytime) {
		return;
	}

	var dis = " ";
	if(disable)
		dis = ' disabled="" ';

	$(".room-group-" + daytime).remove();
	$("#submit_" + daytime).attr("disabled", true);
	if(classroom[wid][0] != "") {
		$("#submit_" + daytime).attr("disabled", false);
		for (var i = 0; i < classroom[wid].length; i++) {
			$("#rooms_" + daytime).append(
				'<div class="form-group room-group-' + daytime + '">' +
					'<label class="col-sm-2 control-label">' + classroom[wid][i] + '</label>' +
					'<div class="col-sm-8">' +
						'<input type="text" name="cond_' + daytime + '_' + i + '" placeholder="正常"' + dis +
						' id="' + daytime + '_' + i + '" class="form-control">' +
					'</div>' +
				'</div>'
			);
		}
	}
};

/**
 * 若为代班，显示原值班助理选择框
 */
$("#replaced_yes_morning").on('ifClicked', function(){
	$("#chosen_replaced_morning").show(200).addClass("animated").addClass("fadeInLeft");
	$(".room-group-morning").remove();
	set_room(parseInt($("#select_replaced_morning").val()), 0, "morning");
});

$("#replaced_no_morning").on('ifClicked', function(){
	$("#chosen_replaced_morning").hide(200);
	$(".room-group-morning").remove();
	set_room(wid, 0, "morning");
});

$("#replaced_yes_noon").on('ifClicked', function(){
	$("#chosen_replaced_noon").show(200).addClass("animated").addClass("fadeInLeft");
	$(".room-group-noon").remove();
	set_room(parseInt($("#select_replaced_noon").val()), 0, "noon");
});

$("#replaced_no_noon").on('ifClicked', function(){
	$("#chosen_replaced_noon").hide(200);
	$(".room-group-noon").remove();
	set_room(wid, 0, "noon");
});

$("#replaced_yes_evening").on('ifClicked', function(){
	$("#chosen_replaced_evening").show(200).addClass("animated").addClass("fadeInLeft");
	$(".room-group-evening").remove();
	set_room(parseInt($("#select_replaced_evening").val()), 0, "evening");
});

$("#replaced_no_evening").on('ifClicked', function(){
	$("#chosen_replaced_evening").hide(200);
	$(".room-group-evening").remove();
	set_room(wid, 0, "evening");
});


$("#select_replaced_morning").change(function () {
	set_room(parseInt($("#select_replaced_morning").val()), 0, "morning");
});

$("#select_replaced_noon").change(function () {
	set_room(parseInt($("#select_replaced_noon").val()), 0, "noon");
});

$("#select_replaced_evening").change(function () {
	set_room(parseInt($("#select_replaced_evening").val()), 0, "evening");
});

$(document).ready(function () {
	set_room(wid, 1, "morning");
	set_room(wid, 1, "noon");
	set_room(wid, 1, "evening");
});