<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-拍摄登记</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/js/plugins/layer/skin/layer.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/switchery/switchery.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/nouslider/nouislider.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/plugins/nouslider/nouislider.pips.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/plugins/nouslider/nouislider.tooltips.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/ionRangeSlider/ion.rangeSlider.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/plugins/ionRangeSlider/ion.rangeSlider.skinHTML5.css' ?>" rel="stylesheet">
    
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
                            <strong>拍摄</strong>
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
                                <h5>查看和登记拍摄</h5>
                                <div class="btn_group"
                                     style="margin-right:15px;margin-left:auto;width:50px;text-align: right;">
                                    <button class="btn btn-primary btn-xs" id="new_record_btn" onclick="new_record()"
                                            data-toggle="modal" data-target="#myModal">新增记录
                                    </button>
                                </div>
                            </div>
                            <div class="ibox-content">

                                <table id="dutyout_table"
                                       class="table table-striped table-bordered table-hover users-dataTable">
                                    <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>日期</th>
                                        <th>姓名</th>
                                        <th>拍摄名称</th>
                                        <th>后期名称</th>
                                        <th>工时</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php /*for ($i = 0; $i < count($d_doid); $i++) { ?>
                                        <tr class="duty_content" id="duty_content_<?php echo $d_doid[$i]; ?>">
                                            <td><?php echo $d_doid[$i]; ?></td>
                                            <td><?php echo $d_room[$i]; ?></td>
                                            <td><?php echo $d_description[$i]; ?></td>
                                            <td><?php echo "星期" . $d_weekdaytranslate[$i] . "&nbsp;" . $d_periodtime[$i]; ?></td>
                                            <td><?php echo $d_outtime[$i]; ?></td>
                                            <td><?php echo $d_name[$i]; ?></td>
                                            <td>
                                                <?php
                                                if ($d_solvetime[$i] != false) {
                                                    echo $d_solvetime[$i];
                                                } else {
                                                    echo "<span style=\"color:red;\">待解决</span>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($d_solvename[$i] != false) {
                                                    echo $d_solvename[$i];
                                                } else {
                                                    echo "&nbsp;";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($d_solution[$i] != false) {
                                                    echo $d_solution[$i];
                                                } else {
                                                    echo "&nbsp;";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($d_solvetime[$i] == false) {
                                                    echo "<div class='btn-group' id='duty_btn_group_" . $d_doid[$i] . "'>";
                                                    echo "<button class='btn btn-primary btn-xs' id='duty_btn_solve_" .
                                                        $d_doid[$i] . "' onclick='solve_by_pid(" . $d_problemid[$i] . ")'" .
                                                        " data-toggle='modal' data-target='#myModal'>解决</button>";
                                                    if ($_SESSION['user_id'] == $d_uid[$i] || $_SESSION['level'] >= 2) {
                                                        echo "<button class='btn btn-danger btn-xs' id='duty_btn_delete_" . $d_doid[$i] . "' onclick='delete_by_doid(" . $d_doid[$i] . ")'>删除</button>";
                                                        //echo var_dump($_SESSION['user_id'], $d_uid[$i]);
                                                    }
                                                    echo "</div>";
                                                } else {
                                                    echo "<div class='btn-group' id='duty_btn_group_" . $d_doid[$i] . "'>";
                                                    //echo "<button class='btn btn-primary btn-xs' id='duty_btn_solve_".$d_doid[$i]."'>解决</button>";
                                                    if ($_SESSION['user_id'] == $d_uid[$i] || $_SESSION['level'] >= 2) {
                                                        echo "<button class='btn btn-danger btn-xs' id='duty_btn_delete_" . $d_doid[$i] . "' onclick='delete_by_doid(" . $d_doid[$i] . ")'>删除</button>";
                                                    } else {
                                                        echo "<p>已解决</p>";
                                                    }
                                                    echo "</div>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } */?>
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
    
    <?php $this->load->view('view_modal'); ?>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/filming_in.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-workrecord").addClass("active");
			$("#active-filming").addClass("active");
			$("#mini").attr("href", "Filming#");
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

    <!-- iCheck -->
    <script src="<?= base_url() . 'assets/js/plugins/iCheck/icheck.min.js' ?>"></script>

    <!-- Chosen -->
    <script src="<?= base_url() . 'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

    <!-- JSKnob -->
    <script src="<?= base_url() . 'assets/js/plugins/jsKnob/jquery.knob.js' ?>"></script>

    <!-- Input Mask-->
    <script src="<?= base_url() . 'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>

    <!-- Date picker -->
    <script src="<?= base_url() . 'assets/js/plugins/datepicker/bootstrap-datepicker.js' ?>"></script>

    <!-- Date time picker -->
    <script src="<?= base_url() . 'assets/js/plugins/datetimepicker/bootstrap-datetimepicker.js' ?>"></script>
    <script src="<?= base_url() . 'assets/js/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js' ?>"></script>

    <!-- Data Tables -->
    <script src="<?= base_url() . 'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?= base_url() . 'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>
    
	<script> 
		$(document).ready(function () {

			/* ios switch */
			var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {
                color: '#1AB394'
            });

            /* ionRangeSlider */
            $("#range_slider").ionRangeSlider({
            	min: +moment().subtract(6, "hours").format("X"),
                max: +moment().add(5, "hours").format("X"),
                from: +moment().subtract(2, "hours").format("X"),
                to: +moment().format("X"),
                type: "double",
                keyboard: true,
                keyboard_step: 1,
                grid: true,
                grid_num: 11,
                prettify: function (num) {
                	return moment(num, "X").format("HH:mm");
                }
            });
            
		});
	</script>

</body>

</html>
