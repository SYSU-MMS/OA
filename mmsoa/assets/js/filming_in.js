/**
 * 拍摄登记
 */

/**
 * 拍摄签到按钮点亮后，才允许提交
 */
$("#filming").change(function() {
	var is_signin = document.getElementById("filming");
	if (is_signin.checked) {
		$("#range_slider").attr("disabled", false);
		$("#submit_filming").attr("disabled", false);
	} else {
		$("#range_slider").attr("disabled", true);
		$("#submit_filming").attr("disabled", true);
	}
})
