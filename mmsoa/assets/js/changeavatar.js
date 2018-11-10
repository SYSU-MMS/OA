/**
 * 更换头像js
 */

/**
 * ready function
 */
$(function() {
	// 模态窗口关闭后的动作
	$('#avatar-modal').on('hidden.bs.modal', function() {
		var old_src = $("#nav-avatar").attr("src");
		var token_arr = old_src.split("/");
		var old_avatar_name = token_arr[token_arr.length - 1];
		
		// 获取最新头像
		$.ajax({
			type: 'POST',
			url: 'ChangeAvatar/getLastedAvatar',
			data: {
				'old_avatar_name': old_avatar_name,
			},
			success: function(msg) {
				ret = JSON.parse(msg);
				if (ret['status'] === true) {
					var new_token_arr = [];
					for (var i = 0; i < token_arr.length - 1; i++) {
						new_token_arr.push(token_arr[i]);
					}
					var new_src = new_token_arr.join("/") + "/sm_" + ret['imgSrc'];
					$("#nav-avatar").attr("src", new_src);
				}
			},
			error: function(){
			    alert(arguments[1]);
			}
		});
	});
 });