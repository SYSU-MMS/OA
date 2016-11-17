<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-查看值班记录</title>
    <?php $this->load->view('view_keyword'); ?>

<link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

<link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
<link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

<link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">

<link href="<?=base_url().'assets/css/plugins/simditor/simditor.css' ?>" rel="stylesheet">

<link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">

<link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">

<link href="<?=base_url().'assets/css/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet">

<!-- Data Tables -->
<link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">

<link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
<link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

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
                        工作记录
                    </li>
                    <li>
                        <strong>出勤记录</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>查看和登记出勤</h5>
                        </div>
                        <div class="ibox-content">

                            <table class="table table-striped table-bordered table-hover users-dataTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>周次</th>
                                    <th>星期</th>
                                    <th>姓名</th>
                                    <th>值班时段</th>
                                    <th>代班</th>
                                    <th>登记时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php for ($i = 0; $i < $d_count; $i++) { ?>
                                    <tr>
                                        <td><?php echo $i + 1; ?></td>
                                        <td><?php echo $d_weekcount; ?></td>
                                        <td><?php echo $d_weekday; ?></td>
                                        <td><?php echo $d_name_list[$i]; ?></td>
                                        <td><?php echo $d_duration_list[$i]; ?></td>
                                        <td>
                                            <?php
                                            if ($d_sub_list[$i] == '') {
                                                echo '无';
                                            } else {
                                                echo $d_sub_list[$i];
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $d_time_list[$i]; ?></td>
                                    </tr>
                                <?php } ?>
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

<!-- Mainly scripts -->
<script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
<script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
<script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
<script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
<!-- <script src="<?=base_url().'assets/js/searchuser.js' ?>"></script> -->

<!-- nav item active -->
<script>
    $(document).ready(function () {
        $("#active-workReview").addClass("active");
        $("#active-dutyReview").addClass("active");
        $("#mini").attr("href", "dutyReview#");
    });
</script>

<!-- Custom and plugin javascript -->
<script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
<script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>

<!-- Dynamic date -->
<script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>

<!-- Jquery Validate -->
<script type="text/javascript" src="<?=base_url().'assets/js/plugins/validate/jquery.validate.min.js' ?>"></script>
<script type="text/javascript" src="<?=base_url().'assets/js/plugins/validate/messages_zh.min.js' ?>"></script>

<!-- iCheck -->
<script src="<?=base_url().'assets/js/plugins/iCheck/icheck.min.js' ?>"></script>

<!-- Chosen -->
<script src="<?=base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

<!-- JSKnob -->
<script src="<?=base_url().'assets/js/plugins/jsKnob/jquery.knob.js' ?>"></script>

<!-- Input Mask-->
<script src="<?=base_url().'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>

<!-- Date picker -->
<script src="<?=base_url().'assets/js/plugins/datepicker/bootstrap-datepicker.js' ?>"></script>

<!-- Data Tables -->
<script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
<script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>

<script>
    $(document).ready(function () {

        $('.users-dataTable').dataTable();

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
