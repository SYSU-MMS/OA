/**
 * 排班
 */

$("#submit_duty").click(function() {
	var MON1 = $("#select_MON1").val();
	var MON2 = $("#select_MON2").val();
	var MON3 = $("#select_MON3").val();
	var MON4 = $("#select_MON4").val();
	var MON5 = $("#select_MON5").val();
	var MON6 = $("#select_MON6").val();
	var TUE1 = $("#select_TUE1").val();
	var TUE2 = $("#select_TUE2").val();
	var TUE3 = $("#select_TUE3").val();
	var TUE4 = $("#select_TUE4").val();
	var TUE5 = $("#select_TUE5").val();
	var TUE6 = $("#select_TUE6").val();
	var WED1 = $("#select_WED1").val();
	var WED2 = $("#select_WED2").val();
	var WED3 = $("#select_WED3").val();
	var WED4 = $("#select_WED4").val();
	var WED5 = $("#select_WED5").val();
	var WED6 = $("#select_WED6").val();
	var THU1 = $("#select_THU1").val();
	var THU2 = $("#select_THU2").val();
	var THU3 = $("#select_THU3").val();
	var THU4 = $("#select_THU4").val();
	var THU5 = $("#select_THU5").val();
	var THU6 = $("#select_THU6").val();
	var FRI1 = $("#select_FRI1").val();
	var FRI2 = $("#select_FRI2").val();
	var FRI3 = $("#select_FRI3").val();
	var FRI4 = $("#select_FRI4").val();
	var FRI5 = $("#select_FRI5").val();
	var FRI6 = $("#select_FRI6").val();
	var SAT1 = $("#select_SAT1").val();
	var SAT2 = $("#select_SAT2").val();
	var SAT3 = $("#select_SAT3").val();
	var SUN1 = $("#select_SUN1").val();
	var SUN2 = $("#select_SUN2").val();
	var SUN3 = $("#select_SUN3").val();

	$.ajax({
		type: "POST",
		url: "dutyArrangeIn",
		data: {
			"MON1_list": MON1,
			"MON2_list": MON2,
			"MON3_list": MON3,
			"MON4_list": MON4,
			"MON5_list": MON5,
			"MON6_list": MON6,
			"TUE1_list": TUE1,
			"TUE2_list": TUE2,
			"TUE3_list": TUE3,
			"TUE4_list": TUE4,
			"TUE5_list": TUE5,
			"TUE6_list": TUE6,
			"WED1_list": WED1,
			"WED2_list": WED2,
			"WED3_list": WED3,
			"WED4_list": WED4,
			"WED5_list": WED5,
			"WED6_list": WED6,
			"THU1_list": THU1,
			"THU2_list": THU2,
			"THU3_list": THU3,
			"THU4_list": THU4,
			"THU5_list": THU5,
			"THU6_list": THU6,
			"FRI1_list": FRI1,
			"FRI2_list": FRI2,
			"FRI3_list": FRI3,
			"FRI4_list": FRI4,
			"FRI5_list": FRI5,
			"FRI6_list": FRI6,
			"SAT1_list": SAT1,
			"SAT2_list": SAT2,
			"SAT3_list": SAT3,
			"SUN1_list": SUN1,
			"SUN2_list": SUN2,
			"SUN3_list": SUN3
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
				$('.chosen-select').prop('disabled', true).trigger("chosen:updated");
				$("#submit_duty").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});


$('#submit_add_schedule').click(function () {
	var name = $('#name').val(),
		from = $('#dateFrom').val(),
		to = $('#dateTo').val(),
		description = $('#comment').val();


	$.ajax({
		type: "POST",
		url: "holidaySchedule",
		data: {
			"name": name,
			"from": from,
			"to": to,
			"description": description
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret["status"] === false) {
				alert('发布失败');
			} else {
				alert('发布成功');
			}
		},
		error: function(){
			alert(arguments[1]);
		}
	});

});

$.ajax({
    type: "GET",
    url: "latestHolidaySchedule",
    success: function(msg) {
        ret = JSON.parse(msg);
        if (ret["status"] === false) {
            alert('获取失败');
        } else {
            console.log(ret.data);
        }
    },
    error: function(){
        alert(arguments[1]);
    }
});

$("#submit_holiday_scheduel_duty").click(function() {

	var dataList = [];
	var holiday_selects = $('.holiday_schdule');
	for(var i = 0; i < holiday_selects.length; i++) {
		var id 		= holiday_selects[i].id,
			value 	= $(('#'+id)).val(); // 从holiday_selects直接取value会有bug

		if(value) {
			var time = id,
			 	wids = [];

			for(var wid = 0; wid < value.length; wid++)
				wids.push(parseInt(value[wid]));

			dataList.push({
				"timestamp" : time,
				"wids": wids
			});
		}
	}

	console.log(dataList);

	$.ajax({
		type: "POST",
		url: "publishHolidaySchedule",
		data: {
			"list": dataList
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret["status"] === false) {
				alert("error");
			} else {
				alert('发布成功')
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});
