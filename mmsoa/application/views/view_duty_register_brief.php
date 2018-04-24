<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>MOA-值班报名</title>
    <?php $this->load->view('view_keyword'); ?>

    <link href="<?= base_url() . 'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?= base_url() . 'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?= base_url() . 'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?= base_url() . 'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">
    <!-- Date Picker -->
    <link href="<?=base_url().'assets/css/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/timepicker/jquery.timepicker.css' ?>" rel="stylesheet">

</head>
<style>
    <?php
        $is_manager = ($_SESSION['level'] >= 2);
        if (!$is_manager) {
            echo '.manager { display: none !important; }';
            echo "@media (min-width: 768px) { .manager { display: none !important; } }";
        } else {
            echo '.viewer { display: none !important; }';
        }
    ?>
    .datepicker
    {
     z-index: 9999 !important;
    }
</style>

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
                        特殊值班报名
                    </li>
                    <?php
                    if ($is_manager) echo "<li><strong>管理</strong></li>";
                    ?>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>所有报名表</h5>
                            <div class="ibox-tools">
                                <button type="button" class="btn btn-primary btn-xs manager" data-toggle="modal"
                                        href="DutyRegister#modal-new-table">新建报名表
                                </button>
                            </div>
                        </div>
                        <div id="table-contianer" class="ibox-content" style="padding-bottom: 20px;">
                            <table class="table table-striped table-bordered table-hover users-dataTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>创建时间</th>
                                    <th>报名开始时间</th>
                                    <th>报名结束时间</th>
                                    <th>标题</th>
                                    <th>每个时段的报名限额</th>
                                    <th>每人报名限额</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody id="register-list">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('view_footer'); ?>
    </div>
</div>

<div id="modal-new-table" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class='modal-title' id="modal_header" style='text-align: center'>新建报名表</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">标题</label>
                        <div class="col-sm-10">
                            <input id="table_title" name="table_title" class="form-control" type="text"
                                   placeholder="请输入报名表标题" value="新建报名表">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">人数/时间段</label>
                        <div class="col-sm-10">
                            <select id="reg_max" class="form-control" name="reg_max">
                                <option value="1">1人/时间段</option>
                                <option value="2">2人/时间段</option>
                                <option value="3">3人/时间段</option>
                                <option value="4">4人/时间段</option>
                                <option value="5">5人/时间段</option>
                                <option value="6">6人/时间段</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">每人限额</label>
                        <div class="col-sm-10">
                            <select id="reg_max_per_user" class="form-control" name="reg_max">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-2 control-label">报名时间</label>
                        <div class="col-sm-3">
                            <input type="text" id="reg_start" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" value="<?php echo date('Y-m-d', time()); ?>" />
                        </div>
                        <div class="col-sm-2 text-center">
                            <a class="form-control" style="border: hidden;">到</a>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" id="reg_end" class="input-sm form-control dtp-input-div" name="end" placeholder="结束时间" value="<?php echo date('Y-m-d',strtotime("+7 day")); ?>" />
                        </div>
                        <div class="col-sm-2 text-center">
                            &nbsp;
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <!-- 每天时段 -->
                    <div id="time_point_group">
                        <div class="form-group time_point_item">
                            <label class="col-sm-2 control-label">每天时段</label>
                            <div class="col-sm-3">
                                <input type="text" id="duty_start_0" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" />
                            </div>
                            <div class="col-sm-2 text-center">
                                <a class="form-control" style="border: hidden;">到</a>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id="duty_end_0" class="input-sm form-control dtp-input-div" name="end" placeholder="结束时间" />
                            </div>
                            <div class="col-sm-2 text-center">
                                <button class="btn btn-primary" onclick="append_tp();">添加</button>
                            </div>
                        </div>
                        <div class="form-group time_point_item">
                            <label class="col-sm-2 control-label"> </label>
                            <div class="col-sm-3">
                                <input type="text" id="duty_start_1" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" />
                            </div>
                            <div class="col-sm-2 text-center">
                                <a class="form-control" style="border: hidden;">到</a>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id="duty_end_1" class="input-sm form-control dtp-input-div" name="end" placeholder="结束时间" />
                            </div>
                            <div class="col-sm-2 text-center">
                                <button class="btn btn-danger" onclick="remove_tp(1);">删除</button>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">备注</label>
                        <div class="col-sm-10">
                            <textarea style="height: 100px; !important;" id="reg_note" class="input-sm form-control" name="note" placeholder="备注"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-5">
                            <a class="btn btn-primary" onclick="add_table();">提交</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('view_modal'); ?>

<!-- Mainly scripts -->
<script src="<?= base_url() . 'assets/js/jquery-2.1.1.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/timepicker/jquery.timepicker.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/duty_register_brief.js' ?>"></script>

<!-- nav item active -->
<script>
    $(document).ready(function () {
        $("#active-scheduleManagement").addClass("active");
        $("#active-DutyRegister").addClass("active");
        $("#mini").attr("href", "DutyRegister#");

        $('#reg_start').datepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            forceParse: 1
        });
        $('#reg_end').datepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            forceParse: 1
        });

        $("#duty_start_0").timepicker({"timeFormat": "H:i"}).val();
        $("#duty_end_0").timepicker({"timeFormat": "H:i"}).val();
        $("#duty_start_1").timepicker({"timeFormat": "H:i"}).val();
        $("#duty_end_1").timepicker({"timeFormat": "H:i"}).val();

        load_tables();
    });
</script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url() . 'assets/js/hplus.js?v=2.2.0' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/pace/pace.min.js' ?>"></script>

<!-- Dynamic date -->
<script src="<?= base_url() . 'assets/js/dynamicDate.js' ?>"></script>

<!-- Chosen -->
<script src="<?= base_url() . 'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

<!-- Data Tables -->
<script src="<?= base_url() . 'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>

<!-- Date time picker -->
<script src="<?=base_url().'assets/js/plugins/datepicker/bootstrap-datepicker.js' ?>"></script>
<script src="<?=base_url().'assets/js/plugins/datepicker/bootstrap-datepicker.zh-CN.min.js' ?>"></script>


<script>
    $(document).ready(function () {
        /* Calendar */
        $('#calendar_date .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

    });

    /* Chosen */
    var config = {
        '.chosen-select': {},
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
