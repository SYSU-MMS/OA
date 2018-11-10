<<<<<<< HEAD
/**
 * 查看用户列表
 */

// 设置id
function setId(uid) {
	var new_id = $("#confirm_delete").attr("id") + '_' + uid;
	$("#confirm_delete").attr("id", new_id);
}

// 确定删除按钮
function deleteUser(confirm_delete_id) {
	$("#modal-body").html(
		'<h1 id="submit_result" style="text-align:center;"><i class="fa fa-spin fa-spinner"></i></h1>'
	);
	var tokens = confirm_delete_id.split("_");
	var delete_uid = tokens[tokens.length - 1];
	$.ajax({
		type: 'POST',
		url: 'deleteUser',
		data: {
			'delete_uid': delete_uid,
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === true) {
				$("#submit_result").attr("style", "color:#1AB394;text-align:center;");
				$("#submit_result").html(ret["msg"]);
				$("#modal-footer").html(
					'<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>'
				);
				setTimeout(location.reload(), 1000);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
}

function showMore(evt){
  var obj = window.event?event.srcElement:evt.target;
  document.cookie = "index="+ obj.value;
=======
/**
 * 查看用户列表
 */

// 设置id
function setId(uid) {
	var new_id = $("#confirm_delete").attr("id") + '_' + uid;
	$("#confirm_delete").attr("id", new_id);
}

// 确定删除按钮
function deleteUser(confirm_delete_id) {
	$("#modal-body").html(
		'<h1 id="submit_result" style="text-align:center;"><i class="fa fa-spin fa-spinner"></i></h1>'
	);
	var tokens = confirm_delete_id.split("_");
	var delete_uid = tokens[tokens.length - 1];
	$.ajax({
		type: 'POST',
		url: 'deleteUser',
		data: {
			'delete_uid': delete_uid,
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === true) {
				$("#submit_result").attr("style", "color:#1AB394;text-align:center;");
				$("#submit_result").html(ret["msg"]);
				$("#modal-footer").html(
					'<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>'
				);
				setTimeout(location.reload(), 1000);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
}

function showMore(evt){
  var obj = window.event?event.srcElement:evt.target;
  document.cookie = "index="+ obj.value;
>>>>>>> abnormal
}