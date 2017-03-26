/**
 * 主页留言、评论、通知
 */

/**
 * ready function
 */
$(function () {
    // 页面加载时拉取10条留言与对应所有评论，0表示当前时间
    var now_date = "0";
    $("#more_posts").trigger("getPostComment", [now_date]);

    // 页面加载时拉取10则通知，0表示当前时间
    var now_date = "0";
    $("#more_notices").trigger("getNotice", [now_date]);

    // 模态窗口关闭后的动作
    $('#myModal').on('hidden.bs.modal', function () {
        $("#submit_result").hide();
        $("#input-post").show();
    });

});

//记录每一个post已经显示的评论数量
var comment_count = new Array();

//替换 HTML 特殊字符
function htmlspecialchars(str) {
    var s = "";
    if (str.length == 0) return "";
    for   (var i=0; i<str.length; i++)
    {
        switch (str.substr(i,1))
        {
            case "<": s += "&lt;"; break;
            case ">": s += "&gt;"; break;
            case "&": s += "&amp;"; break;
            case " ":
                if(str.substr(i + 1, 1) == " "){
                    s += " &nbsp;";
                    i++;
                } else s += " ";
                break;
            case "\"": s += "&quot;"; break;
            case "\n": s += "<br>"; break;
            default: s += str.substr(i,1); break;
        }
    }
    return s;
}

/**
 * 删除回复
 * @param mbcid
 */
function deleteComment(mbcid) {
    if (confirm("您确定要删除这条回复吗?")) {
        $.ajax({
            type: 'post',
            url: 'Homepage/deleteComment/' + mbcid,
            data: {
                "mbcid": mbcid,
            },
            success: function (msg) {
                var ret = JSON.parse(msg);
                if (ret['status'] === true) {
                    $("#text_muted_" + mbcid).parent().parent().slideUp(200);
                    delay(200);
                    $("#text_muted_" + mbcid).parent().parent().remove();
                } else {
                    alert("删除失败");
                }
            },
            error: function () {
                alert("删除失败");
            }
        });
    }
}

/**
 * 删除留言
 * @param bpid
 */
function deletePost(bpid) {
    if (confirm("您确定要删除这条留言吗?")) {
        $.ajax({
            type: 'post',
            url: 'Homepage/deletePost/' + bpid,
            data: {
                "bpid": bpid,
            },
            success: function (msg) {
                var ret = JSON.parse(msg);
                if (ret['status'] === true) {
                    $("#separated_" + bpid).slideUp(400);
                    delay(400);
                    $("#separated_" + bpid).remove();
                } else {
                    alert("删除失败");
                }
            },
            error: function () {
                alert("删除失败");
            }
        });
    }
}

/**
 * 发送留言
 */
$("#post-btn").click(function () {
    $("#input-post").hide();
    $("#submit_result").show();

    var post_content = $("#new-post").val();
    if ($.trim(post_content) === "") {
        alert("内容不能为空");
        return;
    }

    // 在文本首末分别添加字符串“<p>”和“</p>”,并将回车替换为“</p><p>”
    //post_content = post_content.replace(/\n/g, "</p><p>");
    //post_content = post_content.replace(/ /g, "&nbsp;");
    //post_content = "<p>" + post_content;
    //post_content += "</p>";

    $.ajax({
        type: 'post',
        url: 'Homepage/addPost',
        data: {
            "post_content": post_content,
        },
        success: function (msg) {
            var ret = JSON.parse(msg);
            if (ret['status'] === true) {
                //console.log(ret['bpid']);
                var deletePostHTML = "<div class='delete-area'><small class='delete-area text-muted' id='delete_area_"+ret['bpid']+"'><a class='delete-post' onclick='deletePost("+ret['bpid']+")'>删除</a></small></div>";
                $("#post-circle").prepend(
                    "<div class='social-feed-separated' id='separated_" + ret['bpid'] + "'>" +
                    "  <div class='social-avatar'>" +
                    "    <a href=''><img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['avatar'] + "'></a>" +
                    "  </div>" +
                    "  <div class='social-feed-box'>" +
                    "    <div class='social-avatar'>" +
                    "      <a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + ret['myid'] + "'>" + ret['name'] + "</a>" +
                    "    </div>" +
                    "    <div class='social-body'><p>" + htmlspecialchars(post_content) + "</p>" +
                    "      <small class='text-muted'> " + ret['splited_date']['month'] + "月" + ret['splited_date']['day'] + "日 " + ret['splited_date']['hour'] + ":" + ret['splited_date']['minute'] + " </small>" + deletePostHTML +
                    "    </div>" +
                    "    <div class='social-footer'>" +
                    "      <div class='social-comment' id='write_comment_" + ret['bpid'] + "'>" +
                    "        <div class='media-body'>" +
                    "          <textarea id='comment_textarea_" + ret['bpid'] + "' class='form-control' placeholder='填写评论...'></textarea>" +
                    "          <div class='btn-group' style='margin-top: 4px; text-align:right;'>" +
                    "            <button id='comment_on_" + ret['bpid'] + "' class='comment-btn btn btn-primary btn-xs'><i class='fa fa-send-o'></i> 发送</button>" +
                    "          </div>" +
                    "        </div>" +
                    "      </div>" +
                    "    </div>" +
                    "  </div>" +
                    "</div>"
                );
                $("#new-post").val("");
                $("#submit_result").attr("style", "color:#1AB394; text-align:center; margin-top: 14px;");
                $("#submit_result").html(ret["msg"]);
                scrollToTop();
                //暂时以刷新页面来回避不能显示新留言的评论的bug
                //location.reload();
            } else {
                $("#submit_result").attr("style", "color:#ED5565; text-align:center; margin-top: 14px;");
                $("#submit_result").html(ret["msg"]);
            }
        },
        error: function () {
            alert(arguments[1]);
        }
    });
});

/**
 * 成功发送留言后，滚动至留言区顶部查看新留言
 */
var scrollToTop = function () {
    // $('#scroll-content').slimScroll({});
    document.getElementsByTagName('body')[0].scrollTop = 0;
}

/**
 * 显示回复区域
 * @param mbcid
 */
function showReplyToArea(mbcid) {
    if ($("#reply_to_area_" + mbcid).css("display") == "none") {
        $(".reply-to-area").slideUp(200);
        $("#reply_to_area_" + mbcid).slideDown(200);
        $("#reply_to_textarea_" + mbcid).focus();
    } else {
        $("#reply_to_area_" + mbcid).slideUp(200);
    }
}

/**
 * 回复某用户
 * @param uid
 */
function replyTo(uid, post_id, mbcid) {
    mbcid |= 0;
    //console.log("nothing",uid);
    var comment_textarea_selector = "#reply_to_textarea_" + mbcid;
    var comment_content = $(comment_textarea_selector).val();
    if ($.trim(comment_content) === "") {
        alert("内容不能为空");
        return;
    }
    var write_comment_id_selector = "#write_new_comment_" + post_id;
    $.ajax({
        type: 'post',
        url: 'Homepage/addComment',
        data: {
            "comment_content": comment_content,
            "post_id": post_id,
            "ruid": uid,
        },
        success: function (msg) {
            var ret = JSON.parse(msg);
            var reply_uid = ret['ruid'];
            var reply_user = ret['ruser'];
            //console.log(reply_uid,reply_user);
            var replyTo = "";
            if (reply_uid > 0) {
                replyTo = " 回复 <a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + reply_uid + "'>"
                    + reply_user + "</a>"
            }
            var deleteCommentHTML = "<div class='delete-area'><small class='delete-area text-muted' id='delete_comment_area_"+ret['mbcid']+"'><a class='delete-post' onclick='deleteComment("+ret['mbcid']+")'>删除</a></small></div>";
            if (ret['status'] === true) {
                $(write_comment_id_selector).after(
                    "<div class='social-comment social-comment-" + post_id + "' display='none'>" +
                    "<a href='' class='pull-left'>" +
                    "<img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['avatar'] + "'>" +
                    "</a>" +
                    "<div class='media-body reply-msg-area'>" +
                    "<a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + ret['myid'] + "'>" + ret['name'] + "</a>" + replyTo + "： " + htmlspecialchars(comment_content) + "<br/>" +
                    "<small class='text-muted' id='text_muted_" + ret['mbcid'] + "'> " +
                    ret['splited_date']['month'] + "月" + ret['splited_date']['day'] + "日 " +
                    ret['splited_date']['hour'] + ":" + ret['splited_date']['minute'] +
                    "<a href='javascript:void(0);' class='reply-to' id='reply_to_" + ret['mbcid'] + "'> 回复</a>" + deleteCommentHTML +
                    "</small>" +
                    "<div class='reply-to-area' id='reply_to_area_" + ret['mbcid'] + "'>" +
                    "<textarea id='reply_to_textarea_" + ret['mbcid'] + "' class='form-control reply-to-textarea' placeholder='回复 " + ret['name'] + "'></textarea>" +
                    "<button class='reply-to-btn btn btn-primary btn-xs' id='reply_to_btn_" + ret['mbcid'] + "' style='margin-top:6px;'><i class='fa fa-send-o'> 发送</i></button>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );
            }
            //给"回复"添加onclick属性
            $("#reply_to_" + ret['mbcid']).attr("onclick", "showReplyToArea(" + ret['mbcid'] + ")");
            //给回复的"发送"按钮添加onclick属性
            $("#reply_to_btn_" + ret['mbcid']).attr("onclick", "replyTo(" + ret['myid'] + "," + post_id + "," + ret['mbcid'] + ")");
            $(comment_textarea_selector).val("");
            //console.log(post_id);
            //console.log(comment_count[post_id]);
            comment_count[post_id]++;
            $("#text_muted_"+ret['mbcid']).parent().parent().slideDown(200);
            //console.log(comment_count[post_id]);
            //更新"更多"按钮的onclick属性
            $("#more_comment_btn_" + post_id).attr("onclick", "showAllComment(" + post_id + "," + comment_count[post_id] + ")");
            $("#no-comment-" + post_id).remove();
        }

    });
    $("#reply_to_area_" + mbcid).slideUp(200);
}

/**
 * 发送评论
 */
$("body").on("click", ".comment-btn", function () {
    var btn_id = $(this)[0].id.split("_");
    var post_id = btn_id[btn_id.length - 1];
    var comment_content = $(this).parent().siblings("textarea").val();
    //console.log(comment_content);
    if ($.trim(comment_content) === "") {
        alert("内容不能为空");
        return;
    }
    // 通过post_id确定评论属于哪条留言
    var write_comment_id_selector = "#write_new_comment_" + post_id;
    var comment_textarea_selector = "#comment_textarea_" + post_id;

    $.ajax({
        type: 'post',
        url: 'Homepage/addComment',
        data: {
            "comment_content": comment_content,
            "post_id": post_id,
        },
        success: function (msg) {
            //console.log(msg);
            var ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var reply_uid = ret['ruid'];
                var reply_user = ret['ruser'];
                //console.log(reply_uid,reply_user);
                var replyTo = "";
                if (reply_uid > 0) {
                    replyTo = " 回复 <a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + reply_uid + "'>"
                        + reply_user + "</a>"
                }
                var deleteCommentHTML = "<div class='delete-area'><small class='delete-area text-muted' id='delete_comment_area_"+ret['mbcid']+"'><a class='delete-post' onclick='deleteComment("+ret['mbcid']+")'>删除</a></small></div>";
                $(write_comment_id_selector).after(
                    "<div class='social-comment social-comment-" + post_id + "' display='none'>" +
                    "<a href='' class='pull-left'>" +
                    "<img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['avatar'] + "'>" +
                    "</a>" +
                    "<div class='media-body reply-msg-area'>" +
                    "<a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + ret['myid'] + "'>" + ret['name'] + "</a>" + replyTo + "： " + htmlspecialchars(comment_content) + "<br/>" +
                    "<small class='text-muted' id='text_muted_" + ret['mbcid'] + "'> " +
                    ret['splited_date']['month'] + "月" + ret['splited_date']['day'] + "日 " +
                    ret['splited_date']['hour'] + ":" + ret['splited_date']['minute'] +
                    "<a href='javascript:void(0);' class='reply-to' id='reply_to_" + ret['mbcid'] + "'> 回复</a>" +
                    "</small>" + deleteCommentHTML +
                    "<div class='reply-to-area' id='reply_to_area_" + ret['mbcid'] + "'>" +
                    "<textarea id='reply_to_textarea_" + ret['mbcid'] + "' class='form-control reply-to-textarea' placeholder='回复 " + ret['name'] + "'></textarea>" +
                    "<button class='reply-to-btn btn btn-primary btn-xs' id='reply_to_btn_" + ret['mbcid'] + "' style='margin-top:6px;'><i class='fa fa-send-o'> 发送</i></button>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );
            }
            //给"回复"添加onclick属性
            $("#reply_to_" + ret['mbcid']).attr("onclick", "showReplyToArea(" + ret['mbcid'] + ")");
            //给回复的"发送"按钮添加onclick属性
            $("#reply_to_btn_" + ret['mbcid']).attr("onclick", "replyTo(" + ret['myid'] + "," + post_id + "," + ret['mbcid'] + ")");
            $(comment_textarea_selector).val("");
            //console.log(post_id);
            //console.log(comment_count[post_id]);
            comment_count[post_id]++;
            $("#text_muted_"+ret['mbcid']).parent().parent().slideDown(200);
            //console.log(comment_count[post_id]);
            //更新"更多"按钮的onclick属性
            $("#more_comment_btn_" + post_id).attr("onclick", "showAllComment(" + post_id + "," + comment_count[post_id] + ")");
            $("#no-comment-" + post_id).remove();
        }

    });
});

// 页面上显示的最后一条留言的发表时间
var last_post_date;

//显示所有评论
function showAllComment(bpid, offset) {
    $.ajax({
        type: 'post',
        url: 'Homepage/getAllComment/' + bpid + "/" + offset,
        data: {
            "offset": offset,
            "bpid": bpid
        },
        success: function (msg) {
            //console.log(msg);
            var ret = JSON.parse(msg);
            if (ret['status'] === true) {
                if (ret['comment_list'][0] !== null) {
                    var write_comment_id_selector = "#write_comment_" + ret['post_list'][0]['bpid'];
                    for (var j = 0; j < ret['comment_list'][0].length; j++) {
                        //console.log(ret);
                        var reply_uid = ret['comment_list'][0][j]['ruid'];
                        var reply_user = ret['comment_list'][0][j]['ruser'];
                        var replyTo = "";
                        //console.log(reply_uid);
                        if (reply_uid > 0) {
                            replyTo = " 回复 <a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + reply_uid + "'>"
                                + reply_user + "</a>"
                            //console.log("replyToMore");
                        }
                        var deleteCommentHTML="";
                        if (ret['comment_list'][0][j]['deletable']===true){
                            deleteCommentHTML = "<div class='delete-area'><small class='delete-area text-muted' id='delete_comment_area_"+ret['comment_list'][0][j]['mbcid']+"'><a class='delete-post' onclick='deleteComment("+ret['comment_list'][0][j]['mbcid']+")'>删除</a></small></div>";
                        }
                        $(write_comment_id_selector).before(
                            "<div class='social-comment social-comment-" + ret['post_list'][0]['bpid'] + "'>" +
                            "<a href='' class='pull-left'>" +
                            "<img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['comment_list'][0][j]['avatar'] + "'>" +
                            "</a>" +
                            "<div class='media-body reply-msg-area'>" +
                            "<a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + ret['comment_list'][0][j]['myid'] + "'>"
                            + ret['comment_list'][0][j]['name'] + "</a>" + replyTo + "： " + ret['comment_list'][0][j]['body'] + "<br/>" +
                            "<small class='text-muted' id='text_muted_" + ret['comment_list'][0][j]['mbcid'] + "'> " +
                            ret['comment_list'][0][j]['splited_date']['month'] + "月" + ret['comment_list'][0][j]['splited_date']['day'] + "日 " +
                            ret['comment_list'][0][j]['splited_date']['hour'] + ":" + ret['comment_list'][0][j]['splited_date']['minute'] +
                            "<a href='javascript:void(0);' class='reply-to' id='reply_to_" + ret['comment_list'][0][j]['mbcid'] + "'> 回复</a>" +
                            "</small>" + deleteCommentHTML +
                            "<div class='reply-to-area' id='reply_to_area_" + ret['comment_list'][0][j]['mbcid'] + "'>" +
                            "<textarea id='reply_to_textarea_" + ret['comment_list'][0][j]['mbcid'] + "' class='form-control reply-to-textarea' placeholder='回复 " + ret['comment_list'][0][j]['name'] + "'></textarea>" +
                            "<button class='reply-to-btn btn btn-primary btn-xs' id='reply_to_btn_" + ret['comment_list'][0][j]['mbcid'] + "' style='margin-top:6px;'><i class='fa fa-send-o'> 发送</i></button>" +
                            "</div>" +
                            "</div>" +
                            "</div>"
                        );
                        //console.log(ret['post_list'][0]['bpid']);
                        //console.log(comment_count[ret['post_list'][0]['bpid']]);
                        //新增显示的评论时给计数器+1s
                        comment_count[ret['post_list'][0]['bpid']]++;
                        //console.log(comment_count[ret['post_list'][0]['bpid']]);
                        //给"回复"添加onclick属性
                        $("#reply_to_" + ret['comment_list'][0][j]['mbcid']).attr("onclick", "showReplyToArea(" + ret['comment_list'][0][j]['mbcid'] + ")");
                        //给回复的"发送"按钮添加onclick属性
                        $("#reply_to_btn_" + ret['comment_list'][0][j]['mbcid']).attr("onclick", "replyTo(" + ret['comment_list'][0][j]['myid'] + "," + ret['post_list'][0]['bpid'] + "," + ret['comment_list'][0][j]['mbcid'] + ")");
                    }
                    //移除按钮
                    $("#more_comment_btn_" + bpid).remove();
                } else {
                    $("#more_comment_btn_" + bpid).before("<span class='no-more-comment' id='no_more_comment_" + bpid + "'>没有更多评论</span>");
                    $("#more_comment_btn_" + bpid).remove();
                }
            }
        }
    });
}

/**
 * 点击"更多"按钮触发getPostComment事件
 */
$("#more_posts").click(function () {
    $("#more_posts").trigger("getPostComment", [last_post_date]);
});

/**
 * 异步获取留言评论
 */
var no_more = false;
$("#more_posts").bind("getPostComment", function (event, base_date, offset) {

    $.ajax({
        type: 'get',
        url: 'Homepage/getPostComment',
        data: {
            "base_date": base_date,
            "offset": offset || 0,
        },
        success: function (msg) {
            var ret = JSON.parse(msg);
            if (ret['status'] === true) {
                // 每次最多获取10条留言
                for (var i = 0; i < ret['post_list'].length; i++) {
                    //var onClick="onclick=\"showMoreComment("+ret['post_list'][i]['bpid']+","+comment_count[ret['post_list'][i]['bpid']]+")\"";
                    var deletePostHTML="";
                    console.log(ret['post_list'][i]['deletable']);
                    if (ret['post_list'][i]['deletable']===true){
                        deletePostHTML = "<div class='delete-area'><small class='delete-area text-muted' id='delete_area_"+ret['post_list'][i]['bpid']+"'><a class='delete-post' onclick='deletePost("+ret['post_list'][i]['bpid']+")'>删除</a></small></div>";
                        console.log(deletePostHTML);
                    }
                    $("#more-btn").before(
                        "<div class='social-feed-separated' id='separated_" + ret['post_list'][i]['bpid'] + "'>" +
                        "<div class='social-avatar'><a href=''><img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['post_list'][i]['avatar'] + "'></a></div>" +
                        "<div class='social-feed-box'>" +
                        "<div class='social-avatar'>" +
                        "<a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + ret['post_list'][i]['myid'] + "'>" + ret['post_list'][i]['name'] +
                        "</a>" +
                        "</div>" +
                        "<div class='social-body'>" +
                        ret['post_list'][i]['body'] +
                        "<small class='text-muted'> " + ret['post_list'][i]['splited_date']['month'] + "月" + ret['post_list'][i]['splited_date']['day'] + "日 " +
                        ret['post_list'][i]['splited_date']['hour'] + ":" + ret['post_list'][i]['splited_date']['minute'] + " </small>" + deletePostHTML +
                        "</div>" +
                        "<div class='social-footer'>" +
                        "<div class='social-comment" + "' id='write_new_comment_" + ret['post_list'][i]['bpid'] + "' style='text-align:right;'>" +
                        "<div class='media-body' style='margin-top: 4px;'>" +
                        "<textarea id='comment_textarea_" + ret['post_list'][i]['bpid'] + "' class='form-control' placeholder='填写评论...'></textarea>" +
                        "<div class='btn-group' style='margin-top: 4px;text-align:right;'>" +
                        "<button id='comment_on_" + ret['post_list'][i]['bpid'] + "' class='comment-btn btn btn-primary btn-xs'><i class='fa fa-send-o'></i> 发送</button>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "<div class='btn-group' id='write_comment_" + ret['post_list'][i]['bpid'] + "' style='padding-top: 6px;'>" +
                        //"<button class='more-comment-btn btn btn-primary btn-xs' id='more_comment_btn_" + ret['post_list'][i]['bpid'] + "'><i class='fa fa-ellipsis-h'></i> 更早</button>" +
                        //"<button class='refresh-comment-btn btn btn-primary btn-xs' id='refresh_comment_btn_"+ret['post_list'][i]['bpid']+"'><i class='fa fa-refresh'></i> 刷新</button>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                    );


                    //初始化留言评论计数器
                    if (comment_count[ret['post_list'][i]['bpid']] == undefined) {
                        comment_count[ret['post_list'][i]['bpid']] = 0;
                    }

                    // 显示留言对应的所有评论
                    if (ret['comment_list'][i] !== null) {
                        var write_comment_id_selector = "#write_comment_" + ret['post_list'][i]['bpid'];
                        //console.log(comment_count[ret['post_list'][i]['bpid']]);

                        for (var j = 0; j < ret['comment_list'][i].length; j++) {
                            var reply_uid = ret['comment_list'][i][j]['ruid'];
                            var reply_user = ret['comment_list'][i][j]['ruser'];
                            var replyTo = "";
                            if (reply_uid > 0) {
                                replyTo = " 回复 <a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + reply_uid + "'>"
                                    + reply_user + "</a>"
                            }
                            var deleteCommentHTML="";
                            if (ret['comment_list'][i][j]['deletable']===true){
                                deleteCommentHTML = "<div class='delete-area'><small class='delete-area text-muted' id='delete_comment_area_"+ret['comment_list'][i][j]['mbcid']+"'><a class='delete-post' onclick='deleteComment("+ret['comment_list'][i][j]['mbcid']+")'>删除</a></small></div>";
                            }
                            $(write_comment_id_selector).before(
                                "<div class='social-comment social-comment-" + ret['post_list'][i]['bpid'] + "'>" +
                                "<a href='' class='pull-left'>" +
                                "<img alt='image' src='" + ret['base_url'] + "upload/avatar/sm_" + ret['comment_list'][i][j]['avatar'] + "'>" +
                                "</a>" +
                                "<div class='media-body reply-msg-area'>" +
                                "<a href='" + ret['site_url'] + "/PersonalData/showOthersPersonalData/" + ret['comment_list'][i][j]['myid'] + "'>"
                                + ret['comment_list'][i][j]['name'] + "</a>" + replyTo + "： " + ret['comment_list'][i][j]['body'] + "<br/>" +
                                "<small class='text-muted' id='text_muted_" + ret['comment_list'][i][j]['mbcid'] + "'> " +
                                ret['comment_list'][i][j]['splited_date']['month'] + "月" + ret['comment_list'][i][j]['splited_date']['day'] + "日 " +
                                ret['comment_list'][i][j]['splited_date']['hour'] + ":" + ret['comment_list'][i][j]['splited_date']['minute'] +
                                "<a href='javascript:void(0);' class='reply-to' id='reply_to_" + ret['comment_list'][i][j]['mbcid'] + "'> 回复</a>" +
                                "</small>" + deleteCommentHTML +
                                "<div class='reply-to-area' id='reply_to_area_" + ret['comment_list'][i][j]['mbcid'] + "'>" +
                                "<textarea id='reply_to_textarea_" + ret['comment_list'][i][j]['mbcid'] + "' class='form-control reply-to-textarea' placeholder='回复 " + ret['comment_list'][i][j]['name'] + "'></textarea>" +
                                "<button class='reply-to-btn btn btn-primary btn-xs' id='reply_to_btn_" + ret['comment_list'][i][j]['mbcid'] + "' style='margin-top:6px;'><i class='fa fa-send-o'> 发送</i></button>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                            );
                            //每显示一条回复计数器+1s
                            comment_count[ret['post_list'][i]['bpid']]++;
                            //console.log(comment_count[ret['post_list'][i]['bpid']]);
                            //console.log(ret['comment_list'][i][j]);
                            //给"回复"添加onclick属性
                            $("#reply_to_" + ret['comment_list'][i][j]['mbcid']).attr("onclick", "showReplyToArea(" + ret['comment_list'][i][j]['mbcid'] + ")");
                            //给回复的"发送"按钮添加onclick属性
                            $("#reply_to_btn_" + ret['comment_list'][i][j]['mbcid']).attr("onclick", "replyTo(" + ret['comment_list'][i][j]['myid'] + "," + ret['post_list'][i]['bpid'] + "," + ret['comment_list'][i][j]['mbcid'] + ")");
                        }

                        //console.log("#more_comment_btn_"+ret['post_list'][i]['bpid']);
                        //console.log("showMoreComment("+ret['post_list'][i]['bpid']+","+
                        //	comment_count[ret['post_list'][i]['bpid']]+")");

                        //给"刷新"按钮添加onclick属性
                        //$("#refresh_comment_btn_"+ret['post_list'][i]['bpid']).attr("onclick","refreshComment("+ret['post_list'][i]['bpid']+")");
                        if (comment_count[ret['post_list'][i]['bpid']] >= 10) {
                            $("#write_comment_" + ret['post_list'][i]['bpid']).html("<button class='more-comment-btn btn btn-primary btn-xs' " +
                                "id='more_comment_btn_" + ret['post_list'][i]['bpid'] + "'><i class='fa fa-ellipsis-h'></i> 展开</button>");
                        }
                        //给"更多"按钮添加onclick属性
                        $("#more_comment_btn_" + ret['post_list'][i]['bpid']).attr("onclick", "showAllComment(" + ret['post_list'][i]['bpid'] + "," +
                            comment_count[ret['post_list'][i]['bpid']] + ")");

                    } else {
                        //console.log(ret['post_list'][i]['bpid'],comment_count[ret['post_list'][i]['bpid']]);
                        if (comment_count[ret['post_list'][i]['bpid']] == 0) {
                            $("#more_comment_btn_" + ret['post_list'][i]['bpid']).before("<span class='no-comment' id='no-comment-" + ret['post_list'][i]['bpid'] + "'>暂无评论</span>");
                            $("#more_comment_btn_" + ret['post_list'][i]['bpid']).remove();
                            //console.log("removed");
                        }
                    }

                }
                // 更新最后一条留言的时间
                last_post_date = ret['post_list'][ret['post_list'].length - 1]['bptimestamp'];
            } else {
                if (!no_more) {
                    $("#more-btn").before("<div class='social-feed-separated'>" +
                        "<div class='social-feed-box text-center'>" +
                        "<div class='social-body'><p>暂无更多</p>" +
                        "</div></div></div>");
                    $("#more-btn").css({"display": "none"});
                    no_more = true;
                }
            }
        },
        error: function () {
            alert(arguments[1]);
        }

    });
});


//页面上显示的最后一则通知的发布时间
var last_notice_date;
var no_more_notice = false;

/**
 * 点击"更多"按钮触发getNotice事件
 */
$("#more_notices").click(function () {
    $("#more_notices").trigger("getNotice", [last_notice_date]);
});

/**
 * 异步获取通知
 */
$("#more_notices").bind("getNotice", function (event, base_date) {
    // 从编辑按钮获取site_url('Notify')，用于构造notice的href属性的值,等同于site_url('Notify/readNotice')
    var site_url = $("#site_url").attr("href");
    var notice_href = site_url + "/readNotice";

    $.ajax({
        type: 'get',
        url: 'Notify/getNotice/',
        data: {
            "base_date": base_date,
        },
        success: function (msg) {
            var ret = JSON.parse(msg);
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
            } else {
                if (!no_more_notice) {
                    $("#more-notices-btn").before(
                        "<div class='feed-element' id='element_30'>" +
                        "<div class='media-body text-center'>" +
                        "<p>暂无更多</p>" +
                        "</div>" +
                        "</div>"
                    );
                    $("#more-notices-btn").css({"display": "none"});
                    no_more_notice = true;
                }
            }
        },
        error: function () {
            alert(arguments[1]);
        }

    });
});


