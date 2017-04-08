/**
 * Created by trigold
 */
$(document).ready(function () {
    var obj = $("#duty_free_weekday_tbody");
    for(var i = 1; i < weekday_breakpoint.length; ++i) {
        var tmp_str = "";
        tmp_str += '<tr>' +
            '<th scope="row">' + weekday_breakpoint[i - 1] +
            '-' + weekday_breakpoint[i] + '</th>';
        for(var j = 1; j <= 5; ++j) {
            tmp_str += '<td>' +
                schedule[j][i] +
                    '</td>';
        }
        tmp_str += '</tr>';
        obj.append(tmp_str);
    }
    obj = $("#duty_free_weekend_tbody");
    for(i = 1; i < weekend_breakpoint.length; ++i) {
        tmp_str = "";
        tmp_str += '<tr>' +
            '<th scope="row">' + weekend_breakpoint[i - 1] +
            '-' + weekend_breakpoint[i] + '</th>';
        for(j = 6; j <= 7; ++j) {
            tmp_str += '<td>' +
                schedule[j][i] +
                '</td>';
        }
        tmp_str += '</tr>';
        obj.append(tmp_str);
    }
});