<!DOCTYPE html>
<html>
<!--批量修改工时
made by 钟凌山-->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>MOA-批量修改工时</title>
    <?php $this->load->view('view_keyword'); ?>

    <link href="<?= base_url() . 'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?= base_url() . 'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?= base_url() . 'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">

    <link href="<?= base_url() . 'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?= base_url() . 'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">

    <link href="<?= base_url() . 'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

</head>

<body onload="startTime()">
<div id="wrapper">
    <?php $this->load->view('view_nav'); ?>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php $this->load->view('view_header'); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2 id="time"></h2>
                <ol class="breadcrumb">
                    <li>
                        MOA
                    </li>
                    <li>
                        工时统计
                    </li>
                    <li>
                        <strong>批量调整工时</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 9;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>批量调整工时</h5>
                        </div>
                        <div class="ibox-content" style="padding: 30px 65px;">
                            <h6>快速按组选择助理,或在下方添加、删除单个助理</h6>
                            <div id="batch_edit_btn_group" style="width:100%">
                                <div class="btn-group" id="select_edit_group" style="float:left;">
                                    <button type="button" class="btn btn-xs btn-primary" id="select_group_1" onclick="batchSelect(1)">A组</button>
                                    <button type="button" class="btn btn-xs btn-primary" id="select_group_2" onclick="batchSelect(2)">B组</button>
                                    <button type="button" class="btn btn-xs btn-primary" id="select_group_3" onclick="batchSelect(3)">C组</button>
                                    <button type="button" class="btn btn-xs btn-primary" id="select_group_4" onclick="batchSelect(4)">视频组
                                    </button>
                                    <button type="button" class="btn btn-xs btn-primary" id="select_group_5" onclick="batchSelect(5)">系统组
                                    </button>
                                </div>
                                <div class="btn-group" id="select_reset_group" style="float:right;">
                                    <button type="button" class="btn btn-xs btn-danger" id="select_reset" onclick="removeBatchSelect()">清空</button>
                                </div>
                            </div>
                            <select id="select_worker" data-placeholder="选择助理" class="chosen-select" multiple
                                    tabindex="4">
                                <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
                                    <option value="<?php echo $wid_list[$i]; ?>" hassubinfo="true" id="<?php echo 'wid_'.$wid_list[$i];?>" class="<?php echo 'group_'.$group_list[$i]?>">
                                        <?php echo $name_list[$i]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div id="batch_edit_submit_group" style="width:100%;padding-top:3px;">
                                <div class="btn-group" id="batch_edit_submit_area"
                                     style="padding-right:0px;position:relative;">
                                    <button type="button" data-toggle="modal" data-target="#myModal"
                                            id="reward_group_button"
                                            name="reward_group_button" class="btn btn-primary"
                                            onclick="rewardGroupButton()">
                                        增加
                                    </button>
                                    <button type="button" data-toggle="modal" data-target="#myModal"
                                            id="reduce_group_button"
                                            name="reduce_group_button" class="btn btn-danger"
                                            onclick="reduceGroupButton()">
                                        减少
                                    </button>
                                    <button type="button" data-toggle="modal" data-target="#myModal"
                                            id="penalty_group_button_"
                                            name="penalty_group_button" class="btn btn-danger"
                                            onclick="penaltyGroupButton()">
                                        扣除
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('view_footer'); ?>
    </div>
</div>

<?php $this->load->view('view_modal'); ?>

<!-- Mainly scripts -->
<script src="<?= base_url() . 'assets/js/jquery-2.1.1.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/batch_edit_working_time.js' ?>"></script>

<!-- nav item active -->
<script>
    $(document).ready(function () {
        $("#active-timeStatistics").addClass("active");
        $("#active-batchEditWorkingTime").addClass("active");
        $("#mini").attr("href", "batchEditWorkingTime#");
    });
</script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url() . 'assets/js/hplus.js?v=2.2.0' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/pace/pace.min.js' ?>"></script>

<!-- Dynamic date -->
<script src="<?= base_url() . 'assets/js/dynamicDate.js' ?>"></script>

<!-- Jquery Validate -->
<script type="text/javascript" src="<?= base_url() . 'assets/js/plugins/validate/jquery.validate.min.js' ?>"></script>
<script type="text/javascript" src="<?= base_url() . 'assets/js/plugins/validate/messages_zh.min.js' ?>"></script>

<!-- Chosen -->
<script src="<?= base_url() . 'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

<!-- Input Mask-->
<script src="<?= base_url() . 'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>

<!-- Data Tables -->
<script src="<?= base_url() . 'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>

<script>
    /* Chosen */
    var config = {
        '.chosen-select': {
            // 实现中间字符的模糊查询
            search_contains: true,
            no_results_text: "没有找到",
            width: "80px"
        },
        '.chosen-select-deselect': {
            allow_single_deselect: true
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "95%"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

</script>

</body>

</html>
