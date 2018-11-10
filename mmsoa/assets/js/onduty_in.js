/**
 * 值班登记
 */

/**
 * 值班签到按钮点亮后，才允许提交
 */
$("#onduty").change(function() {
	var is_signin = document.getElementById("onduty");
	if (is_signin.checked) {
        $("#replaced_yes").iCheck('enable');
        $("#replaced_no").iCheck('enable');
        $('.chosen-select').prop('disabled', false).trigger("chosen:updated");
        $("#range_slider").attr("disabled", false);
        $("#submit_onduty").attr("disabled", false);
    } else {
        $("#replaced_yes").iCheck('enable');
        $("#replaced_no").iCheck('enable');
        $('.chosen-select').prop('disabled', true).trigger("chosen:updated");
		$("#range_slider").attr("disabled", true);
		$("#submit_onduty").attr("disabled", true);
	}
});

/**
 * 若为代班，显示原值班助理选择框
 */	
$("#replaced_yes").on('ifClicked', function(){
	$("#chosen_replaced").show(200).addClass("animated").addClass("fadeInLeft");
});

$("#replaced_no").on('ifClicked', function(){
	$("#chosen_replaced").hide(200);
});


var from = 0;
var to = 0;
	
var saveResult = function (data) {
    from = moment(data.from, "X").format("HH:mm");
    to = moment(data.to, "X").format("HH:mm");
};

$("#submit_onduty").click(function() {
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
		url: "Duty/ondutyRecord",
		data: {
			"time_from": from,
			"time_to": to,
			"is_replaced": is_replaced,
			"replaced_wid": replaced_wid,
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret["status"] === false) {
				$("#submit_result").attr("style", "color:#ED5565;text-align:center;").html(ret["msg"]);
			} else {
				$("#submit_result").attr("style", "color:#1AB394;text-align:center;").html(ret["msg"]);
				// 锁定所有按钮和输入框
				$("#replaced_yes").iCheck('disable');
				$("#replaced_no").iCheck('disable');
				$('.chosen-select').prop('disabled', true).trigger("chosen:updated");
				$("#range_slider").attr("disabled", true);
				$("#submit_onduty").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});
