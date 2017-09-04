/**
 * 发布通知
 */

var editor;

$(document).ready(function () {
	$("#submit_notice").attr("disabled", true);
    var E = window.wangEditor;
    editor = new window.wangEditor('#text_content');
    editor.customConfig.menus = [
        'head',  // 标题
        'bold',  // 粗体
        'italic',  // 斜体
        'underline',  // 下划线
        'strikeThrough',  // 删除线
        'foreColor',  // 文字颜色
        'backColor',  // 背景颜色
        'link',  // 插入链接
        'list',  // 列表
        'justify',  // 对齐方式
        'quote',  // 引用
        'table',  // 表格
        'code',  // 插入代码
        'undo',  // 撤销
        'redo'  // 重复
    ];
    editor.create();
});

// 标题、正文不为空，才激活发布按钮
$('#text_title').bind('input propertychange', function() {
	var notice_title = $("#text_title").val();
	var notice_content = editor.txt.text();
	if ($.trim(notice_title) == "" || $.trim(notice_content) == "") {
		$("#submit_notice").attr("disabled", true);
	} else {
		$("#submit_notice").attr("disabled", false);
	}
});

$('#text_content').bind('input propertychange', function() {
	var notice_title = $("#text_title").val();
	var notice_content = editor.txt.text();
	if ($.trim(notice_title) == "" || $.trim(notice_content) == "") {
		$("#submit_notice").attr("disabled", true);
	} else {
		$("#submit_notice").attr("disabled", false);
	}
});

// 提交通知
$("#submit_notice").click(function() {
	var notice_title = $("#text_title").val();
	var notice_content = editor.txt.html();

	// 在文本首末分别添加字符串“<p>”和“</p>”,并将回车替换为“</p><p>”
	//notice_content = notice_content.replace(/\n/g, "</p><p>");
	//notice_content = notice_content.replace(/ /g, "&nbsp;");
	//notice_content = "<p>" + notice_content;
	//notice_content += "</p>";

	$.ajax({
		type: "POST",
		url: "writeNoticeIn",
		data: {
			"notice_title": notice_title,
			"notice_content": notice_content
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret["status"] === false) {
				$("#submit_result").attr("style", "color:#ED5565;text-align:center;");
				$("#submit_result").html(ret["msg"]);
			} else {
				$("#submit_result").attr("style", "color:#1AB394;text-align:center;");
				$("#submit_result").html(ret["msg"]);
				// 鎖定按鈕，清空輸入框
				$("#submit_notice").attr("disabled", true);
				$("#text_title").val('');
				$("#text_content").html('');
                editor.create();
			}
		},
		error: function(){
			alert(arguments[1]);
		}
	});
});