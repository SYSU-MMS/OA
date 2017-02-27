/**
 * 代班记录
 */

/*
 * 拉取数据之后，更新表格
 */
function updateTable(data) {
  // 销毁原来的datatable
  $('.users-dataTable').dataTable({
        "filter": false,
        "destroy": true
        });

  // 装载新表数据-代班
  var m_data_arr = [];
  for (var i = 0; i < data.length; i++) {

    // 各行数据
    m_data_arr.push(
        "<tr>" +
          "<td>" + (i + 1) +"</td>" +
          "<td>" + data[i].m_name +"</td>" +
          "<td>" + data[i].m_substituteFor +"</td>" +
          "<td>" + data[i].m_type +"</td>" +
          "<td>" + data[i].m_time +"</td>" +
        "</tr>"
    );
  }

  // 表格
  $('#base').empty().html(
    "<table class='table table-striped table-bordered table-hover users-dataTable'>" +
                "<thead>" +
                    "<tr>" +
                      "<th>序号</th>" +
                        "<th>代班人</th>" +
                        "<th>被代班人</th>" +
                        "<th>代班类型</th>" +
                        "<th>时间</th>" +
                    "</tr>" +
                "</thead>" +
                "<tbody>" +
                  m_data_arr.join("") +
                  "</tbody>" +
              "</table>"
  );

  // 重新实例化datatable
  $('.users-dataTable').dataTable({
    "iDisplayLength": 25,
        "bProcessing": false
        });
}

/*
 * 通过获取exportSubstituteExcel接口生成excel文件
 * 再通过/getExcel路由来下载文件
 */
function getExcel() {
    // 增加秒
    var start_time = $('#start_dtp').val() + ":00";
    var end_time = $('#end_dtp').val() + ":59";
    var wid = $('#select_name').val();

    // -1 代表选择全部
    if(!wid) {
      wid = -1;
    }
    $.ajax({
      type: "POST",
      url: "exportSubstituteExcel",
      data: {
        "start_time": start_time,
        "end_time": end_time,
        "actual_wid": wid
      },
      success: function(msg) {
          // 通过请求/getExcel来下载文件
          var href = window.location.href;
          var pos = href.lastIndexOf('/');
          var excelUrl = href.substring(0, pos) + '/getExcel';
          window.open(excelUrl);
      },
      error: function(){
          alert(arguments[1]);
      }
    });
}

/*
 * 实现搜索功能，并进行渲染
 */

$('#search_btn').click(function(){
	// 增加秒
	var start_time = $('#start_dtp').val() + ":00";
	var end_time = $('#end_dtp').val() + ":59";
	var wid = $('#select_name').val();

  // -1 代表选择全部
  if(!wid) {
    wid = -1;
  }

	$.ajax({
		type: "POST",
		url: "historyTemporaryWork",
		data: {
			"start_time": start_time,
			"end_time": end_time,
			"actual_wid": wid
		},
		success: function(msg) {
			ret = JSON.parse(msg);
			if (ret['status'] === false) {
				alert(ret['msg']);
			} else {
        var xhr_data = ret['data'].substituteList;
        updateTable(xhr_data);
			}
		},
		error: function(){
		    alert(arguments[1]);
		}
	});
});


/*
 * 用于再次确认选择框的渲染
 */
$('#excel_btn').click(function(){
	// 增加秒
	var start_time = $('#start_dtp').val() + ":00";
	var end_time = $('#end_dtp').val() + ":59";
	var wid = $('#select_name').val();

  // -1 代表选择全部
  if(!wid) {
    wid = -1;
  }

  var peopleName = (wid == -1) ? "全部" : wid;

  $("#myModalLabelTitle").text("确认信息");
	$("#modalBody").html(
    '      <form class="form-horizontal m-t" id="commentForm"> '+
    '          <div class="form-group"> '+
    '              <label class="col-sm-3 control-label">开始时间：</label> '+
    '              <div class="col-sm-8"> '+
    '                  <span type="text" id="start_t" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间">'+ start_time +'</span>'+
    '              </div>' +
    '          </div> '+
    '          <div class="form-group"> '+
    '              <label class="col-sm-3 control-label">结束时间：</label> '+
    '              <div class="col-sm-8"> '+
    '                  <span type="text" id="end_t" class="input-sm form-control dtp-input-div" name="start" placeholder="结束时间" >'+ end_time +'</span>'+
    '              </div>' +
    '          </div> '+
    '          <div class="form-group"> '+
    '              <label class="col-sm-3 control-label">代班助理：</label> '+
    '              <div class="col-sm-8"> '+
    '                  <span type="text" id="people_name" class="input-sm form-control dtp-input-div" name="start" placeholder="代班助理" >'+peopleName + '</span>'+
    '              </div>' +
    '          </div> '+
    '          <div class="form-group"> '+
    '              <div style="float:right" class="col-sm-4 col-sm-offset-3"> '+
    '                  <button onclick="getExcel()" class="btn btn-primary" type="submit">提交</button> '+
    '                  <button data-dismiss="modal" class="btn btn-danger" type="submit">取消</button> '+
    '              </div> '+
    '          </div> '+
    '      </form> '
	);
});
