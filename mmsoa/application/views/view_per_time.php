<<<<<<< HEAD
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-个人工时详情</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet">
        
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
                        <?php 
	                        if ($_SESSION['level'] == 2 || $_SESSION['level'] == 3 || $_SESSION['level'] == 6) { echo 
			                    '<li>' . 
		                        	'工时统计' . 
		                        '</li>' . 
		                        '<li>' . 
		                            '<strong>个人</strong>' . 
		                        '</li>';
		                    } else if ($_SESSION['level'] == 0 || $_SESSION['level'] == 1) { echo
			                    '<li>' . 
		                            '<strong>我的工时</strong>' . 
		                        '</li>';
		                    }
	                    ?>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
	            <div class="ibox-content col-sm-12" style="padding-top: 10px; padding-bottom: 25px; margin-bottom: 25px;">
	                <div class="row">
			            <div class="col-sm-4 col-sm-offset-1">
			                <div class="widget-head-color-box navy-bg p-lg text-center">
			                    <div class="m-b-md">
			                        <h2 class="font-bold no-margins">
			                               <?php echo $_SESSION['name']; ?>
			                            </h2>
			                        <small><?php echo $_SESSION['level_name']; ?></small>
			                    </div>
			                    <img src="<?=base_url() . 'upload/avatar/' . $_SESSION['avatar'] ?>" class="img-circle circle-border m-b-md per-time-avatar" alt="profile">
			                    <div>
			                        <span><?php echo $indate; ?> 加入</span> |
			                        <span>已在职 <?php echo $working_age; ?></span>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 lazur-bg">
			                    <div class="row">
			                        <div class="col-xs-3">
			                            <i class="fa fa-clock-o fa-5x"></i>
			                        </div>
			                        <div class="col-xs-9 text-right">
			                            <span> 本月工时 </span>
			                            <h2 class="font-bold month-font-size"><?php echo $month_contri; ?></h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 yellow-bg">
			                    <div class="row">
			                        <div class="col-xs-4">
			                            <i class="fa fa-rmb fa-5x"></i>
			                        </div>
			                        <div class="col-xs-8 text-right">
			                            <span> 本月工资 </span>
			                            <h2 class="font-bold month-font-size"><?php echo $month_salary; ?></h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 lazur-bg">
			                    <div class="row">
			                    	<div class="col-xs-2">
			                            <i class="fa fa-history fa-4x fa-margin"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <span> 历史累计工时 </span>
			                            <h2 class="font-bold other-font-size"><?php echo $total_contri; ?></h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 yellow-bg">
			                    <div class="row">
			                    	<div class="col-xs-2">
			                            <i class="fa fa-database fa-4x"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <span> 历史累计工资 </span>
			                            <h2 class="font-bold other-font-size"><?php echo $total_salary; ?></h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 penalty-bg">
			                    <div class="row penalty-text-color">
			                    	<div class="col-xs-2">
			                            <i class="fa fa-minus-square-o fa-4x fa-margin"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <span> 本月被扣工时 </span>
			                            <h2 class="font-bold other-font-size">
			                            	<?php 
			                            		if ($month_penalty > 0) {
			                            			echo '- ';
			                            	}
			                            	echo $month_penalty; 
			                            	?>
			                           	</h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 penalty-bg">
			                    <div class="row penalty-text-color">
			                    	<div class="col-xs-2">
			                            <i class="fa fa-frown-o fa-4x"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <span> 累计被扣工时 </span>
			                            <h2 class="font-bold other-font-size">
			                            	<?php 
			                            		if ($total_penalty > 0) {
			                            			echo '- ';
			                            	}
			                            	echo $total_penalty; 
			                            	?>
			                           	</h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-6">
			                <div class="widget style1 red-bg">
			                    <div class="row vertical-align">
			                        <div class="col-xs-2">
			                            <i class="fa fa-credit-card-alt fa-3x fa-margin"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <h2 class="font-bold"><?php echo $card; ?></h2>
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
    <!-- <script src="<?=base_url().'assets/js/searchuser.js' ?>"></script> -->
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-timeStatistics").addClass("active");
			$("#active-personal").addClass("active");
			$("#mini").attr("href", "perWorkingTime#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>
    
    <!-- iCheck -->
    <script src="<?=base_url().'assets/js/plugins/iCheck/icheck.min.js' ?>"></script>

    <!-- JSKnob -->
    <script src="<?=base_url().'assets/js/plugins/jsKnob/jquery.knob.js' ?>"></script>

    <!-- Input Mask-->
    <script src="<?=base_url().'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>


</body>

</html>
=======
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-个人工时详情</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet">
        
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
                        <?php 
	                        if ($_SESSION['level'] == 2 || $_SESSION['level'] == 3 || $_SESSION['level'] == 6) { echo 
			                    '<li>' . 
		                        	'工时统计' . 
		                        '</li>' . 
		                        '<li>' . 
		                            '<strong>个人</strong>' . 
		                        '</li>';
		                    } else if ($_SESSION['level'] == 0 || $_SESSION['level'] == 1) { echo
			                    '<li>' . 
		                            '<strong>我的工时</strong>' . 
		                        '</li>';
		                    }
	                    ?>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
	            <div class="ibox-content col-sm-12" style="padding-top: 10px; padding-bottom: 25px; margin-bottom: 25px;">
	                <div class="row">
			            <div class="col-sm-4 col-sm-offset-1">
			                <div class="widget-head-color-box navy-bg p-lg text-center">
			                    <div class="m-b-md">
			                        <h2 class="font-bold no-margins">
			                               <?php echo $_SESSION['name']; ?>
			                            </h2>
			                        <small><?php echo $_SESSION['level_name']; ?></small>
			                    </div>
			                    <img src="<?=base_url() . 'upload/avatar/' . $_SESSION['avatar'] ?>" class="img-circle circle-border m-b-md per-time-avatar" alt="profile">
			                    <div>
			                        <span><?php echo $indate; ?> 加入</span> |
			                        <span>已在职 <?php echo $working_age; ?></span>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 lazur-bg">
			                    <div class="row">
			                        <div class="col-xs-3">
			                            <i class="fa fa-clock-o fa-5x"></i>
			                        </div>
			                        <div class="col-xs-9 text-right">
			                            <span> 本月工时 </span>
			                            <h2 class="font-bold month-font-size"><?php echo $month_contri; ?></h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 yellow-bg">
			                    <div class="row">
			                        <div class="col-xs-4">
			                            <i class="fa fa-rmb fa-5x"></i>
			                        </div>
			                        <div class="col-xs-8 text-right">
			                            <span> 本月工资 </span>
			                            <h2 class="font-bold month-font-size"><?php echo $month_salary; ?></h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 lazur-bg">
			                    <div class="row">
			                    	<div class="col-xs-2">
			                            <i class="fa fa-history fa-4x fa-margin"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <span> 历史累计工时 </span>
			                            <h2 class="font-bold other-font-size"><?php echo $total_contri; ?></h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 yellow-bg">
			                    <div class="row">
			                    	<div class="col-xs-2">
			                            <i class="fa fa-database fa-4x"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <span> 历史累计工资 </span>
			                            <h2 class="font-bold other-font-size"><?php echo $total_salary; ?></h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 penalty-bg">
			                    <div class="row penalty-text-color">
			                    	<div class="col-xs-2">
			                            <i class="fa fa-minus-square-o fa-4x fa-margin"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <span> 本月被扣工时 </span>
			                            <h2 class="font-bold other-font-size">
			                            	<?php 
			                            		if ($month_penalty > 0) {
			                            			echo '- ';
			                            	}
			                            	echo $month_penalty; 
			                            	?>
			                           	</h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-3">
			                <div class="widget style1 penalty-bg">
			                    <div class="row penalty-text-color">
			                    	<div class="col-xs-2">
			                            <i class="fa fa-frown-o fa-4x"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <span> 累计被扣工时 </span>
			                            <h2 class="font-bold other-font-size">
			                            	<?php 
			                            		if ($total_penalty > 0) {
			                            			echo '- ';
			                            	}
			                            	echo $total_penalty; 
			                            	?>
			                           	</h2>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="col-sm-6">
			                <div class="widget style1 red-bg">
			                    <div class="row vertical-align">
			                        <div class="col-xs-2">
			                            <i class="fa fa-credit-card-alt fa-3x fa-margin"></i>
			                        </div>
			                        <div class="col-xs-10 text-right">
			                            <h2 class="font-bold"><?php echo $card; ?></h2>
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
    <!-- <script src="<?=base_url().'assets/js/searchuser.js' ?>"></script> -->
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-timeStatistics").addClass("active");
			$("#active-personal").addClass("active");
			$("#mini").attr("href", "perWorkingTime#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>
    
    <!-- iCheck -->
    <script src="<?=base_url().'assets/js/plugins/iCheck/icheck.min.js' ?>"></script>

    <!-- JSKnob -->
    <script src="<?=base_url().'assets/js/plugins/jsKnob/jquery.knob.js' ?>"></script>

    <!-- Input Mask-->
    <script src="<?=base_url().'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>


</body>

</html>
>>>>>>> abnormal
