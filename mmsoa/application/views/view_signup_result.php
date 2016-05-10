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
                                <h5>报名结果</h5>
                            </div>
                            <div class="ibox-content" style="padding: 105px 0px 105px 0px;">
                            	<div class="row">
	                            	<div class="form-group col-sm-6 col-sm-offset-3">
	                            		<?php if ($status == TRUE) { ?>
		                            		<div class="row">
				                            	<div class="col-sm-3 col-sm-offset-2" style="color: #1AB394; text-align: right;">
				                            		<i class="fa fa-check-square-o fa-5x"></i>
				                            	</div>
				                            	<div class="col-sm-7" style="padding-left: 0px;">
				                            		<h1 style="margin-top: 14px; text-align: left; color: #1AB394;">报名成功</h1>
				                            	</div>
				                            </div>
				                            <div class="row">
				                            	<div class="form-group col-sm-12" style="text-align: center;  font-size: 14px;">
				                            		<h1 style="padding-right: 50px;"><small>请留意<a href="<?php echo site_url('DutyArrange/dutySchedule'); ?>" style="color: #1AB394;">新值班表</a>的发布</small></h1>
				                            	</div>
				                            </div>
				                        <?php } else { ?>
				                        	<div class="row">
				                            	<div class="col-sm-3 col-sm-offset-2" style="color: #ED5565; text-align: right;">
				                            		<i class="fa fa-times-circle fa-5x"></i>
				                            	</div>
				                            	<div class="col-sm-7" style="padding-left: 0px;">
				                            		<h1 style="margin-top: 14px; text-align: left; color: #ED5565;">报名失败</h1>
				                            	</div>
				                            </div>
				                            <div class="row">
				                            	<div class="form-group col-sm-12" style="text-align: center;  font-size: 17px;">
				                            		<h1 style="padding-right: 40px;"><small>请再次尝试<a href="<?php echo site_url('DutySignUp'); ?>" >报名</a></small></h1>
				                            	</div>
				                            </div>
				                        <?php } ?>
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
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-scheduleManagement").addClass("active");
			$("#active-dutySignUp").addClass("active");
			$("#mini").attr("href", "dutySignUp#");
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
    

</body>

</html>
