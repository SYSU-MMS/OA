/**
 * 课室故障汇总
 */
var  room_list    = [];
var  roomid_list  = [];
var  name_list    = [];
var  wid_list     = [];

/*
 * 获得标准格式的当前时间
 * yyyy-mm-dd hh:ii
 */
function getFormatDate(date_in) {
  return date_in =  date_in.getFullYear() + '-' + (date_in.getMonth()+1) + '-' + date_in.getDate() + ' '
        + date_in.getHours() + ':' + date_in.getMinutes()+ ':'+ date_in.getSeconds();
}

$.ajax({
   type: "GET",
   url: "getInformation",
   success: function(msg) {
       ret = JSON.parse(msg);
       if (ret['status'] === false) {
           alert(ret['msg']);
       } else {
         data         = ret.data;
         room_list    = data.room_list;
         roomid_list  = data.roomid_list;
         name_list    = data.name_list;
         wid_list     = data.wid_list;
       }
   },
   error: function(){
       alert(arguments[1]);
   }
});


function insertProblem() {
	// 增加秒
	var found_time = getFormatDate(new Date($('#start_dtp').val()));
	var wid = $('#select_name').val();
  var roomid = $('#select_classroom').val();
  var description = $('#ccomment').val();
	$.ajax({
		type: "POST",
		url: "insertProblem",
		data: {
      "founder_wid": wid,
			"found_time": found_time,
      "roomid": roomid,
			"description": description
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === false) {
				alert(ret['msg']);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});

}


function updateProblem(pid) {
	var solved_time = getFormatDate(new Date($('#start_dtp').val()));
	var wid = $('#select_name').val();
  var solution = $('#ccomment').val();
	$.ajax({
		type: "POST",
		url: "updateProblem",
		data: {
      "solve_wid": wid,
			"solved_time": solved_time,
			"solution": solution,
      "pid" : pid
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === false) {
				alert(ret['msg']);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
}

function deleteProblemButton(pid) {
  var statu = confirm("确认删除该条纪录吗?");
  if(!statu){
      return false;
  }
	$.ajax({
		type: "POST",
		url: "deleteProblem",
		data: {
      "pid" : pid
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === false) {
				alert(ret['msg']);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
  window.location="index";
}

/**
 * 新建条目
 * @param
 */
function newProblemButton(){
  var initTime = getFormatDate(new Date());
  var room_options = "";
  var worker_options = "";
  roomid_list.forEach(function(item, index) {
      room_options = room_options + "<option value='" + roomid_list[index] + "'>" + room_list[index] + "</option>";
  })
  name_list.forEach(function(item, index) {
      worker_options = worker_options + "<option value='" + wid_list[index] + "'>" + name_list[index] + "</option>"
  });

	$("#myModalLabelTitle").text("新建故障条目");
	$("#modalBody").html(
    '      <form class="form-horizontal m-t" id="commentForm"> '+
    '          <div class="form-group"> '+
    '              <label class="col-sm-3 control-label">发现人：</label> '+
    '              <div class="col-sm-8"> '+
    '                  <select id="select_name" name="select_name" data-placeholder="" class="chosen-select-name form-control m-b" tabindex="4"> '+
    '                    <option value="">选择助理</option> '+ worker_options +
    '                  </select> '+
    '              </div> '+
    '          </div> '+
    '          <div class="form-group"> '+
    '              <label class="col-sm-3 control-label">发现时刻：</label> '+
    '              <div class="col-sm-8"> '+
    '                  <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" value="'+ initTime +'" />'+
    '              </div> '+
    '          </div> '+
    '          <div class="form-group"> '+
    '              <label class="col-sm-3 control-label">故障课室</label> '+
    '              <div class="col-sm-8"> '+
    '                   <select id="select_classroom" name="select_classroom" data-placeholder="" class="form-control m-b chosen-select-classroom" tabindex="4"> '+
    '                     <option value="">选择课室</option> '+ room_options +
    '                 </div> '+
    '              </div> '+
    '          </div> '+
    '          <div class="form-group"> '+
    '              <label class="col-sm-3 control-label">故障说明：</label> '+
    '              <div class="col-sm-8"> '+
    '                  <textarea id="ccomment" name="comment" class="form-control" required="" aria-required="true"></textarea> '+
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
}


/**
 * 新建条目
 * @param
 */
function newSolveButton(pid){
  var initTime = getFormatDate(new Date());
  var worker_options = "";
  name_list.forEach(function(item, index) {
      worker_options = worker_options + "<option value='" + wid_list[index] + "'>" + name_list[index] + "</option>"
  });

	$("#myModalLabelTitle").text("解决");
	$("#modalBody").html(
    '      <form class="form-horizontal m-t" id="commentForm"> '+
    '          <div class="form-group"> '+
    '              <label class="col-sm-3 control-label">发现人：</label> '+
    '              <div class="col-sm-8"> '+
    '                  <select id="select_name" name="select_name" data-placeholder="" class="chosen-select-name form-control m-b" tabindex="4"> '+
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
}
