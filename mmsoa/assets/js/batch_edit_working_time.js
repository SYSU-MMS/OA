/**
 * Created by Jerry on 2016/10/12.
 */
$(function () {
    $("#select_worker").css("width", "100%");
    $("#select_worker_chosen").css("width", "100%");
});

function rewardGroupButton() {
    $("#myModalLabel").text("批量增加工时");
    $(".modal-body").html(
        "<form id='inputTime' class='input-group input-group-sm'>" +
        "<div class='form-group'>" +
        "<div class='col-sm-7 col-sm-offset-2'>" +
        "<span id='timeAjustArea' class='input-group-btn'>" +
        "<input type='text' id='rewardTime' name='rewardTime' class='form-control' placeholder='工时'/>" +
        "<button type='button' id='reward' name='reward' class='btn btn-primary' onclick='toRewardGroup()'> 增加 </button>" +
        "</span>" +
        "</div>" +
        "</div>" +
        "</form>"
    );
}


function reduceGroupButton() {
    $("#myModalLabel").text("批量减少工时");
    $(".modal-body").html(
        "<form id='inputTime' class='input-group input-group-sm'>" +
        "<div class='form-group'>" +
        "<div class='col-sm-7 col-sm-offset-2'>" +
        "<span id='timeAjustArea' class='input-group-btn'>" +
        "<input type='text' id='reduceTime' name='reduceTime' class='form-control' placeholder='工时'/>" +
        "<button type='button' id='reduce' name='reduce' class='btn btn-primary' onclick='toReduceGroup()'> 减少 </button>" +
        "</span>" +
        "</div>" +
        "</div>" +
        "</form>"
    );
}


function penaltyGroupButton() {
    $("#myModalLabel").text("批量扣除工时");
    $(".modal-body").html(
        "<form id='inputTime' class='input-group input-group-sm'>" +
        "<div class='form-group'>" +
        "<div class='col-sm-7 col-sm-offset-2'>" +
        "<span id='timeAjustArea' class='input-group-btn'>" +
        "<input type='text' id='penaltyTime' name='penaltyTime' class='form-control' placeholder='工时'/>" +
        "<button type='button' id='penalty' name='penalty' class='btn btn-primary' onclick='toPenalizeGroup()'> 扣除 </button>" +
        "</span>" +
        "</div>" +
        "</div>" +
        "</form>"
    );
}


function toRewardGroup() {
    var rewardTime = parseInt($("#rewardTime").val());
    var wids = $("#select_worker").val();
    console.log(rewardTime,wids);
    $.ajax({
        type: 'POST',
        url: 'batchEdit',
        data: {
            'wids': wids,
            'time': rewardTime,
        },
        success: function (msg) {
            console.log(msg);
            var ret = JSON.parse(msg);
            if (ret["status"] === false) {
                $("#submit_result").attr("style", "color:#ED5565;text-align:center;");
                $("#submit_result").html(ret["msg"]);
            } else {
                $("#submit_result").attr("style", "color:#1AB394;text-align:center;");
                $("#submit_result").html(ret["msg"]);
                // 锁定所有按钮和输入框
                $('.chosen-select').prop('disabled', true).trigger("chosen:updated");
                $("div #batch_edit_submit_area button").attr("disabled", true);
                console.log("yes");
            }
        },
        error: function () {
            alert(arguments[1]);
        }
    });
}


function toReduceGroup() {
    var reduceTime = parseInt($("#reduceTime").val());
    var wids = $("#select_worker").val();
    $.ajax({
        type: 'POST',
        url: 'batchEdit',
        data: {
            'wids': wids,
            'time': -reduceTime,
        },
        success: function (msg) {
            var ret = JSON.parse(msg);
            if (ret["status"] === false) {
                $("#submit_result").attr("style", "color:#ED5565;text-align:center;");
                $("#submit_result").html(ret["msg"]);
            } else {
                $("#submit_result").attr("style", "color:#1AB394;text-align:center;");
                $("#submit_result").html(ret["msg"]);
                // 锁定所有按钮和输入框
                $('.chosen-select').prop('disabled', true).trigger("chosen:updated");
                $("#submit_duty").attr("disabled", true);
            }
        },
        error: function () {
            alert(arguments[1]);
        }
    });
}


function toPenalizeGroup() {
    var penaltyTime = parseInt($("#penaltyTime").val());
    var wids = $("#select_worker").val();
    $.ajax({
        type: 'POST',
        url: 'batchPenalize',
        data: {
            'wids': wids,
            'time': penaltyTime,
        },
        success: function (msg) {
            var ret = JSON.parse(msg);
            if (ret["status"] === false) {
                $("#submit_result").attr("style", "color:#ED5565;text-align:center;");
                $("#submit_result").html(ret["msg"]);
            } else {
                $("#submit_result").attr("style", "color:#1AB394;text-align:center;");
                $("#submit_result").html(ret["msg"]);
                // 锁定所有按钮和输入框
                $('.chosen-select').prop('disabled', true).trigger("chosen:updated");
                $("#submit_duty").attr("disabled", true);
            }
        },
        error: function () {
            alert(arguments[1]);
        }
    });
}