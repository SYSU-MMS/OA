var toggle_more_para = true;
var name_list;
var wid_list;
var user_level;

function toggle_more(){
    var table = $('#found_table').DataTable();
    var visible_list = [1, 5, 7, 8, 11, 12];
    for (var i = 0; i <= 5; i++){
        table.column(visible_list[i]).visible(toggle_more_para);
    }
    $('#found_table').attr("style", "width: 100%;");
    $('#toggle_more_btn').text(toggle_more_para ? "显示更少" : "显示更多");
    toggle_more_para = !toggle_more_para;
}

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

    $("#myModalLabelTitle").text("新增拾获记录");
    $("#modalBody").html(
        '      <form class="form-horizontal m-t" id="commentForm"> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">登记助理：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <select id="select_found_name" name="select_found_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4"> ' +
        '                    <option value="">选择助理</option> ' + worker_options +
        '                  </select> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">拾获时间：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="found_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="拾获时间" value="' + initTime + '" />' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">物品描述：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <textarea id="fdescription" name="fdescription" class="form-control" required="" aria-required="true"></textarea> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">拾获地点：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="fplace" name="fplace" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">拾获人：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="finder" name="finder" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">联系方式：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="fcontact" name="fcontact" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <div class="col-sm-4 col-sm-offset-3"> ' +
        '                  <button onclick="insert_found()" class="btn btn-primary" type="submit">提交</button> ' +
        '              </div> ' +
        '          </div> ' +
        '      </form> '
    );

    $('#found_dtp').datetimepicker({
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

    $('#select_found_name').val(wid_current);
    if (user_level >= 2) $('#select_found_name').prop("disabled", false);
    else $('#select_found_name').prop("disabled", true);
    $('#select_found_name').trigger("chosen:updated");
}

function insert_found() {
    var fwid = $("#select_found_name").val();
    var fdatetime = $("#found_dtp").val();
    var fdescription = $("#fdescription").val();
    var fplace = $("#fplace").val();
    var finder = $("#finder").val();
    var fcontact = $("#fcontact").val();
    //console.log(fwid, fdatetime, fdescription, fplace, finder, fcontact);
    if (!(not_null(fwid) && not_null(fdatetime) && not_null(fdescription) && not_null(fplace) &&
            not_null(finder) && not_null(fcontact))) {
        alert("请正确填写信息！");
    } else {
        //插入新拾获记录
        //console.log("ajax");
        $.ajax({
            type: "POST",
            url: "Found/signUpItem",
            async: false,
            data: {
                "fwid": fwid,
                "fdatetime": fdatetime,
                "fdescription": fdescription,
                "fplace": fplace,
                "finder": finder,
                "fcontact": fcontact
            },
            success: function (msg) {
                //console.log("problem msg", msg);
                var ret = JSON.parse(msg);
                if (ret['status'] === false) {
                    alert(ret['msg']);
                } else {
                    pid = ret['fid'];
                }
            },
            error: function () {
                alert(arguments[1]);
                //console.log("ajax failed");
            }
        });
    }
}

function found_by_fid(fid){
    var initTime = getFormatDate(new Date());
    var worker_options = "";
    name_list.forEach(function (item, index) {
        worker_options = worker_options + "<option value='" + wid_list[index] + "'>" + name_list[index] + "</option>";
    });
    //console.log(fid);
    $("#myModalLabelTitle").text("登记归还信息");
    $("#modalBody").html(
        '      <form class="form-horizontal m-t" id="commentForm"> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">登记助理：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <select id="select_owned_name" name="select_owned_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4"> ' +
        '                    <option value="">选择助理</option> ' + worker_options +
        '                  </select> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">归还时间：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="owned_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="拾获时间" value="' + initTime + '" />' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">领取人：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="owner" name="owner" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">联系方式：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="ocontact" name="ocontact" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">证件号码：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="onumber" name="onumber" class="form-control" required="" aria-required="true"></input> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <div class="col-sm-4 col-sm-offset-3"> ' +
        '                  <button onclick="found_submit(' + fid + ')" class="btn btn-primary" type="submit">提交</button> ' +
        '              </div> ' +
        '          </div> ' +
        '      </form> '
    );

    $('#owned_dtp').datetimepicker({
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

    $('#select_owned_name').val(wid_current);
    if (user_level >= 2) $('#select_owned_name').prop("disabled", false);
    else $('#select_owned_name').prop("disabled", true);
    $('#select_owned_name').trigger("chosen:updated");
}

function found_submit(fid){

    var owid = parseInt($("#select_owned_name").val());
    var odatetime = $("#owned_dtp").val();
    var owner = $("#owner").val();
    var ocontact = $("#ocontact").val();
    var onumber = $("#onumber").val();
    if (!(not_null(owid) && not_null(odatetime) && not_null(fid) &&
            not_null(owner) && not_null(ocontact) && not_null(onumber))) {
        alert("请正确填写信息！");
    } else {
        //插入新拾获记录
        console.log("ajax", fid, owid, odatetime, owner, ocontact, onumber);
        $.ajax({
            type: "POST",
            url: "Found/updateByFid",
            async: false,
            data: {
                "fid": fid,
                "owid": owid,
                "odatetime": odatetime,
                "owner": owner,
                "ocontact": ocontact,
                "onumber": onumber
            },
            success: function (msg) {
                //console.log("problem msg", msg);
                var ret = JSON.parse(msg);
                if (ret['status'] === false) {
                    alert(ret['msg']);
                } else {
                    //fid = ret['fid'];
                }
            },
            error: //function (msg1, msg2, msg3) {
                function(XMLHttpRequest, textStatus, errorThrown){
                    alert(arguments[1]);
                    //console.log(XMLHttpRequest.readyState + XMLHttpRequest.status + XMLHttpRequest.responseText);
                }
        });
    }
}

function update_by_fid(fid){

    var owid, odatetime, owner, ocontact, onumber;

    $.ajax({
        type: "POST",
        url: "Found/getByFid",
        async: false,
        data: {
            "fid": fid
        },
        success: function(msg){
            var ret = JSON.parse(msg);
            if (ret['status'] === false){
                alert(ret['msg']);
            }else{
                owid = ret['data']['owid'];
                odatetime = ret['data']['odatetime'];
                owner = ret['data']['owner'];
                ocontact = ret['data']['ocontact'];
                onumber = ret['data']['onumber'];
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert(arguments[1]);
            //console.log(XMLHttpRequest.readyState + XMLHttpRequest.status + XMLHttpRequest.responseText);
        }
    });

    var worker_options = "";
    name_list.forEach(function (item, index) {
        worker_options = worker_options + "<option value='" + wid_list[index] + "'>" + name_list[index] + "</option>";
    });
    //console.log(fid);
    $("#myModalLabelTitle").text("登记归还信息");
    $("#modalBody").html(
        '      <form class="form-horizontal m-t" id="commentForm"> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">登记助理：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <select id="select_owned_name" name="select_owned_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4"> ' +
        '                    <option value="'+owid+'">选择助理</option> ' + worker_options +
        '                  </select> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">归还时间：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="owned_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="拾获时间" value="' + odatetime + '" />' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">领取人：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="owner" name="owner" class="form-control" required="" aria-required="true" value="'+owner+'"/>' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">联系方式：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="ocontact" name="ocontact" class="form-control" required="" aria-required="true" value="'+ocontact+'">' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">证件号码：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="onumber" name="onumber" class="form-control" required="" aria-required="true" value="'+onumber+'">' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <div class="col-sm-4 col-sm-offset-3"> ' +
        '                  <button onclick="found_submit(' + fid + ')" class="btn btn-primary" type="submit">提交</button> ' +
        '              </div> ' +
        '          </div> ' +
        '      </form> '
    );

    $('#owned_dtp').datetimepicker({
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

    $('#select_owned_name').val(wid_current);
    if (user_level >= 2) $('#select_owned_name').prop("disabled", false);
    else $('#select_owned_name').prop("disabled", true);
    $('#select_owned_name').trigger("chosen:updated");
}

function delete_by_fid(fid){
    if (confirm("您确定要删除编号为 "+fid+" 的物品记录吗？")){
        $.ajax({
            type: "POST",
            url: "Found/deleteByFid",
            async: false,
            data: {
                "fid": fid
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
        $("#found_content_"+fid).remove();
    }
}

// 获取助理信息
$.ajax({
    type: "GET",
    url: "Found/getInformation",
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