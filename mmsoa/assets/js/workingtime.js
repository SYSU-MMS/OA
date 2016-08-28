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
	        			"<input type='text' id='rewardTime_" + wid + "' name='rewardTime' class='form-control' placeholder='请输入要奖励的工时数'/>" +
	        			"<button type='button' id='reward_" + wid + "' name='reward' class='btn btn-primary' onclick='toReward(this.id)'> 奖励 </button>" +
	        		"</span>" +
	        	"</div>" +
	        "</div>" +
        "</form>"
	);
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
		        			"<input type='text' id='penaltyTime_" + wid + "' name='penaltyTime' class='form-control' placeholder='请输入要扣除的工时数'/>" +
		        			"<button type='button' id='penalty_" + wid + "' name='penalty' class='btn btn-danger' onclick='toPenalty(this.id)'> 扣除 </button>" +
		        		"</span>" +
		        	"</div>" +
	        	"</div>" +
	        "</form>"
		);
}

/**
 * 奖励工时
 */
function toReward(widStr) {
	var wid = widStr.replace("reward_", "");
	var input_id = "#rewardTime_" + wid;
	var reward_time_num = $(input_id).val();

}

/**
 * 扣除工时
 */
function toPenalty(widStr) {
	var wid = widStr.replace("penalty_", "");
}
