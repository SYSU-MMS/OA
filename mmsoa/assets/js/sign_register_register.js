var signid = 0;

function load_table(signid) {
    $.ajax({
        type: 'post',
        url: '../GetTableWithDetail', 
        data: {
            signid: signid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
                var table_tmp = "";
                $('#reg_note').html(ret['table']['note']);
                $('#table_title').html(ret['table']['title']);
                for(var i = 0; i < ret['user_list'].length; ++i) {
                    var signTime = "";
                    var state = ret['user_list'][i]['state'];
                    if (state == 1) {
                        signTime = ret['user_list'][i]['signTime'];
                    }
                    table_tmp += "<tr>"
                        table_tmp += "<td>" +
                                    ret['user_list'][i]['name'] + 
                                    "</td>" + 
                                    "<td>" +
                                    ret['user_list'][i]['username'] + 
                                    "</td>" + 
                                    "<td>" +
                                    signTime + 
                                    "</td>";
                    var j = 0;
                    table_tmp += "<td>";
                    var point = i + "," + j;
                    var fa_icon = "";
                    var check_class = "";
                    var onclick = "";

                    if(state == 0) {
                        check_class = "can-be-register";
                        fa_icon = "fa-check-circle";
                        onclick = "register(\""+ret['user_list'][i]['uid']+"\");";
                    }

                    if(state == 1) {
                        check_class = "can-be-canceled";
                        fa_icon = "fa-check-circle";
                        onclick = "unregister(\""+ret['user_list'][i]['uid']+"\");";
                    }

                    if(state == 2) {
                        check_class = "cannot-be-canceled";
                        fa_icon = "fa-check-circle";
                    }

                    if(state == 3) {
 
                    }
                    console.log(state);
                    table_tmp += "<a onclick='"+onclick+"' class='btn btn-circle "+ check_class+"'><i class='fa fa-2x "+fa_icon+"'></i></a>"
                    table_tmp += "</td>";
                    table_tmp += "</tr>";
                }
                $("#register-table").html(table_tmp);
                $(".users-dataTable").dataTable({"aaSorting": [[ 0, "desc" ]]});
            }
        },
        error: function () {
            alert("获取报名表，无法连接服务器");
        }
    });
}

function register(uid) {
    console.log("reg "  + uid + "  " + signid);
    $.ajax({
        type: 'post',
        url: '../UserRegister',
        data: {
            signid: signid,
            uid: uid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
            location.reload();
        },
        error: function(msg) {

            alert("无法连接服务器");
        }
    });
}

function getUser(name) {
    $.ajax({
        type: 'post',
        url: '../GetUserList',
        data: {
           name: name,
           signid: signid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            console.log(ret);
            var tmp = "";
            for (var i = 0; i < ret['user_list'].length; i ++ ) {
                var op;
                if (ret['user_list'][i]['have'] == 1)
                    op = "<button type='button' class='btn btn-xs btn-outline btn-danger manager' value='" + ret['user_list'][i]['uid'] + "' onclick='del_signer(this.value)' style='margin-left: 10px;'><i class='fa fa-close'></i><span> 移出签到表</span></button>";
                else    op = "<button type='button' class='btn btn-xs btn-outline btn-primary' value='" + ret['user_list'][i]['uid'] + "' onclick='add_signer(this.value)' style='margin-left: 10px;'><i class='fa fa-close'></i><span> 添进签到表</span></button>";
                tmp += 
                    "<tr>" + 
                    "<td>" +
                    ret['user_list'][i]['username'] +
                    "</td>" + 
                    "<td>" + 
                    ret['user_list'][i]['name'] +
                    "</td>" +
                    "<td>" + 
                    op +
                    "</td>" +
                    "</tr>";
            }
            $("#adding-list").html(tmp);
        },
        error: function(msg) {
                console.log(msg);
            alert("无法连接服务器");
        }
    });
}


function add_signer(uid) {
    $.ajax({
        type: 'post',
        url: '../AddSigner',
        data: {
            uid: uid,
            signid: signid
        },
        success: function (msg) {
            alert("添加成功");
            location.reload();
        },
        error: function (msg) {
            console.log(msg);
            alert("无法连接服务器");
        }
    });
}

function del_signer(uid) {
    $.ajax({
        type: 'post',
        url: '../DelSigner',
        data: {
            uid: uid,
            signid: signid
        },
        success: function (msg) {
            alert("删除成功");
            location.reload();
        },
        error: function (msg) {
            console.log(msg);
            alert("无法连接服务器");
        }
    });
}

function unregister(uid) {
    console.log("unreg "  + uid);
    $.ajax({
        type: 'post',
        url: '../UserUnregister',
        data: {
            signid: signid,
            uid: uid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            alert(ret['msg']);
            location.reload();
        },
        error: function() {
            alert("无法连接服务器");
        }
    });
}