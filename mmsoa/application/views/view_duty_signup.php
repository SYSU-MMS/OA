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
						        	if ($_SESSION['level'] == 3 || $_SESSION['level'] == 6) { echo
						        		'<a id="export_signup" class="btn btn-primary exportSignupBtn" href="' . site_url('DutySignUp/exportToTxt') . '">导出报名情况</a>';
						        	}
						        ?>
                            </div>
                            <div class="ibox-content">
                            	<form method="POST" action="<?php echo site_url('DutySignUp/signUp'); ?>">
                            		<div class="row form-group" id="radio_group" style="margin: 10px 35px 23px 0px;">
	                                    <label class="col-sm-1 col-sm-offset-2 control-label" for="groupid"> 组别 </label>
										<div class="col-sm-8">
											<label class="radio-inline" style="font-size: 14px;">
										        <input type="radio" checked="" value="N" id="group_N" name="groupid"> A/B</label>
										    <label class="radio-inline" style="font-size: 14px;">
										        <input type="radio" value="A" id="group_A" name="groupid"> A </label>
										    <label class="radio-inline" style="font-size: 14px;">
										        <input type="radio" value="B" id="group_B" name="groupid"> B </label>
										    <label class="radio-inline" style="font-size: 14px;">
										        <input type="radio" value="C" id="group_C" name="groupid"> C </label>
										</div>
									</div>
									<div class="form-group">
										<div class="row" style="margin-bottom: -15px;">
											<div class="col-sm-8 col-sm-offset-2">
						                        <table class="table table-bordered table-hover">
						                            <thead>
						                                <tr>
						                                    <th scope="col" abbr="per">时段</th>
						                                    <th scope="col" abbr="mon">周一</th>
						                                    <th scope="col" abbr="tue">周二</th>
						                                    <th scope="col" abbr="wed">周三</th>
						                                    <th scope="col" abbr="thu">周四</th>
						                                    <th scope="col" abbr="fri">周五</th>
						                                    <th scope="col" abbr="sat">周六</th>
						                                    <th scope="col" abbr="sun">周日</th>
						                                </tr>
						                            </thead>
						                            <tbody>
						                                <tr>
						                                    <th scope="row">07:30-10:30</th>
						                                    <td><input type="checkbox" name="MON1" id="MON1" class="checkbox i-checks" /><label for="MON1"></label></td>
						                                    <td><input type="checkbox" name="TUE1" id="TUE1" class="checkbox i-checks" /><label for="TUE1"></label></td>
						                                    <td><input type="checkbox" name="WED1" id="WED1" class="checkbox i-checks" /><label for="WED1"></label></td>
						                                    <td><input type="checkbox" name="THU1" id="THU1" class="checkbox i-checks" /><label for="THU1"></label></td>
						                                    <td><input type="checkbox" name="FRI1" id="FRI1" class="checkbox i-checks" /><label for="FRI1"></label></td>
						                                    <td rowspan="2"><input type="checkbox" name="SAT1" id="SAT1" class="checkbox i-checks" /><label for="SAT1"></label></td>
						                                    <td rowspan="2"><input type="checkbox" name="SUN1" id="SUN1" class="checkbox i-checks" /><label for="SUN1"></label></td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">10:30-12:30</th>
						                                    <td><input type="checkbox" name="MON2" id="MON2" class="checkbox i-checks" /><label for="MON2"></label></td>
						                                    <td><input type="checkbox" name="TUE2" id="TUE2" class="checkbox i-checks" /><label for="TUE2"></label></td>
						                                    <td><input type="checkbox" name="WED2" id="WED2" class="checkbox i-checks" /><label for="WED2"></label></td>
						                                    <td><input type="checkbox" name="THU2" id="THU2" class="checkbox i-checks" /><label for="THU2"></label></td>
						                                    <td><input type="checkbox" name="FRI2" id="FRI2" class="checkbox i-checks" /><label for="FRI2"></label></td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">12:30-14:00</th>
						                                    <td><input type="checkbox" name="MON3" id="MON3" class="checkbox i-checks" /><label for="MON3"></label></td>
						                                    <td><input type="checkbox" name="TUE3" id="TUE3" class="checkbox i-checks" /><label for="TUE3"></label></td>
						                                    <td><input type="checkbox" name="WED3" id="WED3" class="checkbox i-checks" /><label for="WED3"></label></td>
						                                    <td><input type="checkbox" name="THU3" id="THU3" class="checkbox i-checks" /><label for="THU3"></label></td>
						                                    <td><input type="checkbox" name="FRI3" id="FRI3" class="checkbox i-checks" /><label for="FRI3"></label></td>
						                                    <td rowspan="3"><input type="checkbox" name="SAT2" id="SAT2" class="checkbox i-checks" /><label for="SAT2"></label></td>
						                                    <td rowspan="3"><input type="checkbox" name="SUN2" id="SUN2" class="checkbox i-checks" /><label for="SUN2"></label></td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">14:00-16:00</th>
						                                    <td><input type="checkbox" name="MON4" id="MON4" class="checkbox i-checks" /><label for="MON4"></label></td>
						                                    <td><input type="checkbox" name="TUE4" id="TUE4" class="checkbox i-checks" /><label for="TUE4"></label></td>
						                                    <td><input type="checkbox" name="WED4" id="WED4" class="checkbox i-checks" /><label for="WED4"></label></td>
						                                    <td><input type="checkbox" name="THU4" id="THU4" class="checkbox i-checks" /><label for="THU4"></label></td>
						                                    <td><input type="checkbox" name="FRI4" id="FRI4" class="checkbox i-checks" /><label for="FRI4"></label></td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">16:00-18:00</th>
						                                    <td><input type="checkbox" name="MON5" id="MON5" class="checkbox i-checks" /><label for="MON5"></label></td>
						                                    <td><input type="checkbox" name="TUE5" id="TUE5" class="checkbox i-checks" /><label for="TUE5"></label></td>
						                                    <td><input type="checkbox" name="WED5" id="WED5" class="checkbox i-checks" /><label for="WED5"></label></td>
						                                    <td><input type="checkbox" name="THU5" id="THU5" class="checkbox i-checks" /><label for="THU5"></label></td>
						                                    <td><input type="checkbox" name="FRI5" id="FRI5" class="checkbox i-checks"/><label for="FRI5"></label></td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">18:00-22:00</th>
						                                    <td><input type="checkbox" name="MON6" id="MON6" class="checkbox i-checks" /><label for="MON6"></label></td>
						                                    <td><input type="checkbox" name="TUE6" id="TUE6" class="checkbox i-checks" /><label for="TUE6"></label></td>
						                                    <td><input type="checkbox" name="WED6" id="WED6" class="checkbox i-checks" /><label for="WED6"></label></td>
						                                    <td><input type="checkbox" name="THU6" id="THU6" class="checkbox i-checks" /><label for="THU6"></label></td>
						                                    <td><input type="checkbox" name="FRI6" id="FRI6" class="checkbox i-checks" /><label for="FRI6"></label></td>
						                                    <td><input type="checkbox" name="SAT3" id="SAT3" class="checkbox i-checks" /><label for="SAT3"></label></td>
						                                    <td><input type="checkbox" name="SUN3" id="SUN3" class="checkbox i-checks" /><label for="SUN3"></label></td>
						                                </tr>
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
            <?php $this->load->view('view_footer'); ?>
	    </div>
	</div>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
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
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/validate/jquery.validate.min.js' ?>"></script>
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
