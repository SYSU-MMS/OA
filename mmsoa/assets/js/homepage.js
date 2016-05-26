/**
 * 主页留言、评论、通知
 */

/**
 * ready function
 */
$(function() {
	// 页面加载时拉取10条留言与对应所有评论，0表示当前时间
	var now_date = "0";
	$("#more_posts").trigger("getPostComment", [now_date]);
	
	// 页面加载时拉取10则通知，0表示当前时间
	var now_date = "0";
	$("#more_notices").trigger("getNotice", [now_date]);
	
	// 模态窗口关闭后的动作
	$('#myModal').on('hidden.bs.modal', function() {
		$("#submit_result").hide();
		$("#input-post").show();
	});
	
 });

/**
 * 发送留言
 */
$("#post-btn").click(function() {
	$("#input-post").hide();
	$("#submit_result").show();
	
	var post_content = $("#new-post").val();
	
	// 在文本首末分别添加字符串“<p>”和“</p>”,并将回车替换为“</p><p>”
	post_content = post_content.replace(/\n/g, "</p><p>");
	post_content = post_content.replace(/ /g, "&nbsp;");
	post_content = "<p>" + post_content;
	post_content += "</p>";
		
	$.ajax({
		type: 'post',
		url: 'Homepage/addPost',
		data: {
			"post_content": post_content,
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === true) {
				$("#post-circle").prepend(
					"<div class='social-feed-separated' id='separated_" + ret['bpid'] + "'>" +
						"<div class='social-avatar'><a href=''><img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['avatar'] + "'></a></div>" +
						"<div class='social-feed-box'>" +
							"<div class='social-avatar'>" +
								"<a href='#'>" + ret['name'] + "</a>" +
							"</div>" +
							"<div class='social-body'>" +
								post_content +
								"<small class='text-muted'> " + ret['splited_date']['month'] + "月" + ret['splited_date']['day'] + "日 " +
								ret['splited_date']['hour'] + ":" + ret['splited_date']['minute'] + " </small>" +
							"</div>" +
							"<div class='social-footer'>" +
								"<div class='social-comment' id='write_comment_" + ret['bpid'] + "'>" +
									"<div class='media-body'>" +
										"<textarea id='comment_textarea_" + ret['bpid'] + "' class='form-control' placeholder='填写评论...'></textarea>" +
										"<div class='btn-group' style='margin-top: 4px;'>" +
											"<button id='comment_on_" + ret['bpid'] + "' class='comment-btn btn btn-primary btn-xs'><i class='fa fa-send-o'></i> 发送</button>" +
										"</div>" +
									"</div>" +
								"</div>" +
							"</div>" +
						"</div>" +
					"</div>"
				);
				$("#new-post").val("");
				$("#submit_result").attr("style", "color:#1AB394; text-align:center; margin-top: 14px;");
				$("#submit_result").html(ret["msg"]);
				scrollToTop();
			} else {
				$("#submit_result").attr("style", "color:#ED5565; text-align:center; margin-top: 14px;");
				$("#submit_result").html(ret["msg"]);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});

/**
 * 成功发送留言后，滚动至留言区顶部查看新留言
 */
var scrollToTop = function(){
    // $('#scroll-content').slimScroll({});
	document.getElementsByTagName('body')[0].scrollTop = 0;
}

/**
 * 发送评论
 */
$("body").on("click", ".comment-btn", function(){
	var btn_id = $(this)[0].id.split("_");
	var post_id = btn_id[btn_id.length - 1];
	var comment_content = $(this).parent().siblings("textarea").val();
	// 通过post_id确定评论属于哪条留言
	var write_comment_id_selector = "#write_comment_" + post_id;
	var comment_textarea_selector = "#comment_textarea_" + post_id;
		
	$.ajax({
		type: 'post',
		url: 'Homepage/addComment',
		data: {
			"comment_content": comment_content,
			"post_id": post_id,
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === true) {
				$(write_comment_id_selector).before(
					"<div class='social-comment'>" +
						"<a href='' class='pull-left'>" +
							"<img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['avatar'] + "'>" +
						"</a>" +
						"<div class='media-body'>" +
							"<a href='#'>" + ret['name'] + "</a>： " + comment_content + "<br/>" +
							"<small class='text-muted'> " + ret['splited_date']['month'] + "月" + ret['splited_date']['day'] + "日 " +
							ret['splited_date']['hour'] + ":" + ret['splited_date']['minute'] + "</small>" +
						"</div>" +
					"</div>"
				);
			}
			$(comment_textarea_selector).val("");
		}
		
	});
});

// 页面上显示的最后一条留言的发表时间
var last_post_date;

/**
 * 点击"更多"按钮触发getPostComment事件
 */
$("#more_posts").click(function() {
	$("#more_posts").trigger("getPostComment", [last_post_date]);
});

/**
 * 异步获取留言评论
 */
$("#more_posts").bind("getPostComment", function(event, base_date) {
	
	$.ajax({
		type: 'get',
		url: 'Homepage/getPostComment',
		data: {
			"base_date": base_date,
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === true) {
				// 每次最多获取10条留言
				for (var i = 0; i < ret['post_list'].length; i++) {
					$("#more-btn").before(
						"<div class='social-feed-separated' id='separated_" + ret['post_list'][i]['bpid'] + "'>" +
							"<div class='social-avatar'><a href=''><img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['post_list'][i]['avatar'] + "'></a></div>" +
							"<div class='social-feed-box'>" +
								"<div class='social-avatar'>" +
									"<a href='#'>" + ret['post_list'][i]['name'] + "</a>" +
								"</div>" +
								"<div class='social-body'>" +
									ret['post_list'][i]['body'] +
									"<small class='text-muted'> " + ret['post_list'][i]['splited_date']['month'] + "月" + ret['post_list'][i]['splited_date']['day'] + "日 " +
									ret['post_list'][i]['splited_date']['hour'] + ":" + ret['post_list'][i]['splited_date']['minute'] + " </small>" +
								"</div>" +
								"<div class='social-footer'>" +
									"<div class='social-comment' id='write_comment_" + ret['post_list'][i]['bpid'] + "'>" +
										"<div class='media-body'>" +
											"<textarea id='comment_textarea_" + ret['post_list'][i]['bpid'] + "' class='form-control' placeholder='填写评论...'></textarea>" +
											"<div class='btn-group' style='margin-top: 4px;'>" +
												"<button id='comment_on_" + ret['post_list'][i]['bpid'] + "' class='comment-btn btn btn-primary btn-xs'><i class='fa fa-send-o'></i> 发送</button>" +
											"</div>" +
										"</div>" +
									"</div>" +
								"</div>" +
							"</div>" +
						"</div>"
					);
					
					// 显示留言对应的所有评论
					if (ret['comment_list'][i] !== null) {
						var write_comment_id_selector = "#write_comment_" + ret['post_list'][i]['bpid'];
						for (var j = 0; j < ret['comment_list'][i].length; j++) {
							$(write_comment_id_selector).before(
								"<div class='social-comment'>" +
									"<a href='' class='pull-left'>" +
										"<img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['comment_list'][i][j]['avatar'] + "'>" +
									"</a>" +
									"<div class='media-body'>" +
										"<a href='#'>" + ret['comment_list'][i][j]['name'] + "</a>： " + ret['comment_list'][i][j]['body'] + "<br/>" +
										"<small class='text-muted'> " + ret['comment_list'][i][j]['splited_date']['month'] + "月" + ret['comment_list'][i][j]['splited_date']['day'] + "日 " +
										ret['comment_list'][i][j]['splited_date']['hour'] + ":" + ret['comment_list'][i][j]['splited_date']['minute'] + "</small>" +
									"</div>" +
								"</div>"
							);
						}
					}
				}
				// 更新最后一条留言的时间
				last_post_date = ret['post_list'][ret['post_list'].length - 1]['bptimestamp'];
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
		
	});
});


//页面上显示的最后一则通知的发布时间
var last_notice_date;

/**
 * 点击"更多"按钮触发getNotice事件
 */
$("#more_notices").click(function() {
	$("#more_notices").trigger("getNotice", [last_notice_date]);
});

/**
 * 异步获取通知
 */
$("#more_notices").bind("getNotice", function(event, base_date) {
	// 从编辑按钮获取site_url('Notify')，用于构造notice的href属性的值,等同于site_url('Notify/readNotice')
	var site_url = $("#site_url").attr("href");
	var notice_href = site_url + "/readNotice";
	
	$.ajax({
		type: 'get',
		url: 'Notify/getNotice',
		data: {
			"base_date": base_date,
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === true) {
				// 每次最多获取10条留言
				for (var i = 0; i < ret['notice_list'].length; i++) {
					$("#more-notices-btn").before(
						"<div class='feed-element' id='element_" + ret['notice_list'][i]['nid'] + "'>" +
	                        "<a href='#' class='pull-left'>" +
	                            "<img alt='image' class='img-circle' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['notice_list'][i]['avatar'] + "'>" +
	                        "</a>" +
	                        "<div class='media-body'>" +
	                        	"<a href='" + notice_href + "?nid=" + ret['notice_list'][i]['nid'] + "' id='notice_id_" + ret['notice_list'][i]['nid'] + "' class='btn-link'>" +
	                        		ret['notice_list'][i]['title'] +
	                        	"</a>" +
	                            "<br>" +
	                            "<small class='text-muted'>" + ret['notice_list'][i]['splited_date']['year'] + "-" + ret['notice_list'][i]['splited_date']['month'] + "-" +
	                            ret['notice_list'][i]['splited_date']['day'] + "</small>" +
	                        "</div>" +
	                    "</div>"
					);
				}
				// 更新最后一则通知的时间
				last_notice_date = ret['notice_list'][ret['notice_list'].length - 1]['timestamp'];
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
		
	});
});


