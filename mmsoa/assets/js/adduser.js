<<<<<<< HEAD
/**
 * 添加新用户
 */

// 若为普通用户，显示组别、常检课室、周检课室选择框
$("#select_level").change(function() {
	var chosen_level = $("#select_level").val();
	
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

$("#submit_adduser").click(function() {
	
	var add_username = $("#username").val();
	var add_password = $("#password").val();
	var add_confirm_password = $("#confirm_password").val();
	var add_name = $("#name").val();
	var add_level = $("#select_level").val();
	var add_indate = $("#indate").val();
	//var add_indate = new Date(Date.parse(str_indate.replace(/-/g, "/")));
	
	var add_group = null;
	var obj = document.getElementsByName("group_radio");
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			add_group = obj[i].value;
		}
	}

	var add_daily = $("#select_daily").val();
	var add_weekly = $("#select_weekly").val();
	
	$.ajax({
		type: "POST", 
		url: "addNewUser",
		data: {
			"username": add_username,
			"password": add_password,
			"confirm_password": add_confirm_password,
			"name": add_name,
			"level": add_level,
			"indate": add_indate,
			"group": add_group,
			"classroom": add_daily,
			"week_classroom": add_weekly,
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
=======
/**
 * 添加新用户
 */

// 若为普通用户，显示组别、常检课室、周检课室选择框
$("#select_level").change(function() {
	var chosen_level = $("#select_level").val();
	
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

$("#submit_adduser").click(function() {
	
	var add_username = $("#username").val();
	var add_password = $("#password").val();
	var add_confirm_password = $("#confirm_password").val();
	var add_name = $("#name").val();
	var add_level = $("#select_level").val();
	var add_indate = $("#indate").val();
	//var add_indate = new Date(Date.parse(str_indate.replace(/-/g, "/")));
	
	var add_group = null;
	var obj = document.getElementsByName("group_radio");
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			add_group = obj[i].value;
		}
	}

	var add_daily = $("#select_daily").val();
	var add_weekly = $("#select_weekly").val();
	
	$.ajax({
		type: "POST", 
		url: "addNewUser",
		data: {
			"username": add_username,
			"password": add_password,
			"confirm_password": add_confirm_password,
			"name": add_name,
			"level": add_level,
			"indate": add_indate,
			"group": add_group,
			"classroom": add_daily,
			"week_classroom": add_weekly,
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
>>>>>>> abnormal
});