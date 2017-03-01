/**
 * 拍摄登记
 */

var name;
var wid;
var uid;
var fid;

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

function insert_filming() {

}

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
        '              <label class="col-sm-3 control-label">摄制日期：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="摄制日期" value="' + initTime + '" />' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">拍摄名称：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <textarea id="fmname" name="fmname" class="form-control" required="" aria-required="true"></textarea> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">后期名称：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <textarea id="aename" name="aename" class="form-control" required="" aria-required="true"></textarea> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <label class="col-sm-3 control-label">工时：</label> ' +
        '              <div class="col-sm-8"> ' +
        '                  <textarea id="worktime" name="worktime" class="form-control" required="" aria-required="true"></textarea> ' +
        '              </div> ' +
        '          </div> ' +
        '          <div class="form-group"> ' +
        '              <div class="col-sm-4 col-sm-offset-3"> ' +
        '                  <button onclick="insert_filming()" class="btn btn-primary" type="submit">提交</button> ' +
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

}