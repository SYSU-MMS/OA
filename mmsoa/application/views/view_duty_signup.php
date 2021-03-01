<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-值班报名</title>
    <?php $this->load->view('view_keyword'); ?>

    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">

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
                        	值班安排
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
                            <div class="ibox-title">
                                <h5>值班报名</h5>
                                <?php
                                	// 助理负责人，超级管理员才可以导出报名情况
						        	if ($_SESSION['level'] == 3 || $_SESSION['level'] == 6) {
						        		echo '<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-danger exportSignupBtn"><i class="fa fa-trash-o"></i><span> 清空报名记录</span></button>' .
								        		'<a id="export_signup" class="btn btn-primary exportSignupBtn" href="' . site_url('DutySignUp/exportToTxt') . '"><i class="fa fa-download"></i><span> 导出空余表</span></a>';								        		;
						        	}
						        ?>
                            </div>
                            <div class="ibox-content">
                            	<form method="POST" action="<?php echo site_url('DutySignUp/signUp'); ?>">
                                   
                                    <select id="select_name" name="select_name" data-placeholder="" class="chosen-select auto-select" tabindex="4">
                                        <option value="">本人</option>
                                        <?php
                                            if ($_SESSION['level'] != 0) {
                                                for ($i = 0; $i < count($name_list); $i++) {
                                                    echo "<option value='" . $wid_list[$i] . "'>" . $name_list[$i] . "</option>";
                                                }
                                            }
                                        ?>
                                    </select>

                            		<div class="row form-group" id="radio_group" style="margin: 10px 35px 23px 0px;">
                            			<div class="col-sm-1 col-sm-offset-2">
                            				<label class="control-label" for="groupid"> 组别 </label>
                            			</div>
										<div class="col-sm-6">
											<label class="radio-inline radio-font-size">
										        <input type="radio" checked="" value="N" id="group_N" name="groupid"> A/B</label>
										    <label class="radio-inline radio-font-size">
										        <input type="radio" value="A" id="group_A" name="groupid"> A </label>
										    <label class="radio-inline radio-font-size">
										        <input type="radio" value="B" id="group_B" name="groupid"> B </label>
										    <label class="radio-inline radio-font-size">
										        <input type="radio" value="C" id="group_C" name="groupid"> C </label>
										</div>
									</div>
									<div class="form-group">
										<div class="row" style="margin-bottom: -15px;">
											<div class="col-sm-8">
						                        <table class="table table-bordered table-hover">
						                            <thead>
						                                <tr>
						                                    <th scope="col" abbr="per">时段</th>
						                                    <th scope="col" abbr="mon">周一</th>
						                                    <th scope="col" abbr="tue">周二</th>
						                                    <th scope="col" abbr="wed">周三</th>
						                                    <th scope="col" abbr="thu">周四</th>
						                                    <th scope="col" abbr="fri">周五</th>
						                                </tr>
						                            </thead>
						                            <tbody>
                                                    <?php
                                                    for($i = 1; $i < count($weekday_breakpoint); ++$i) {
                                                        echo '<tr>' . '<th scope="row">'.$weekday_breakpoint[$i - 1] .
                                                            '-' . $weekday_breakpoint[$i] . '</th>';
                                                        for($j = 0; $j < 5; ++$j) {
                                                            echo '<td>' .
                                                                    '<input type="checkbox" name="'.
                                                                            $day_name[$j] . $i . '" id="' . $day_name[$j] . $i .
                                                                            '" class="checkbox i-checks" />' .
                                                                    '<label for="' .  $day_name[$j] . $i . '"></label>' .
                                                                '</td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                    ?>
						                            </tbody>
						                        </table>
									        </div>
                                            <div class="col-sm-4">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" abbr="per">时段</th>
                                                        <th scope="col" abbr="sat">周六</th>
                                                        <th scope="col" abbr="sun">周日</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    for($i = 1; $i < count($weekend_breakpoint); ++$i) {
                                                        echo '<tr>' . '<th scope="row">'.$weekend_breakpoint[$i - 1] .
                                                            '-' . $weekend_breakpoint[$i] . '</th>';
                                                        for($j = 5; $j < 7; ++$j) {
                                                            echo '<td>' .
                                                                    '<input type="checkbox" name="'.
                                                                        $day_name[$j] . $i . '" id="' . $day_name[$j] . $i .
                                                                        '" class="checkbox i-checks" />' .
                                                                    '<label for="' .  $day_name[$j] . $i . '"></label>' .
                                                                '</td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
								        </div>
								    </div>
						            <div class="hr-line-dashed"></div>
						            <div class="row">
	                                    <div class="form-group">
	                                        <div class="col-sm-4 col-sm-offset-5">
	                                            <input id="submit_signup" class="btn btn-primary" type="submit"
	                                             value="报名"></input>
	                                        </div>
	                                    </div>
                                    </div>
						        </form>

	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>

            <div id="wrapper_holiday_schedule" class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>值班报名</h5>
                            </div>
                            <div class="ibox-content">
                                <!-- 待修改 -->
                                <form method="POST">
                                    <div class="form-group">
                                        <div class="row" style="margin-bottom: -15px;">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" abbr="per">时段</th>
                                                            <th scope="col" abbr="mon">选择空闲日期</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="holiday-schedule-table">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-5">
                                                <div id="submit_holiday_schedule" class="btn btn-primary">报名</div>
                                            </div>
                                        </div>
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

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10;">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="myModalLabel">温馨提示</h4>
	            </div>
	            <div class="modal-body">
	                <h2 id="submit_result" style="text-align:center;"><i class="fa fa-exclamation-circle exclamation-info"><span class="exclamation-desc"> 记录清空后不可恢复，确定要清空吗？</span></i></h2>
	            </div>
	            <div class="modal-footer">
	            	<div class="row">
	            		<div class="col-sm-6">
			            	<button id="confirm_clean" type="button" class="btn btn-primary" onclick="clean()">确定</button>
	            		</div>
	            		<div class="col-sm-6">
	            			<button type="button" class="btn btn-danger cancelBtn" data-dismiss="modal">取消</button>
	            		</div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/dutysignup.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>

    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-scheduleManagement").addClass("active");
			$("#active-dutySignUp").addClass("active");
			$("#mini").attr("href", "DutySignUp#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>

    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>

    <!-- Jquery Validate -->
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/validate/messages_zh.min.js' ?>"></script>

    <!-- iCheck -->
    <script src="<?=base_url().'assets/js/plugins/iCheck/icheck.min.js' ?>"></script>

    <!-- Input Mask-->
    <script src="<?=base_url().'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>

    <!-- Data Tables -->
    <script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>

    <script>
        $(document).ready(function () {
        	 /* Radio */
        	 $('#group_N').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#group_A').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#group_B').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#group_C').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

        });

    </script>

</body>

</html>
