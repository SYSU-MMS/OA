var signid;
var cur_name;
function load_table(name) {
    cur_name = name;
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
                    op = "<button type='button' class='btn btn-xs btn-outline btn-danger manager' value='" + ret['user_list'][i]['uid'] + "' onclick='del_signer(this.value, this)' style='margin-left: 10px;'><i class='fa fa-close'></i><span> 移出签到表</span></button>";
                else    op = "<button type='button' class='btn btn-xs btn-outline btn-primary' value='" + ret['user_list'][i]['uid'] + "' onclick='add_signer(this.value, this)' style='margin-left: 10px;'><i class='fa fa-close'></i><span> 添进签到表</span></button>";
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
                        $(".users-dataTable").dataTable({"aaSorting": [[ 0, "desc" ]]});

        },
        error: function(msg) {
                console.log(msg);
            alert("无法连接服务器");
        }
    });
}
function add_signer(uid, self) {
    $.ajax({
        type: 'post',
        url: '../AddSigner',
        data: {
            uid: uid,
            signid: signid
        },
        success: function (msg) {
            self.className = 'btn btn-xs btn-outline btn-danger manager';
            $(self).attr('onclick', 'del_signer(this.value, this)');
            $(self).html("<i class='fa fa-close'></i><span> 移出签到表</span>");
        },
        error: function (msg) {
            console.log(msg);
            alert("无法连接服务器");
        }
    });
}

function del_signer(uid, self) {
    $.ajax({
        type: 'post',
        url: '../DelSigner',
        data: {
            uid: uid,
            signid: signid
        },
        success: function (msg) {
            self.className = 'btn btn-xs btn-outline btn-primary';
            $(self).attr('onclick', 'add_signer(this.value, this)');
            $(self).html("<i class='fa fa-close'></i><span> 添进签到表");
        },
        error: function (msg) {
            console.log(msg);
            alert("无法连接服务器");
        }
    });
}