/**
 * 修改用户重要信息
 */

// 若为普通用户，显示组别、常检课室、周检课室选择框
$("#select_level").change(function() {
	var chosen_level = $("#select_level").val();
	alert($("#select_weekly").val());
	if (chosen_level == 0) {
		$("#radio_group").show(500);
        $("#chosen_daily").show(500);
        $("#chosen_weekly").show(500);
	} else {
		$("#radio_group").hide(500);
        $("#chosen_daily").hide(500);
        $("#chosen_weekly").hide(500);
	}
});

$("#submit_updateuser").click(function() {
	alert("fuck");
	$("#select_weekly").multipleSelect();
	
	var update_userid = $("#select_user").val();
	var update_username = $("#username").val();
	var update_password = $("#password").val();
	var update_confirm_password = $("#confirm_password").val();
	var update_level = $("#select_level").val();
	var update_indate = $("#indate").val();
	
	var update_group = null;
	var obj = document.getElementsByName("group_radio");
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			update_group = obj[i].value;
		}
	}

	var update_daily = $("#select_daily").val();
	var update_weekly = $("#select_weekly").val();
	
	$.ajax({
		type: "POST", 
		url: "updateUserInfo",
		data: {
			"userid": update_userid,
			"username": update_username,
			"password": update_password,
			"confirm_password": update_confirm_password,
			"level": update_level,
			"indate": update_indate,
			"group": update_group,
			"classroom": update_daily,
			"week_classroom": update_weekly
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret["status"] === false) {
				$("#submit_result").attr("style", "color:#ED5565;text-align:center;");
				$("#submit_result").html(ret["msg"]);
			} else {
				$("#submit_result").attr("style", "color:#1AB394;text-align:center;");
				$("#submit_result").html(ret["msg"]);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});