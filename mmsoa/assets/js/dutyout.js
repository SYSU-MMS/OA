/**
 * Created by Jerry on 2016/11/20.
 */
var room_list = [];
var roomid_list = [];
var name_list = [];
var wid_list = [];

/*
 * 获得标准格式的当前时间
 * yyyy-mm-dd hh:ii
 */
function getFormatDate(date_in) {
    return date_in = date_in.getFullYear() + '-' + (date_in.getMonth() + 1) + '-' + date_in.getDate() + ' '
        + date_in.getHours() + ':' + date_in.getMinutes() + ':' + date_in.getSeconds();
}

$.ajax({
    type: "GET",
    url: "DutyOut/getInformation",
    success: function (msg) {
        ret = JSON.parse(msg);
        if (ret['status'] === false) {
            alert(ret['msg']);
        } else {
            data = ret.data;
            room_list = data.room_list;
            roomid_list = data.roomid_list;
            name_list = data.name_list;
            wid_list = data.wid_list;
        }
    },
    error: function () {
        alert(arguments[1]);
    }
});


function delete_by_doid(doid) {
    var notice = "确认要删除序号为 " + doid + " 的记录吗？";
    if (confirm(notice)) {
        $.ajax({
            'type': 'post',
            'url': 'DutyOut/delete_dutyout',
            'data': {
                'doid': doid
            },
            success: function (msg) {
                var ret = JSON.parse(msg);
                if (ret['status'] == true) {
                    //alert(ret['msg']);
                    $("#duty_content_" + doid).remove();
                } else {
                    alert(ret['msg']);
                }
            }
        });
    }
}

function new_record() {
    //var initTime = getFormatDate(new Date());
    var room_options = "";
    var worker_options = "";
    var problem_options = "";
    roomid_list.forEach(function(item, index) {
        room_options = room_options + "<option value='" + roomid_list[index] + "'>" + room_list[index] + "</option>";
    });
    name_list.forEach(function(item, index) {
        worker_options = worker_options + "<option value='" + wid_list[index] + "'>" + name_list[index] + "</option>";
    });
    problem_list.forEach(function (item, index) {
        problem_options = problem_options + "<option value='" + problemid_list[index] + "'>" + problem_list[index] + "</option>";
    });

    $("#myModalLabelTitle").text("新建记录");
    $("#modalBody").html(
        '      <form class="form-horizontal m-t" id="commentForm"> '+
        '          <div class="form-group"> '+
        '              <label class="col-sm-3 control-label">出勤人：</label> '+
        '              <div class="col-sm-8"> '+
        '                  <select id="select_name" name="select_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4"> '+
        '                    <option value="">选择助理</option> '+ worker_options +
        '                  </select> '+
        '              </div> '+
        '          </div> '+
        '          <!--div class="form-group"> '+
        '              <label class="col-sm-3 control-label">故障课室：</label> '+
        '              <div class="col-sm-8"> '+
        '                   <select id="select_classroom" name="select_classroom" data-placeholder="" class="form-control m-b chosen-select-classroom" tabindex="4"> '+
        '                     <option value="">选择课室</option> '+ room_options +
        '                   </select>' +
        '              </div> '+
        '          </div> '+
        '          <div class="form-group"> '+
        '              <label class="col-sm-3 control-label">发现时刻：</label> '+
        '              <div class="col-sm-8"> '+
        '                  <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" value="'+ initTime +'" />'+
        '              </div> '+
        '          </div> '+
        '          <div class="form-group"> '+
        '              <label class="col-sm-3 control-label">故障说明：</label> '+
        '              <div class="col-sm-8"> '+
        '                  <textarea id="ccomment" name="comment" class="form-control" required="" aria-required="true"></textarea> '+
        '              </div> '+
        '          </div--> '+
        '          <div class="form-group"> '+
        '              <label class="col-sm-3 control-label">故障：</label> '+
        '              <div class="col-sm-8"> '+
        '                   <select id="select_classroom" name="select_classroom" data-placeholder="" class="form-control m-b chosen-select-classroom" tabindex="4"> '+
        '                     <option value="">选择故障</option> '+ room_options +
        '                   </select>' +
        '              </div> '+
        '          </div> '+
        '          <div class="form-group"> '+
        '              <div class="col-sm-4 col-sm-offset-3"> '+
        '                  <button onclick="insertProblem()" class="btn btn-primary" type="submit">提交</button> '+
        '              </div> '+
        '          </div> '+
        '      </form> '
    );

    $('#start_dtp').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language: 'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 0,
        forceParse: 1
    });
    $('#end_dtp').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language: 'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 0,
        forceParse: 1
    });

    /* Chosen name */
    var config = {
        '.chosen-select-classroom': {
            // 实现中间字符的模糊查询
            search_contains: true,
            no_results_text: "没有找到",
            disable_search_threshold: 10,
            width: "200px"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    /* Chosen classroom */
    var config = {
        '.chosen-select-name': {
            // 实现中间字符的模糊查询
            search_contains: true,
            no_results_text: "没有找到",
            disable_search_threshold: 10,
            width: "200px"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
}

function solve_by_pid(pid) {
    var initTime = getFormatDate(new Date());
    var worker_options = "";
    name_list.forEach(function(item, index) {
        worker_options = worker_options + "<option value='" + wid_list[index] + "'>" + name_list[index] + "</option>"
    });

    $("#myModalLabelTitle").text("解决");
    $("#modalBody").html(
        '      <form class="form-horizontal m-t" id="commentForm"> '+
        '          <div class="form-group"> '+
        '              <label class="col-sm-3 control-label">解决人：</label> '+
        '              <div class="col-sm-8" id="total-chosen-select_name"> '+
        '                  <select id="select_name" name="select_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4"> '+
        '                    <option value="">选择助理</option> '+ worker_options +
        '                  </select> '+
        '              </div> '+
        '          </div> '+
        '          <div class="form-group"> '+
        '              <label class="col-sm-3 control-label">解决时刻：</label> '+
        '              <div class="col-sm-8"> '+
        '                  <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" value="'+ initTime +'" />'+
        '              </div> '+
        '          </div> '+
        '          <div class="form-group"> '+
        '              <label class="col-sm-3 control-label">解决方法：</label> '+
        '              <div class="col-sm-8"> '+
        '                  <textarea id="ccomment" name="comment" class="form-control" required="" aria-required="true"></textarea> '+
        '              </div> '+
        '          </div> '+
        '          <div class="form-group"> '+
        '              <div class="col-sm-4 col-sm-offset-3"> '+
        '                  <button onclick="updateProblem('+ pid +')" class="btn btn-primary" type="submit">提交</button> '+
        '              </div> '+
        '          </div> '+
        '      </form> '
    );

    $('#start_dtp').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language: 'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 0,
        forceParse: 1
    });
    $('#end_dtp').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language: 'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 0,
        forceParse: 1
    });

    /* Chosen name */
    var config = {
        '#select_name': {
            // 实现中间字符的模糊查询
            search_contains: true,
            no_results_text: "没有找到",
            disable_search_threshold: 10,
            width:"200px"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
}

function update_duty(pid) {
    var solved_time = getFormatDate(new Date($('#start_dtp').val()));
    var wid = $('#select_name').val();
    var solution = $('#ccomment').val();
    $.ajax({
        type: "POST",
        url: "DutyOut/updateProblem",
        data: {
            "solve_wid": wid,
            "solved_time": solved_time,
            "solution": solution,
            "pid": pid
        },
        success: function (msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === false) {
                alert(ret['msg']);
            }
        },
        error: function () {
            alert(arguments[1]);
        }
    });
}