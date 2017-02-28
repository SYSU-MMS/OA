/**
 * 拍摄登记
 */

var name;
var wid;
var uid;
var fid;

function new_record() {
    var initTime = getFormatDate(new Date());

    $("#myModalLabelTitle").text("新建记录");
    $("#modalBody").html(
        '      <form class="form-horizontal m-t" id="commentForm"> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">摄制人：</label> ' +
        '              <div class="col-sm-8"> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">值班时段：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                   <select id="select_period" name="select_period" data-placeholder="" class="form-control m-b chosen-select-classroom" tabindex="4"> ' +
        '                     <option value="">选择时段</option> ' + duty_options +
        '                   </select>' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">发现人：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <select id="select_found_name" name="select_found_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4"> ' +
        '                    <option value="">选择助理</option> ' + worker_options +
        '                  </select> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">故障课室：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                   <select id="select_classroom" name="select_classroom" data-placeholder="" class="form-control m-b chosen-select-classroom" tabindex="4"> ' +
        '                     <option value="">选择课室</option> ' + room_options +
        '                   </select>' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">发现时刻：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" value="' + initTime + '" />' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">故障说明：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <textarea id="ccomment" name="comment" class="form-control" required="" aria-required="true"></textarea> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <div class="col-sm-4 col-sm-offset-3"> ' +
        '                  <button onclick="insert_dutyout()" class="btn btn-primary" type="submit">提交</button> ' +
        '              </div> ' +
        '          </div> ' +
        '      </form> '
    );

    $('#start_dtp').datetimepicker({
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
    $('#end_dtp').datetimepicker({
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
        '.chosen-select-classroom': {
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

    /* Chosen classroom */
    var config_room = {
        '.chosen-select-name': {
            // 实现中间字符的模糊查询
            search_contains: true,
            no_results_text: "没有找到",
            disable_search_threshold: 10,
            width: "200px"
        }
    };
    for (var selector_room in config_room) {
        $(selector_room).chosen(config_room[selector_room]);
    }
    //console.log(wid_current);
    $('#select_found_name').val(wid_current);
    $('#select_found_name').prop("disabled", false);
    $('#select_found_name').trigger("chosen:updated");
    if (now_duty_id > -1) $('#select_period').val(now_duty_id);
    $('#select_period').trigger("chosen:updated");
}