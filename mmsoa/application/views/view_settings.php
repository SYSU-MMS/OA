<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>MOA-系统设置</title>
    <?php $this->load->view('view_keyword'); ?>

<link href="<?= base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

<link href="<?= base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
<link href="<?= base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

<link href="<?= base_url().'assets/css/animate.css' ?>" rel="stylesheet">
<link href="<?= base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

<!-- Data Tables -->
<link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">
<!-- Date Picker -->
<link href="<?=base_url().'assets/css/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet">

<link href="<?=base_url().'assets/css/plugins/timepicker/jquery.timepicker.css' ?>" rel="stylesheet">

<style>
    #term_form {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        background-color: #ffffff;
        border-bottom-color: #e7eaec;
        border-bottom-style: solid;
        border-bottom-width: 4px;
        color: inherit;
        margin-bottom: 15px;
        padding: 14px 15px 7px;
        min-height: 48px;
    }

    #DataTables_Table_0_filter {
        display: none;
    }

    .time {
        padding: 6px 12px;
        margin-right: 20px;
    }
</style>
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
                        系统设置
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5 id="now-term"></h5>
                        </div>
                        <div class="ibox-content" style="padding-bottom: 20px;">
                            <form class="form-inline row" id="term_form">
                                <div class="form-group col-lg-3">
                                    <label class="form-normal">学年</label>
                                    <div class="input-daterange input-group" id="dtp">
                                        <select class="input-sm form-control dtp-input-div" id="year_a">
                                        </select>
                                        <span class="input-group-addon dtp-addon">-</span>
                                        <select class="input-sm form-control dtp-input-div" id="year_b">
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label class="form-normal">学期</label>
                                    <select class="form-control" id="term">
                                        <option value="春季学期">春季学期</option>
                                        <option value="秋季学期">秋季学期</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4" id="dtp_group">
                                    <div class="input-daterange input-group" id="dtp">
                                        <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" value="<?php date_default_timezone_set("PRC"); echo date('Y-m-d', time()); ?>" />
                                        <span class="input-group-addon dtp-addon">到</span>
                                        <input type="text" id="end_dtp" class="input-sm form-control dtp-input-div" name="end" placeholder="结束时间" value="<?php echo date_default_timezone_set("PRC"); date('Y-m-d',strtotime("+180 day")); ?>" />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button type="submit" class="btn btn-primary btn-longer" onclick="new_term();">新建学期</button>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class=" btn btn-primary" data-toggle="collapse" data-target="#term_table">查看学期列表</button>
                                    <div class="collapse" id="term_table">
                                        <table class="table table-striped table-bordered table-hover users-dataTable">
                                            <thead>
                                            <tr>
                                                <th>序号</th>
                                                <th>学年</th>
                                                <th>学期</th>
                                                <th>开始日期</th>
                                                <th>结束日期</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody id="term-list">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>工薪设置</h5>
                        </div>
                        <div class="ibox-content" style="padding-bottom: 20px;">
                            <form class="form-inline row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-normal">工薪(RMB/工时)：</label>
                                        <input type="text" id="salary_setting" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" data-toggle="modal"
                                                style="margin-bottom: 0" onclick="salary_submit();">提交</button>
                                    </div>
                                    <div class="form-group">
                                        <div class="alert alert-danger"
                                             id="salary_warning"
                                             style="margin-bottom: 0;padding: 6px 12px;display: none">
                                            请输入数字(>0)
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>值班时间表设置</h5>
                        </div>
                        <div class="ibox-content" style="padding-bottom: 20px;">
                            <form class="form-inline row">
                                <div class="col-lg-6">
                                    <div class="form-group ibox-title col-lg-12" style="border-width: 0 0 0">
                                        <h5>周一至周五值班时段设置</h5>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <button data-toggle="modal" class="form-control btn btn-primary col-lg-6"
                                                style="margin-bottom: 0" onclick="add_tp('timepoint_weekday', timepoint_weekday);">
                                            添加换班点（包括上下班点）
                                        </button>
                                        <button data-toggle="modal" class="form-control btn btn-primary col-lg-3"
                                                style="margin-bottom: 0" onclick="sort_tp('timepoint_weekday', timepoint_weekday);">
                                            排序
                                        </button>
                                        <button data-toggle="modal" class="btn btn-primary" id="submit_timepoint_weekday"
                                                style="margin-bottom: 0" onclick="submit_tp('timepoint_weekday', timepoint_weekday)">
                                            提交
                                        </button>
                                    </div>
                                    <div id="timepoint_weekday" class="form-group ibox-content col-lg-12"
                                         style="margin-top: 10px"></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group ibox-title col-lg-12" style="border-width: 0 0 0">
                                        <h5>周末值班时段设置</h5>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <button data-toggle="modal" class="form-control btn btn-primary col-lg-6"
                                                style="margin-bottom: 0" onclick="add_tp('timepoint_weekend', timepoint_weekend);">
                                            添加换班点（包括上下班点）
                                        </button>
                                        <button data-toggle="modal" class="form-control btn btn-primary col-lg-3"
                                                style="margin-bottom: 0" onclick="sort_tp('timepoint_weekend', timepoint_weekend);">
                                            排序
                                        </button>
                                        <button data-toggle="modal" class="btn btn-primary" id="submit_timepoint_weekend"
                                                style="margin-bottom: 0" onclick="submit_tp('timepoint_weekend', timepoint_weekend)">
                                            提交
                                        </button>
                                    </div>
                                    <div id="timepoint_weekend" class="form-group ibox-content col-lg-12"
                                         style="margin-top: 10px"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('view_footer'); ?>
    </div>
</div>

<!-- Mainly scripts -->
<script src="<?= base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
<script src="<?= base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/timepicker/jquery.timepicker.min.js' ?>"></script>

<!-- nav item active -->
<script>
    $(document).ready(function () {
        $("#active-systemConfig").addClass("active");
        $("#active-active-sysreset").addClass("active");
        $("#mini").attr("href", "Settings#");
    });
</script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>

<!-- Dynamic date -->
<script src="<?= base_url().'assets/js/dynamicDate.js' ?>"></script>

<!-- Chosen -->
<script src="<?= base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

<!-- Data Tables -->
<script src="<?= base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>

<!-- Date time picker -->
<script src="<?=base_url().'assets/js/plugins/datepicker/bootstrap-datepicker.js' ?>"></script>
<script src="<?=base_url().'assets/js/plugins/datepicker/bootstrap-datepicker.zh-CN.min.js' ?>"></script>

<script src="<?= base_url().'assets/js/settings.js' ?>"></script>


<script>
    $(document).ready(function () {
        $('#start_dtp').datepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            forceParse: 1
        });
        $('#end_dtp').datepicker({
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            forceParse: 1
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
