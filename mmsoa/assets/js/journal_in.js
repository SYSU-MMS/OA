/**
 * 发布坐班日志
 */

var editors = [];

$(document).ready(function () {
	var name_list = ["morning", "noon", "evening", "best", "bad", "summary"];
    for(var i = 0; i < 6; i++) {
        editors[i] = window.CKEDITOR.replace('text_' + name_list[i]);
    }
});

$("#submit_journal").click(function() {
	var journal_group = null;
	var obj = document.getElementsByName("group_radio");
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			journal_group = obj[i].value;
		}
	}
	
	var report_list = [];
    for(var i = 0; i < 6; i++) {
        report_list[i] = editors[i].getData();
    }
	//var i = 0;

	//report_list[i++] = $("#text_morning").val();
	//report_list[i++] = $("#text_noon").val();
	//report_list[i++] = $("#text_evening").val();
	//report_list[i++] = $("#text_best").val();
	//report_list[i++] = $("#text_bad").val();
	//report_list[i++] = $("#text_summary").val();
	
	// 在文本首末分别添加字符串“<p>”和“</p>”,并将回车替换为“</p><p>”
	//for (var j = 0; j < 6; j++) {
	//	report_list[j] = report_list[j].replace(/\n/g, "</p><p>");
	//	report_list[j] = report_list[j].replace(/ /g, "&nbsp;");
	//	report_list[j] = "<p>" + report_list[j];
	//	report_list[j] += "</p>";
	//
	//}
	
	var best_list = $("#select_best").val();
	var bad_list = $("#select_bad").val();
	
	$.ajax({
		type: "POST", 
		url: "writeJournalIn",
		data: {
			"journal_body": report_list,
			"group": journal_group,
			"bestlist": best_list,
			"badlist": bad_list,
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
				$("#group_A").iCheck('disable');
				$("#group_B").iCheck('disable');
				$('.chosen-select').prop('disabled', true).trigger("chosen:updated");
                for(var i = 0; i < 6; i++) {
                    editors[i].setReadOnly(true);
                }

				//$("#text_morning").attr("disabled", true);
				//$("#text_noon").attr("disabled", true);
				//$("#text_evening").attr("disabled", true);
				//$("#text_best").attr("disabled", true);
				//$("#text_bad").attr("disabled", true);
				//$("#text_summary").attr("disabled", true);
				$("#submit_journal").attr("disabled", true);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});
