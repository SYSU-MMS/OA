/**
 * 拍摄登记
 */

var name;
var wid;
var uid;
var fid;
var name_list = [];
var wid_list = [];
var user_level;

//获取当前用户信息
$.ajax({
    type: "GET",
    url: "Filming/getInformation",
    success: function (msg) {
        var ret = JSON.parse(msg);
        if (ret['status'] === false) {
            alert(ret['msg']);
        } else {
            var data = ret.data;
            name = data.name;
            wid = data.wid;
            name_list = data.name_list;
            wid_list = data.wid_list;
            user_level = data.user_level;
        }
    },
    error: function () {
        alert(arguments[1]);
    }
});

function not_null(para) {
    if (para == "" || para == null || para == undefined) {
        return false;
    }
    return true;
}

/*
 * 获得标准格式的当前时间
 * yyyy-mm-dd
 */
function getFormatDate(date_in) {
    var year = date_in.getFullYear();
    var month = (date_in.getMonth() + 1) >= 10 ? ((date_in.getMonth() + 1)) : ('0' + (date_in.getMonth() + 1));
    var day = date_in.getDate() >= 10 ? date_in.getDate() : ('0' + date_in.getDate());
    return year + '-' + month + '-' + day;
}

function isNumber(obj) {
    return obj === +obj;
}

function insert_filming() {
    var date = $("#start_dtp").val();
    var fmname = $("#fmname").val();
    var aename = $("#aename").val();
    var worktime = $("#worktime").val();
    var flag = true;
    if (not_null(wid) && not_null(date) && (not_null(fmname) || not_null(aename)) && not_null(worktime) && (worktime >= 0)) {
        $.ajax({
            type: "POST",
            url: "Filming/insertFilmingRecord",
            async: false,
            data: {
                "wid": wid,
                "date": date,
                "fmname": fmname,
                "aename": aename,
                "worktime": worktime
            },
            success: function (msg) {
                var ret = JSON.parse(msg);
                if (ret['status'] === false) {
                    alert(ret['msg']);
                    flag = false;
                } else {
                    fid = ret['insert_id'];
                }
            },
            error: function () {
                alert(arguments[1]);
                flag = false
            }
        });
    } else {
        alert("请正确填写信息！")
    }
    if (flag === true) {
        $('#myModal').modal('hide');
    }
}

function new_record() {
    var initTime = getFormatDate(new Date());

    var worker_options = "";
    name_list.forEach(function (item, index) {
        worker_options = worker_options + "<option value='" + wid_list[index] + "'>" + name_list[index] + "</option>"
    });

    $("#myModalLabelTitle").text("新增记录");
    $("#modalBody").html(
        '      <form class="form-horizontal m-t" id="commentForm"> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">摄制人：</label> ' +
        '              <div class="col-sm-8" id="total-chosen-select_name"> ' +
        '                  <select id="select_name" name="select_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4"> ' +
        '                    <option value="">选择助理</option> ' + worker_options +
        '                  </select> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">摄制日期：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="摄制日期" value="' + initTime + '" />' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">拍摄名称：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <textarea id="fmname" name="fmname" class="form-control"></textarea> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">后期名称：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <textarea id="aename" name="aename" class="form-control"></textarea> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">工时：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="worktime" name="worktime" class="form-control" required="" aria-required="true"/>' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <div class="col-sm-4 col-sm-offset-3"> ' +
        '                  <button onclick="insert_filming()" class="btn btn-primary">提交</button> ' +
        '              </div> ' +
        '          </div> ' +
        '      </form> '
    );

    $('#start_dtp').datetimepicker({
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 1
    });

    /* Chosen name */
    var config = {
        '#select_name': {
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

    $('#select_name').val(wid);
    if (user_level >= 2) $('#select_name').prop("disabled", false);
    else $('#select_name').prop("disabled", true);
    $('#select_name').trigger("chosen:updated");
}

function delete_by_fid(fid) {
    var notice = "确认要删除序号为 " + fid + " 的记录吗？";
    if (confirm(notice)) {
        $.ajax({
            'type': 'post',
            'url': 'Filming/delete',
            'data': {
                'fid': fid
            },
            success: function (msg) {
                var ret = JSON.parse(msg);
                if (ret['status'] == true) {
                    alert(ret['msg']);
                    $("#filming_content_" + fid).remove();
                } else {
                    alert(ret['msg']);
                }
            }
        });
    }
}