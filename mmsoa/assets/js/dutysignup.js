/**
 * 值班报名js
 */

/**
 * ready function
 */
$(function() {
	// 模态窗口关闭后的动作
	$('#myModal').on('hidden.bs.modal', function() {
		$(".modal-body").html(
			'<h2 id="submit_result" style="text-align:center;">' +
				'<i class="fa fa-exclamation-circle exclamation-info">' +
					'<span class="exclamation-desc"> 记录清空后不可恢复，确定要清空吗？</span>' +
				'</i>' +
			'</h2>'
		);
		$(".modal-footer").html(
			'<div class="row">' +
        		'<div class="col-sm-6">' +
	            	'<button id="confirm_clean" type="button" class="btn btn-primary" onclick="clean()">确定</button>' +
        		'</div>' +
        		'<div class="col-sm-6">' +
        			'<button type="button" class="btn btn-danger cancelBtn" data-dismiss="modal">取消</button>' +
        		'</div>' +
        	'</div>'
		);
	});
 });

// 确定删除按钮
function clean() {
	$(".modal-body").html(
		'<h1 id="submit_result" style="text-align:center;"><i class="fa fa-spin fa-spinner"></i></h1>'
	);
	$.ajax({
		type: 'POST',
		url: 'DutySignUp/cleanSignUp',
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === true) {
				$("#submit_result").attr("style", "color:#1AB394;text-align:center;");
				$("#submit_result").html(ret["msg"]);
				$(".modal-footer").html(
					'<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>'
				);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
}

/**
 * 加载空闲时间的选择表
 * dayfrom: "2017-02-27 00:00:00",
 * dayto: "2017-04-14 00:00:00",
 * description: "test",
 * hsid: "1",
 * isvalid: "1",
 * name: "test"
*/

function loadHolidaySchedule(data) {
	var from 		= data.dayfrom,
		to   		= data.dayto,
		description = data.description,
		hsid 		= data.hsid,
		isvalid 	= data.isvalid,
		name 		= data.name;

	loadUserScheduleChoose();

	function loadUserScheduleChoose() {
		console.log('helo');

		$.ajax({
			type: 'GET',
			url: 'DutySignUp/userSchedule',
			success: function(msg) {
				ret = JSON.parse(msg);
				if (ret["status"] === false) {
					alert('获取用户时间表失败');
				} else {
					if(isvalid) {
						addDayChose(from, to);
						addUserChose(ret['data']);
						addSchduleBtnClick();
					} else {
						deleteHolidaySchedule();
					}
				}
			},
			error: function() {
				alert(arguments[1]);
			}

		});
	}

	/* 渲染日期的选择框 */
	function addDayChose(from, to) {
		var from 	= new Date(from),
		 	to 		= new Date(to),
			now		= from,
		 	from_to = getDaysBewteen(from, to);

		for(var i = 0; i <= from_to; i++) {
			var date = getDateString(now);
			var div = ''+
					  '<tr> '+
					  '	<th scope="row">'+ date +'</th> '+
					  '	<td><input id="'+ date +'" type="checkbox" name = "holidayScheduleBox" value = "'+ date +'" class="checkbox i-checks" /></td> '+
					  '</tr> ';
			$('#holiday-schedule-table').append(div);
			now.setDate(now.getDate()+1);
		}

		// 重新渲染选择框的样式
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
			checkedClass: 'checked'
		});
	}

	// 添加用户已经选择的按钮
	function addUserChose(data) {
		for(var i of data) {
			var timestamp = i.timestamp;
			$(('#'+timestamp)).iCheck('check');
		}
	}

	/* 添加点击事件，检查checkbox并发送数据 */
	function addSchduleBtnClick() {
		$('#submit_holiday_schedule').click(function() {

			var check_obj = document.getElementsByName('holidayScheduleBox');
			var chose_date = [];
			for(var i in check_obj) {
				if(check_obj[i].checked) { // 如果被选中
					chose_date.push(check_obj[i].value);
				}
			}

			if(chose_date.length == 0) {
				alert('未选择任何时间，请确认');
			} else {
				sendScheduleDate(chose_date);
			}
		});
	}

	/* 发送空闲时间给服务端 */
	function sendScheduleDate(dateList) {
		$.ajax({
			url: "DutySignUp/writeHolidaySchedule",
			type: "POST",
			data: {
				"date" : dateList,
				"hsid" : hsid
			},
			success: function(msg) {
				ret = JSON.parse(msg);
				if (ret["status"] === false) {
					alert('提交失败');
				} else {
					console.log(msg);
					alert('提交成功');
				}
			},
			error: function(){
				alert(arguments[1]);
			}
		});
	}

	/* 删除假期考试周空闲时间表 */
	function deleteHolidaySchedule() {
		$('#wrapper_holiday_schedule').remove();
	}
}

/* 工具函数：计算两个时间之间相差的天数 */
function getDaysBewteen(from, to) {
	var from 		= new Date(from),
		to 	 		= new Date(to),
	    from_time 	= from.getTime();
	    to_time 	= to.getTime();

	return (to_time - from_time) / (24 * 60 * 60 * 1000); // 除以一天的毫秒数
}

/* 工具函数：转成 YYYY-MM-DD 的时间格式 */
function getDateString(time) {

	function pad(number) {
	  if (number < 10) {
	    return '0' + number;
	  }
	  return number;
	}

	return time.getUTCFullYear() +
	'-' + pad(time.getUTCMonth() + 1) +
	'-' + pad(time.getUTCDate() );
}

/* 入口函数：获取空闲时间表 */
function getHolidaySchedule() {
	$.ajax({
		type: "GET",
		url: "DutyArrange/latestHolidaySchedule",
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret["status"] === false) {
				alert('获取失败');
			} else {
				var arr = ret.data;
				if(arr.length != 0)
					loadHolidaySchedule(arr[arr.length-1]);
			}
		},
		error: function(){
			alert(arguments[1]);
		}
	});
}

window.onload = function () {
	getHolidaySchedule();
}
