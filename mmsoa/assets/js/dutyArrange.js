/**
 * 排班
 */
var arrange_list = {};
$("#submit_duty").click(function() {
	for(var i = 0; i < 5; ++i) {
        for (var j = 1; j <= weekday_len; ++j) {
            arrange_list[day_name[i] + j + "_list"] = $("#select_" + day_name[i] + j).val();

        }
    }
    for(i = 5; i < 7; ++i) {
        for (j = 1; j <= weekend_len; ++j) {
            arrange_list[day_name[i] + j + "_list"] = $("#select_" + day_name[i] + j).val();

        }
    }

	$.ajax({
		type: "POST",
		url: "dutyArrangeIn",
		data: {
			"arrange_list": arrange_list
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
            $("#submit_result").attr("style", "color:#ED5565;text-align:center;");
            $("#submit_result").html(arguments[1]);
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
