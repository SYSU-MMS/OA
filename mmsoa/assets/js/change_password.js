/**
 * 修改密码
 */
$("#submit_changepassword").click(function() {
	
	var pw_old = $("#password_old").val();
	var pw_new = $("#password_new").val();
	var pw_con = $("#confirm_password").val();
	
	$.ajax({
		type: "POST", 
		url: "ChangePassword/changePassword",
		data: {
			"password_old": pw_old,
			"password_new": pw_new,
			"confirm_password": pw_con,
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
				$("#password_old").attr("disabled", true);
				$("#password_new").attr("disabled", true);
				$("#confirm_password").attr("disabled", true);
				$("#submit_changepassword").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});