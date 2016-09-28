<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-全员工时统计</title>
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
                        <?php 
	                        if ($_SESSION['level'] == 2 || $_SESSION['level'] == 3 || $_SESSION['level'] == 6) { echo 
			                    '<li>' . 
		                        	'工时统计' . 
		                        '</li>' . 
		                        '<li>' . 
		                            '<strong>全员</strong>' . 
		                        '</li>';
		                    }  else if ($_SESSION['level'] == 5) { echo
			                    '<li>' . 
		                            '<strong>工时统计</strong>' . 
		                        '</li>';
		                    } 
	                    ?>	
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
                                <h5>查看全员工时</h5>
                            </div>
                            <div class="ibox-content">
                            
                                <table class="table table-striped table-bordered table-hover users-dataTable">
                                    <thead>
                                        <tr>
                                        	<th>序号</th>
                                            <th>姓名</th>
                                            <th><i class="fa fa-clock-o"></i><span> 本月工时</span></th>
                                            <th><i class="fa fa-rmb"></i><span> 本月工资</span></th>
                                            <th><i class="fa fa-credit-card"></i><span> 银行卡号</span></th>
                                            <th><i class="fa fa-phone"></i><span> 联系电话</span></th>
                                            <th>历史累计工时</th>
                                            <th>历史累计工资</th>
                                            <th>调整工时</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php for ($i = 0; $i < $count; $i++) { ?>
	                                        <tr>
	                                        	<td><?php echo $i + 1; ?></td>
	                                            <td><?php echo $name_list[$i]; ?></td>
	                                            <td><strong id="<?php echo 'month_contri_' . $wid_list[$i]; ?>"><?php echo $month_contri_list[$i]; ?></strong></td>
	                                            <td><strong id="<?php echo 'month_salary_' . $wid_list[$i]; ?>"><?php echo $month_salary_list[$i]; ?></strong></td>
	                                            <td><?php echo $card_list[$i]; ?></td>
	                                            <td><?php echo $phone_list[$i]; ?></td>
	                                            <td id="<?php echo 'total_contri_' . $wid_list[$i]; ?>"><?php echo $total_contri_list[$i]; ?></td>
	                                            <td id="<?php echo 'total_salary_' . $wid_list[$i]; ?>"><?php echo $total_salary_list[$i]; ?></td>
	                                            <td>
		                                            <button type="button" data-toggle="modal" data-target="#myModal" id="<?php echo 'reward_button_' . $wid_list[$i]; ?>" 
		                                            name="reward_button" class="btn btn-xs btn-primary" onclick="rewardButton(this.id);">
		                                            	增加
		                                            </button>
		                                            <button type="button" data-toggle="modal" data-target="#myModal" id="<?php echo 'penalty_button_' . $wid_list[$i]; ?>" 
		                                            name="penalty_button" class="btn btn-xs btn-danger" onclick="penaltyButton(this.id);">
		                                            	扣除
		                                            </button>
	                                            </td>
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
	
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10;">
	    <div class="modal-dialog">
	        <div class="modal-content" style="margin-top: 90px;">
	            <div class="modal-header">
	                <h4 class="modal-title" id="myModalLabelTitle"></h4>
	            </div>
	            <div id="modalBody" class="modal-body">
	            </div>
	        </div>
	    </div>
	</div>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/workingtime.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-timeStatistics").addClass("active");
			$("#active-allmembers").addClass("active");
			$("#mini").attr("href", "allWorkingTime#");
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
    
    <!-- Jquery Validate -->
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/validate/jquery.validate.min.js' ?>"></script>
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/validate/messages_zh.min.js' ?>"></script>
    
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
