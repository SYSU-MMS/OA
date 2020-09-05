/**
 * 修改用户重要信息
 */



$("#submit_updateuser").click(function() {
	
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
	var update_weekly_ab = $("#select_weekly_ab").val();
	
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
			"week_classroom": update_weekly,
			"week_classroom_ab": update_weekly_ab
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