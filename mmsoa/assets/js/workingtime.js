/**
 * 奖励工时弹框
 */
function rewardButton(widStr) {
	var wid = widStr.replace("reward_button_", "");
	$("#myModalLabelTitle").text("工时奖励");
	$("#modalBody").html(
		"<form id='inputTime' class='input-group input-group-sm'>" +
			"<div class='form-group'>" +
	        	"<div class='col-sm-7 col-sm-offset-2'>" +
	        		"<span id='timeAjustArea' class='input-group-btn'>" +
	        			"<input type='text' id='rewardTime_" + wid + "' name='rewardTime' class='form-control' placeholder='请输入要奖励的工时数'>" +
	        			"<button type='button' id='reward_" + wid + "' name='reward' class='btn btn-primary' onclick='reward(this.id);'> 奖励 </button>" +
	        		"</span>" +
	        	"</div>" +
	        "</div>" +
        "</form>"
	);
    
	/* Validate */
	$("#inputTime").validate({
        rules: {
            rewardTime: {
                required: true,
                number: true
            }
        }
    });
}

/**
 * 扣除工时弹框
 */
function penaltyButton(widStr) {
	var wid = widStr.replace("penalty_button_", "");
	$("#myModalLabelTitle").text("工时扣除");
	$("#modalBody").html(
			"<form id='inputTime' class='input-group input-group-sm'>" +
				"<div class='form-group'>" +
		        	"<div class='col-sm-7 col-sm-offset-2'>" +
		        		"<span id='timeAjustArea' class='input-group-btn'>" +
		        			"<input type='text' id='penaltyTime_" + wid + "' name='penaltyTime' class='form-control' placeholder='请输入要扣除的工时数'>" +
		        			"<button type='button' id='penalty_" + wid + "' name='penalty' class='btn btn-danger' onclick='penalty(this.id);'> 扣除 </button>" +
		        		"</span>" +
		        	"</div>" +
	        	"</div>" +
	        "</form>"
		);
	
	/* Validate */
	$("#inputTime").validate({
        rules: {
        	penaltyTime: {
                required: true,
                number: true
            }
        }
    });
}

/**
 * 奖励工时
 */
function reward(widStr) {
	var wid = widStr.replace("reward_", "");
	var reward_time_num = this.siblings("input").val;
	alert(reward_time_num);
}

/**
 * 扣除工时
 */
function penalty(widStr) {
	var wid = widStr.replace("penalty_", "");
}
