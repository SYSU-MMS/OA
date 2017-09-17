var toggle_more_para = true;

function toggle_more(){
    var table = $('#found_table').DataTable();
    var visible_list = [1, 5, 7, 8, 11, 12];
    for (var i = 0; i <= 5; i++){
        table.column(visible_list[i]).visible(toggle_more_para);
    }
    $('#found_table').attr("style", "width: 100%;");
    toggle_more_para = !toggle_more_para;
}