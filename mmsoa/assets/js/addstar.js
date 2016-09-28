/**
 * 添加新名人
 */

$("#submit_addstar").click(function() {
	var update_userid = $("#select_user").val();
	var update_description = $("#description").val();
	$.ajax({
		type: "POST", 
		url: "addStarInfo",
		data: {
			"userid": update_userid,
			"description": update_description
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