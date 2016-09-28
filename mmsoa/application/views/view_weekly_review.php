<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-查看周检情况</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">
	
    <link href="<?=base_url().'assets/css/plugins/datetimepicker/bootstrap-datetimepicker.css' ?>" rel="stylesheet">
    
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
                        	工作审查
                        </li>
                        <li>
                            <strong>周检情况</strong>
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
                                <h5>查看周检情况</h5>
                            </div>
                            <div class="ibox-content">
                            
                            	<div class="row">
                            		<div class="form-group col-md-4" id="dtp_group">
	                                    <label class="font-noraml">选择时间段</label>
	                                    <div class="input-daterange input-group" id="dtp">
	                                        <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" value="<?php echo date('Y-m-d H:i', strtotime("-7 day")); ?>" />
	                                        <span class="input-group-addon dtp-addon">到</span>
	                                        <input type="text" id="end_dtp" class="input-sm form-control dtp-input-div" name="end" placeholder="结束时间" value="<?php echo date('Y-m-d H:i',time()); ?>" />
	                                    </div>
	                                </div>
	                                <div id="chosen_classroom" class="form-group col-md-3" style="height: 30px; position: relative; z-index: 999999;">
                                        <label class="font-noraml">选择课室</label>
                                        <div>
	                                        <select id="select_classroom" name="select_classroom" data-placeholder="" class="chosen-select-classroom col-sm-12" tabindex="4">
	                                        	<option value="">全部</option>
	                                        	<?php 
                                        			for ($i = 0; $i < count($room_list); $i++) {
                                        				echo "<option value='" . $roomid_list[$i] . "'>" . $room_list[$i] . "</option>";
                                        			} 
                                        		?>
	                                        </select>
                                        </div>
                                    </div>
	                                <div id="chosen_name" class="form-group col-md-3" style="height: 30px; position: relative; z-index: 999999;">
                                        <label class="font-noraml">选择助理</label>
                                        <div>
	                                        <select id="select_name" name="select_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4">
	                                        	<option value="">全部</option>
	                                        	<?php 
                                        			for ($i = 0; $i < count($name_list); $i++) {
                                        				echo "<option value='" . $wid_list[$i] . "'>" . $name_list[$i] . "</option>";
                                        			} 
                                        		?>
	                                        </select>
                                        </div>
                                    </div>
                                    <div id="search_container" class="form-group col-md-2">
                                        <label class="font-noraml search-btn">查找</label>
                                        <div>
	                                        <button id="search_btn" class="btn btn-primary btn-longer"><i class="fa fa-search"></i> &nbsp;查找</button>
                                        </div>
                                    </div>
                            	</div>
                            	<div id="table_container">
	                                <table class="table table-striped table-bordered table-hover users-dataTable">
	                                    <thead>
	                                        <tr>
	                                        	<th>序号</th>
	                                            <th>周次</th>
	                                            <th>星期</th>
	                                            <th>姓名</th>
	                                            <th>课室</th>
	                                            <th>情况</th>
	                                            <th>灯时</th>
	                                            <th>登记时间</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    	<?php for ($i = 0; $i < $w_count; $i++) { ?>
		                                        <tr>
		                                        	<td><?php echo $i + 1; ?></td>
		                                            <td><?php echo $w_weekcount; ?></td>
		                                            <td><?php echo $w_day_list[$i]; ?></td>
		                                            <td><?php echo $w_name_list[$i]; ?></td>
		                                            <td><?php echo $w_room_list[$i]; ?></td>
		                                            <td  class="td-left">
		                                            	<?php 
		                                            		if ($w_prob_list[$i] == '') {
		                                            			echo '正常';
		                                            		} else {
		                                            			echo $w_prob_list[$i];
		                                            		}
		                                            	?>
		                                            </td>
		                                            <td><?php echo $w_lamp_list[$i]; ?></td>
		                                            <td><?php echo $w_time_list[$i]; ?></td>
		                                        </tr>
		                                    <?php } ?>
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
    <script src="<?=base_url().'assets/js/weeklyreview.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-workReview").addClass("active");
			$("#active-weeklyReview").addClass("active");
			$("#mini").attr("href", "weeklyReview#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>
    
    <!-- Chosen -->
    <script src="<?=base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

    <!-- Date time picker -->
    <script src="<?=base_url().'assets/js/plugins/datetimepicker/bootstrap-datetimepicker.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js' ?>"></script>
    
    <!-- Data Tables -->
    <script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>
    
    <script>
        $(document).ready(function () {

        	// dataTable
        	$('.users-dataTable').dataTable({
        		"iDisplayLength": 25
            });

        	/* Calendar */
        	$('#start_dtp').datetimepicker({
        	    format: 'yyyy-mm-dd hh:ii',
        	    language: 'zh-CN',
                weekStart: 1,
                todayBtn:  1,
        		autoclose: 1,
        		todayHighlight: 1,
        		startView: 2,
        		minView: 0,
        		forceParse: 1
        	});
        	$('#end_dtp').datetimepicker({
        	    format: 'yyyy-mm-dd hh:ii',
        	    language: 'zh-CN',
                weekStart: 1,
                todayBtn:  1,
        		autoclose: 1,
        		todayHighlight: 1,
        		startView: 2,
        		minView: 0,
        		forceParse: 1
        	});
            
        });

        /* Chosen name */
        var config = {
                '.chosen-select-classroom': {
                	// 实现中间字符的模糊查询
                	search_contains: true,
                	no_results_text: "没有找到",
                	disable_search_threshold: 10
                },
                '.chosen-select-classroom-deselect': {
                    allow_single_deselect: true
                },
                '.chosen-select-classroomt-no-single': {
                    disable_search_threshold: 10
                },
                '.chosen-select-classroom-no-results': {
                    no_results_text: 'Oops, nothing found!'
                },
                '.chosen-select-classroom-width': {
                    width: "95%"
                }
            }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

        /* Chosen classroom */
        var config = {
                '.chosen-select-name': {
                	// 实现中间字符的模糊查询
                	search_contains: true,
                	no_results_text: "没有找到",
                	disable_search_threshold: 10
                },
                '.chosen-select-classroom-name': {
                    allow_single_deselect: true
                },
                '.chosen-select-name-no-single': {
                    disable_search_threshold: 10
                },
                '.chosen-select-name-no-results': {
                    no_results_text: 'Oops, nothing found!'
                },
                '.chosen-select-name-width': {
                    width: "95%"
                }
            }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        
    </script>

</body>

</html>
