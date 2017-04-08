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

		$("#replaced_yes").iCheck('enable');
		$("#replaced_no").iCheck('enable');
		$('.chosen-select').prop('disabled', false).trigger("chosen:updated");
	} else {
		$("#week_0").attr("disabled", true);
		$("#week_1").attr("disabled", true);
		$("#week_2").attr("disabled", true);
		$("#lamp_0").attr("disabled", true);
		$("#lamp_1").attr("disabled", true);
		$("#lamp_2").attr("disabled", true);
		$("#submit_week").attr("disabled", true);

		$("#replaced_yes").iCheck('disable');
		$("#replaced_no").iCheck('disable');
		$('.chosen-select').prop('disabled', true).trigger("chosen:updated");
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

	var is_replaced = null;
	var obj = document.getElementsByName("group_radio");
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			is_replaced = obj[i].value;
		}
	}

	var replaced_wid = $("#select_replaced").val();

	$.ajax({
		type: "POST", 
		url: "WeeklyCheck/weeklyCheck",
		data: {
			"cond_week": desc_list,
			"cond_lamp": lamp_list,
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
				$("#week").attr("disabled", true);
				$("#week_0").attr("disabled", true);
				$("#week_1").attr("disabled", true);
				$("#week_2").attr("disabled", true);
				$("#lamp_0").attr("disabled", true);
				$("#lamp_1").attr("disabled", true);
				$("#lamp_2").attr("disabled", true);
				$("#submit_week").attr("disabled", true);

                $("#replaced_yes").iCheck('disable');
                $("#replaced_no").iCheck('disable');
				$('.chosen-select').prop('disabled', true).trigger("chosen:updated");
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});


var set_room = function (wid, disable) {
	var dis = " ";
	if(disable)
		dis = ' disabled="" ';

	/*var submit_str =
		'<div class="hr-line-dashed room-group"></div>' +
		'<div class="form-group room-group">' +
		'<div class="col-sm-4 col-sm-offset-5">' +
		'<button id="submit_week" class="btn btn-primary"'+ dis +'type="submit"' +
		' data-toggle="modal" data-target="#myModal">提交</button>' +
		'</div>' +
		'</div>';*/

	$(".room-group").remove();
	$("#submit_week").attr("disabled", true);
	if(classroom[wid][0] != "") {
		$("#submit_week").attr("disabled", false);
		for (var i = 0; i < classroom[wid].length; i++) {
			$("#rooms").append(
				'<div class="form-group room-group">' +
				'<label class="col-sm-2 control-label">' + classroom[wid][i] + '</label>' +
				'<div class="col-sm-8">' +
				'<input type="text" name="cond_week_' + i + '" placeholder="正常"' + dis +
				' id="week_' + i + '" class="form-control">' +
				'</div>' +
				'</div>' +
				'<div class="form-group room-group">' +
				'<div class="col-sm-2 col-sm-offset-2" style="width:150px;">' +
				'<input type="number" name="cond_lamp_' + i + '" placeholder="投影仪灯时"' + dis +
				' id="lamp_' + i + '" class="form-control">' +
				'</div>' +
				'<h3><small>小时</small></h3>' +
				'</div>'
			);
		}
		//$("#week_form").append(submit_str);
	}
};


$("#replaced_yes").on('ifClicked', function(){
	$("#chosen_replaced").show(200).addClass("animated").addClass("fadeInLeft");
	$(".room-group").remove();
	set_room(parseInt($("#select_replaced").val()), 0);
});

$("#replaced_no").on('ifClicked', function(){
	$("#chosen_replaced").hide(200);
	$(".room-group").remove();
	set_room(wid, 0);
});

$("#select_replaced").change(function () {
	set_room(parseInt($("#select_replaced").val()), 0);
});

$(document).ready(function () {
	set_room(wid, 1);
});