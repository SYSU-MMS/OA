<<<<<<< HEAD
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-查看坐班日志</title>
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
                        	坐班日志
                        </li>
                        <li>
                            <strong>查看</strong>
                        </li>	
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins ">
                            <div class="ibox-title">
                                <h2 class="col-sm-offset-5">组长坐班日志</h2>
                            </div>
                            <div class="ibox-content col-sm-12" style="padding-top: 0px; margin-bottom: 25px;">
                            	<div class="col-sm-1"></div>
                            	<div class="col-sm-10">
	                                <table class="table table-striped table-bordered table-hover users-dataTable">
	                                    <tbody>
		                                    	<table class="table table-striped table-bordered td-font-size" style="margin-bottom: -1px;">
		                                        	<tbody>
		                                        		<tr>
				                                        	<td><strong>组长</strong></td>
				                                            <td><?php echo $leader_name; ?></td>
				                                            <td><strong>组别</strong></td>
				                                            <td><?php echo $group; ?>组</td>
				                                            <td><strong>日期</strong></td>
				                                            <td><?php echo $timestamp . ' 第' . $weekcount . '周 星期' . $weekday; ?></td>
			                                            </tr>
		                                            </tbody>
			                                    </table>
		                                   
		                                    	<table class="table table-bordered td-font-size">
		                                        	<tbody>
		                                        		<tr class="tr-height">
					                                        <td class="col-sm-2"><strong>早检情况</strong></td>
					                                        <td class="td-left"><?php echo $body_list[0]; ?></td>
														</tr>
														<tr class="tr-height">
						                                    <td class="col-sm-2"><strong>午检情况</strong></td>
						                                    <td class="td-left"><?php echo $body_list[1]; ?></td>
					                                    </tr>
					                                    <tr class="tr-height">
						                                    <td class="col-sm-2"><strong>晚检情况</strong></td>
						                                    <td class="td-left"><?php echo $body_list[2]; ?></td>
					                                    </tr>
					                                    <tr class="tr-height">
					                                        <td class="col-sm-2"><strong>优秀助理</strong></td>
					                                        <td class="td-left">
					                                        	<p>优秀助理有：
					                                        		<strong>
						                                        		<?php 
						                                        			foreach ($best_list as $best) {
						                                        				echo $best . ' &nbsp;&nbsp;';
						                                        			}
						                                        		?>
						                                        	</strong>
					                                        	</p>
					                                        	<?php echo $body_list[3]; ?>
					                                        </td>
														</tr>
														<tr  class="tr-height">
						                                    <td class="col-sm-2"><strong>异常助理</strong></td>
						                                    <td class="td-left">
						                                    	<p>异常助理有：
					                                        		<strong>
						                                        		<?php 
						                                        			foreach ($bad_list as $bad) {
						                                        				echo $bad . ' &nbsp;&nbsp;';
						                                        			}
						                                        		?>
						                                        	</strong>
					                                        	</p>
						                                    	<?php echo $body_list[4]; ?>
						                                    </td>
					                                    </tr>
					                                    <tr style="height: 60px;">
						                                    <td class="col-sm-2"><strong>总结</strong></td>
						                                    <td class="td-left"><?php echo $body_list[5]; ?></td>
					                                    </tr>
		                                            </tbody>
			                                    </table>
		                                </tbody>
		                            </table>
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
    <script src="<?=base_url().'assets/js/searchuser.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-journal").addClass("active");
			$("#active-readJournal").addClass("active");
			$("#mini").attr("href", "readJournal#");
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
                '.chosen-select': {
                },
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
=======
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-查看坐班日志</title>
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
                        	坐班日志
                        </li>
                        <li>
                            <strong>查看</strong>
                        </li>	
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins ">
                            <div class="ibox-title">
                                <h2 class="col-sm-offset-5">组长坐班日志</h2>
                            </div>
                            <div class="ibox-content col-sm-12" style="padding-top: 0px; margin-bottom: 25px;">
                            	<div class="col-sm-1"></div>
                            	<div class="col-sm-10">
	                                <table class="table table-striped table-bordered table-hover users-dataTable">
	                                    <tbody>
		                                    	<table class="table table-striped table-bordered td-font-size" style="margin-bottom: -1px;">
		                                        	<tbody>
		                                        		<tr>
				                                        	<td><strong>组长</strong></td>
				                                            <td><?php echo $leader_name; ?></td>
				                                            <td><strong>组别</strong></td>
				                                            <td><?php echo $group; ?>组</td>
				                                            <td><strong>日期</strong></td>
				                                            <td><?php echo $timestamp . ' 第' . $weekcount . '周 星期' . $weekday; ?></td>
			                                            </tr>
		                                            </tbody>
			                                    </table>
		                                   
		                                    	<table class="table table-bordered td-font-size">
		                                        	<tbody>
		                                        		<tr class="tr-height">
					                                        <td class="col-sm-2"><strong>早检情况</strong></td>
					                                        <td class="td-left"><?php echo $body_list[0]; ?></td>
														</tr>
														<tr class="tr-height">
						                                    <td class="col-sm-2"><strong>午检情况</strong></td>
						                                    <td class="td-left"><?php echo $body_list[1]; ?></td>
					                                    </tr>
					                                    <tr class="tr-height">
						                                    <td class="col-sm-2"><strong>晚检情况</strong></td>
						                                    <td class="td-left"><?php echo $body_list[2]; ?></td>
					                                    </tr>
					                                    <tr class="tr-height">
					                                        <td class="col-sm-2"><strong>优秀助理</strong></td>
					                                        <td class="td-left">
					                                        	<p>优秀助理有：
					                                        		<strong>
						                                        		<?php 
						                                        			foreach ($best_list as $best) {
						                                        				echo $best . ' &nbsp;&nbsp;';
						                                        			}
						                                        		?>
						                                        	</strong>
					                                        	</p>
					                                        	<?php echo $body_list[3]; ?>
					                                        </td>
														</tr>
														<tr  class="tr-height">
						                                    <td class="col-sm-2"><strong>异常助理</strong></td>
						                                    <td class="td-left">
						                                    	<p>异常助理有：
					                                        		<strong>
						                                        		<?php 
						                                        			foreach ($bad_list as $bad) {
						                                        				echo $bad . ' &nbsp;&nbsp;';
						                                        			}
						                                        		?>
						                                        	</strong>
					                                        	</p>
						                                    	<?php echo $body_list[4]; ?>
						                                    </td>
					                                    </tr>
					                                    <tr style="height: 60px;">
						                                    <td class="col-sm-2"><strong>总结</strong></td>
						                                    <td class="td-left"><?php echo $body_list[5]; ?></td>
					                                    </tr>
		                                            </tbody>
			                                    </table>
		                                </tbody>
		                            </table>
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
    <script src="<?=base_url().'assets/js/searchuser.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-journal").addClass("active");
			$("#active-readJournal").addClass("active");
			$("#mini").attr("href", "readJournal#");
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
                '.chosen-select': {
                },
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
>>>>>>> abnormal
