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

    <link href="<?= base_url() . 'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">

    <link href="<?= base_url() . 'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?= base_url() . 'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">

    <link href="<?= base_url() . 'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

</head>

<style>
    .banned{
        color: rgba(168,83,74,0.38);
    }
    .banned:hover{
        color: rgba(168,83,74,0.38);
    }
    .banned:active{
        color: rgba(168,83,74,0.38);
    }
    .can-be-canceled{
        color: forestgreen;
    }
    .can-be-canceled:hover{
        color: orange;
    }
    .can-be-canceled:active{
        color: orange;
    }

    .cannot-be-canceled{
        color: dodgerblue;
    }
    .cannot-be-canceled:hover{
        color: dodgerblue;
    }
    .cannot-be-canceled:active{
        color: dodgerblue;
    }

    .can-be-register{
        color: orange;
    }
    .can-be-register:hover{
        color: forestgreen;
    }
    .can-be-register:active{
        color: forestgreen;
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
                    <li>
                        <strong>报名</strong>
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
                        <div class="ibox-title" id="table_title">
                            <h5>值班报名</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row" style="margin-bottom: 15px; color: orangered">
                                <div class="col-sm-12" id="reg_note">
                                    备注
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="row" style="margin-bottom: -15px;">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col" abbr="per">时段</th>
                                                <th scope="col" abbr="mon">周日</th>
                                                <th scope="col" abbr="tue">周一</th>
                                                <th scope="col" abbr="wed">周二</th>
                                                <th scope="col" abbr="thu">周三</th>
                                                <th scope="col" abbr="fri">周四</th>
                                                <th scope="col" abbr="fri">周五</th>
                                                <th scope="col" abbr="fri">周六</th>
                                            </tr>
                                            </thead>
                                            <tbody id="register-table">
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" id="table_title">
                            <h5>说明</h5>
                        </div>
                        <div class="ibox-content" style="padding-bottom: 20px;">
                            <div class="row">
                                <div class="col-sm-3 banned">
                                    <i class="fa fa-2x fa-ban"></i> ：未报名且不可报名
                                </div>
                                <div class="col-sm-3 can-be-register">
                                    <i class="fa fa-2x fa-check-circle"></i> ：可报名
                                </div>
                                <div class="col-sm-3 can-be-canceled">
                                    <i class="fa fa-2x fa-check-circle"></i> ：已报名
                                </div>
                                <div class="col-sm-3 cannot-be-canceled">
                                    <i class="fa fa-2x fa-check-circle"></i> ：已报名且报名截止
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

<!-- Mainly scripts -->
<script src="<?= base_url() . 'assets/js/jquery-2.1.1.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/duty_register_register.js' ?>"></script>

<!-- nav item active -->
<script>
    $(document).ready(function () {
        $("#active-scheduleManagement").addClass("active");
        $("#active-DutyRegister").addClass("active");
        $("#mini").attr("href", "<?php echo $drid?>#");
        load_table(<?php echo $drid?>);
        drid = <?php echo $drid?>;
    });
</script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url() . 'assets/js/hplus.js?v=2.2.0' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/pace/pace.min.js' ?>"></script>

<!-- Dynamic date -->
<script src="<?= base_url() . 'assets/js/dynamicDate.js' ?>"></script>

<!-- Jquery Validate -->
<script type="text/javascript" src="<?= base_url() . 'assets/js/plugins/validate/messages_zh.min.js' ?>"></script>

<!-- iCheck -->
<script src="<?= base_url() . 'assets/js/plugins/iCheck/icheck.min.js' ?>"></script>

<!-- Input Mask-->
<script src="<?= base_url() . 'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>

<!-- Data Tables -->
<script src="<?= base_url() . 'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>

<script>
    $(document).ready(function () {
        /* Radio */
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    });

</script>

</body>

</html>
