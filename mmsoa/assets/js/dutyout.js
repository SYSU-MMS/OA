/**
 * Created by Jerry on 2016/11/20.
 */
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

function solve_by_doid(doid) {

}