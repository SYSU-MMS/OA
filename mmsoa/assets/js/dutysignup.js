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