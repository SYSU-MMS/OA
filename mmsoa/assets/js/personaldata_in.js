<<<<<<< HEAD
/**
 * 个人信息更新
 */

$("#submit_personaldata").click(function() {
	
	var phone = $("#pd_phone").val();
	var shortphone = $("#pd_shortphone").val();
	var qq = $("#pd_qq").val();
	var wechat = $("#pd_wechat").val();
	var studentid = $("#pd_studentid").val();
	var school = $("#pd_school").val();
	var address = $("#pd_address").val();
	var creditcard = $("#pd_creditcard").val();
	var sex = document.getElementById("sex_girl").checked ? 1 : 0;

	$.ajax({
		type: "POST", 
		url: "PersonalData/personalDataUpdate",
		data: {
			"pd_phone": phone,
			"pd_shortphone": shortphone,
			"pd_qq": qq,
			"pd_wechat": wechat,
			"pd_studentid": studentid,
			"pd_school": school,
			"pd_address": address,
			"pd_creditcard": creditcard,
            "pd_sex": sex,
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
				$("#pd_phone").attr("disabled", true);
				$("#pd_shortphone").attr("disabled", true);
                $("#pd_sex").attr("disabled", true);
				$("#pd_qq").attr("disabled", true);
				$("#pd_wechat").attr("disabled", true);
				$("#pd_studentid").attr("disabled", true);
				$("#pd_school").attr("disabled", true);
				$("#pd_address").attr("disabled", true);
				$("#pd_creditcard").attr("disabled", true);
				$("#submit_personaldata").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
=======
/**
 * 个人信息更新
 */

$("#submit_personaldata").click(function() {
	
	var phone = $("#pd_phone").val();
	var shortphone = $("#pd_shortphone").val();
	var qq = $("#pd_qq").val();
	var wechat = $("#pd_wechat").val();
	var studentid = $("#pd_studentid").val();
	var school = $("#pd_school").val();
	var address = $("#pd_address").val();
	var creditcard = $("#pd_creditcard").val();
	var sex = document.getElementById("sex_girl").checked ? 1 : 0;

	$.ajax({
		type: "POST", 
		url: "PersonalData/personalDataUpdate",
		data: {
			"pd_phone": phone,
			"pd_shortphone": shortphone,
			"pd_qq": qq,
			"pd_wechat": wechat,
			"pd_studentid": studentid,
			"pd_school": school,
			"pd_address": address,
			"pd_creditcard": creditcard,
            "pd_sex": sex,
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
				$("#pd_phone").attr("disabled", true);
				$("#pd_shortphone").attr("disabled", true);
                $("#pd_sex").attr("disabled", true);
				$("#pd_qq").attr("disabled", true);
				$("#pd_wechat").attr("disabled", true);
				$("#pd_studentid").attr("disabled", true);
				$("#pd_school").attr("disabled", true);
				$("#pd_address").attr("disabled", true);
				$("#pd_creditcard").attr("disabled", true);
				$("#submit_personaldata").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
>>>>>>> abnormal
});