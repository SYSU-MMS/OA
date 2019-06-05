<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>MOA-签到</title>
    <?php $this->load->view('view_keyword'); ?>

    <link href="<?= base_url() . 'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?= base_url() . 'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?= base_url() . 'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">

<!--     <link href="<?= base_url() . 'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet"> -->
    <link href="<?= base_url() . 'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">


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
                        <strong>签到</strong>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span id="table_title"><h5>选择签到</h5></span>
                            <div class="ibox-tools">
                                <button type="button" class="btn btn-primary btn-xs manager" data-toggle="modal"
                                        href="DutyRegister#modal-new-table">添加签到人
                                </button>
                            </div>
                        </div>
                        <div id="table-contianer" class="ibox-content" style="padding-bottom: 20px;">
                            <div class="row" style="margin-bottom: 15px; color: orangered">
                                <div class="col-sm-12" id="reg_note">
                                    备注
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover users-dataTable">
                                <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th>用户名</th>
                                    <th>签到时间</th>
                                    <th>签到</th>
                                </tr>
                                </thead>
                                <tbody id="register-table">
                                </tbody>
                            </table>
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
                                    <i class="fa fa-2x fa-ban"></i> ：签到截止
                                </div>
                                <div class="col-sm-3 can-be-register">
                                    <i class="fa fa-2x fa-check-circle"></i> ：可签到
                                </div>
                                <div class="col-sm-3 can-be-canceled">
                                    <i class="fa fa-2x fa-check-circle"></i> ：已签到
                                </div>
                                <div class="col-sm-3 cannot-be-canceled">
                                    <i class="fa fa-2x fa-check-circle"></i> ：已签到且签到截止
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

<div id="modal-new-table" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class='modal-title' id="modal_header" style='text-align: center'>添加签到人</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-10">
                            <input id="table_name" name="username" class="form-control" type="text"
                                   placeholder="请输入添加人的名字" value="" placeholder="姓名">
                        </div>
                    </div>
                    <div id="table-contianer" class="ibox-content" style="padding-bottom: 20px;">
                        <table class="table table-striped table-bordered table-hover users-dataTable">
                            <thead>
                            <tr>
                                <th>用户id</th>
                                <th>姓名</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="adding-list">
                            </tbody>
                        </table>
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
<script src="<?= base_url() . 'assets/js/sign_register_register.js' ?>"></script>

<!-- nav item active -->
<script>
    $(document).ready(function () {
        $("#active-sign").addClass("active");
        //$("#active-DutyRegister").addClass("active");
        $("#mini").attr("href", "<?php echo $signid?>#");
        load_table(<?php echo $signid?>);
        signid = <?php echo $signid?>;
        $('#table_name').keyup(function(){
            name = $("#table_name").val();
            getUser(name);
        });
    });
</script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url() . 'assets/js/hplus.js?v=2.2.0' ?>"></script>
<script src="<?= base_url() . 'assets/js/plugins/pace/pace.min.js' ?>"></script>

<!-- Dynamic date -->
<script src="<?= base_url() . 'assets/js/dynamicDate.js' ?>"></script>

<!-- Jquery Validate -->
<script type="text/javascript" src="<?= base_url() . 'assets/js/plugins/validate/messages_zh.min.js' ?>"></script>

<!-- Chosen -->
<script src="<?= base_url() . 'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

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
