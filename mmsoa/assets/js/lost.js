var name_list;
var wid_list;
var user_level;


/*
 * 获得标准格式的当前时间
 * yyyy-mm-dd hh:ii
 */
function getFormatDate(date_in) {
    var year = date_in.getFullYear();
    var month = (date_in.getMonth() + 1) >= 10 ? ((date_in.getMonth() + 1)) : ('0' + (date_in.getMonth() + 1));
    var day = date_in.getDate() >= 10 ? date_in.getDate() : ('0' + date_in.getDate());
    var hour = date_in.getHours() >= 10 ? date_in.getHours() : ('0' + date_in.getHours());
    var minute = date_in.getMinutes() >= 10 ? date_in.getMinutes() : ('0' + date_in.getMinutes());
    var second = date_in.getSeconds() >= 10 ? date_in.getSeconds() : ('0' + date_in.getSeconds());
    return year + '-' + month + '-' + day + ' '
        + hour + ':' + minute + ':' + second;
}

function not_null(para) {
    if (para == "" || para == null || para == undefined) {
        return false;
    }
    return true;
}

function new_record() {
    var initTime = getFormatDate(new Date());
    var worker_options = "";
    name_list.forEach(function (item, index) {
        worker_options = worker_options + "<option value='" + wid_list[index] + "'>" + name_list[index] + "</option>";
    });

    $("#myModalLabelTitle").text("新增遗失记录");
    $("#modalBody").html(
        '      <form class="form-horizontal m-t" id="commentForm"> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">登记助理：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <select id="select_lost_name" name="select_lost_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4"> ' +
        '                    <option value="">选择助理</option> ' + worker_options +
        '                  </select> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">遗失时间：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="lost_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="遗失时间" value="' + initTime + '" />' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">物品描述：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <textarea id="ldescription" name="ldescription" class="form-control" required="" aria-required="true"></textarea> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">遗失地点：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="lplace" name="lplace" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">遗失人：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="loser" name="loser" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">联系方式：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="lcontact" name="lcontact" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <div class="col-sm-4 col-sm-offset-3"> ' +
        '                  <button onclick="insert_lost()" class="btn btn-primary" type="submit">提交</button> ' +
        '              </div> ' +
        '          </div> ' +
        '      </form> '
    );

    $('#lost_dtp').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language: 'zh-CN',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 0,
        forceParse: 1
    });

    /* Chosen name */
    var config = {
        '.chosen-select-name': {
            // 实现中间字符的模糊查询
            search_contains: true,
            no_results_text: "没有找到",
            disable_search_threshold: 10,
            width: "200px"
        }
    };
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    $('#select_lost_name').val(wid_current);
    if (user_level >= 2) $('#select_lost_name').prop("disabled", false);
    else $('#select_lost_name').prop("disabled", true);
    $('#select_lost_name').trigger("chosen:updated");
}

function insert_lost() {
    var lwid = $("#select_lost_name").val();
    var ldatetime = $("#lost_dtp").val();
    var ldescription = $("#ldescription").val();
    var lplace = $("#lplace").val();
    var loser = $("#loser").val();
    var lcontact = $("#lcontact").val();
    console.log(lwid, ldatetime, ldescription, lplace, loser, lcontact);
    if (!(not_null(lwid) && not_null(ldatetime) && not_null(ldescription) && not_null(loser) &&
            not_null(loser) && not_null(lcontact))) {
        alert("请正确填写信息！");
    } else {
        //插入新拾获记录
        //console.log("ajax");
        $.ajax({
            type: "POST",
            url: "Lost/signUpItem",
            async: false,
            data: {
                "lwid": lwid,
                "ldatetime": ldatetime,
                "ldescription": ldescription,
                "lplace": lplace,
                "loser": loser,
                "lcontact": lcontact
            },
            success: function (msg) {
                console.log("problem msg", msg);
                var ret = JSON.parse(msg);
                if (ret['status'] === false) {
                    alert(ret['msg']);
                } else {
                    pid = ret['lid'];
                }
            },
            error: function () {
                alert(arguments[1]);
                //console.log("ajax failed");
            }
        });
    }
}

function delete_by_lid(lid){
    if (confirm("您确定要删除编号为 "+lid+" 的物品记录吗？")){
        $.ajax({
            type: "POST",
            url: "Lost/deleteByLid",
            async: false,
            data: {
                "lid": lid
            },
            success: function (msg) {
                var ret = JSON.parse(msg);
                if (ret['status'] != false) alert("删除成功！");
                else alert("删除失败！");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert(arguments[1]);
                //console.log(XMLHttpRequest.readyState + XMLHttpRequest.status + XMLHttpRequest.responseText);
            }
        });
        $("#lost_content_"+lid).remove();
    }
}

function found_by_lid(lid){
    if (confirm("您确定要设置编号为 "+lid+" 的物品已找到吗？")){
        $.ajax({
            type: "POST",
            url: "Lost/updateByLid",
            async: false,
            data: {
                "lid": lid
            },
            success: function (msg) {
                var ret = JSON.parse(msg);
                if (ret['status'] != false) alert("设置成功！");
                else alert("设置失败！");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert(arguments[1]);
                //console.log(XMLHttpRequest.readyState + XMLHttpRequest.status + XMLHttpRequest.responseText);
            }
        });
        $("#lost_content_"+lid).remove();
    }
}

// 获取助理信息
$.ajax({
    type: "GET",
    url: "Lost/getInformation",
    success: function (msg) {
        //console.log(msg);
        var ret = JSON.parse(msg);
        if (ret['status'] === false) {
            alert(ret['msg']);
        } else {
            var data = ret.data;
            name_list = data.name_list;
            wid_list = data.wid_list;
            user_level = data.user_level;
        }
    },
    error: function () {
        alert(arguments[1]);
    }
});