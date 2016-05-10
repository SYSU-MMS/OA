<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-值班登记</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/js/plugins/layer/skin/layer.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/switchery/switchery.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
    
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
                            <strong>值班</strong>
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
                                <h5>值班登记</h5>
                            	<div class="ibox-content">
                                	<div class="panel blank-panel">

	                                    <div class="panel-heading">
	                                        <div class="panel-options">
	                                            <ul class="nav nav-tabs">
	                                                <li class="active"><a data-toggle="tab" href="tabs_panels.html#base">值班</a>
	                                                </li>
	                                            </ul>
	                                        </div>
	                                    </div>
	
	                                    <div class="panel-body my-panel-body">
	                                        <div class="tab-content">
	                                            <div id="base" class="tab-pane active">
	                                            	<div class="form-group"  style="height: 38px;">
	                                            		<label class="col-sm-1 control-label" style="padding: 8px 0px 0px 0px; margin-right: -2px;">
	                                            			<h5>签到：
	                                            			</h5>
	                                            		</label>
	                                            		<div class="col-sm-11">
	                                            			<input type="checkbox" name="signin_onduty" id="onduty" class="js-switch" />
	                                            		</div>
	                                            	</div>
	                                            	
	                                            	<div class="form-group" style="height: 30px;">
					                                    <label class="col-sm-1 control-label" style="padding: 3px 0px 0px 0px; margin-right: -20px;"><h5>是否代班：</h5></label>
														<div class="col-sm-11">
														    <label class="radio-inline" style="font-size: 14px;">
														        <input type="radio" checked="" disabled="" value="0" id="replaced_no" class="my_radio" name="group_radio"> 否 </label>
														    <label class="radio-inline" style="font-size: 14px;">
														        <input type="radio" disabled="" value="1" id="replaced_yes" class="my_radio" name="group_radio"> 是 </label>
														</div>
				                                    </div>
				                                    
				                                    <div class="form-group" id="chosen_replaced" style="height: 30px; position: relative; z-index: 999999;">
				                                        <label class="col-sm-2 control-label" style="padding: 8px 0px 0px 0px; margin-right: -82px; "><h5>原值班助理：</h5></label>
				                                        <div class="col-sm-3">
				                                        	<select id="select_replaced" name="replaced_colleague" data-placeholder="请选择原值班助理" class="chosen-select col-sm-12" tabindex="4">
				                                        		<option value="">请选择原值班助理</option>
				                                        		<?php 
				                                        			for ($i = 0; $i < count($name_list); $i++) {
				                                        				// 排除自己
				                                        				if ($wid_list[$i] != $wid) {
				                                        		?>
				                                        			<option value="<?php echo $wid_list[$i]; ?>"><?php echo $name_list[$i]; ?></option>
				                                        		<?php 
				                                        				}
				                                        			} 
				                                        		?>
				                                        	</select>
				                                        </div>
				                                    </div>
				                                    
						                            <div class="ibox-content" style="margin-bottom: 0px; padding-bottom: 0px;">
						                                <div class="form-horizontal" id="onduty_form">
						                                	<div class="form-group">
						                                		<h5>值班时间：&nbsp;<small>请拖动绿条选择时间段</small></h5>
						                                	</div>
						                                	
						                                    <div class="form-group">
						                                		<div id="range_slider"></div>
						                                	</div>
						                                	
						                                    <div class="hr-line-dashed"></div>
						                                    
						                                    <div class="form-group">
						                                        <div class="col-sm-4 col-sm-offset-5">
						                                            <button id="submit_onduty" class="btn btn-primary" disabled="" type="submit" 
						                                            data-toggle="modal" data-target="#myModal">登记</button>
						                                        </div>
						                                    </div>
						                                </div>
						                            </div>
	                                            </div>
	                                        </div>
	                                    </div>
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
    
    <?php $this->load->view('view_modal'); ?>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/onduty_in.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-workrecord").addClass("active");
			$("#active-onduty").addClass("active");
			$("#mini").attr("href", "Duty#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>
    
    <!-- iCheck -->
    <script src="<?=base_url().'assets/js/plugins/iCheck/icheck.min.js' ?>"></script>
    
    <!-- Chosen -->
    <script src="<?=base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>
    
    <!-- Moment -->
    <script src="<?=base_url().'assets/js/plugins/moment/moment-with-locales.min.js' ?>"></script>
    
    <!-- IonRangeSlider -->
    <script src="<?=base_url().'assets/js/plugins/ionRangeSlider/ion.rangeSlider.min.js' ?>"></script>
    
    <!-- layer javascript -->
    <script src="<?=base_url().'assets/js/plugins/layer/layer.js' ?>"></script>
    <script>
        layer.use('extend/layer.ext.js'); //载入layer拓展模块
    </script>

    <script src="<?=base_url().'assets/js/demo/layer-demo.js' ?>"></script>
    
    <!-- Switchery -->
    <script src="<?=base_url().'assets/js/plugins/switchery/switchery.js' ?>"></script>
    
	<script> 
		$(document).ready(function () {
			// 默认隐藏原值班助理选择框
            $("#chosen_replaced").hide();

			/* ios switch */
			var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {
                color: '#1AB394'
            });

            /* Radio */
            $('#replaced_yes').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#replaced_no').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            /* ionRangeSlider */
            $("#range_slider").ionRangeSlider({
            	min: moment().startOf("day").add(7.5, "hours").format("X"),
                max: moment().startOf("day").add(22, "hours").format("X"),
                from: +moment().subtract(2, "hours").format("X"),
                to: +moment().format("X"),
                type: "double",
                keyboard: true,
                keyboard_step: 0.1,
                grid: true,
                grid_num: 29,
                prettify: function (num) {
                	return moment(num, "X").format("HH:mm");
                },
                onStart: function (data) {
                    saveResult(data);
                },
                onChange: saveResult,
                onFinish: saveResult
            });
            
		});

		/* Chosen */
        var config = {
                '.chosen-select': {
                	// 实现中间字符的模糊查询
                	search_contains: true,
                	no_results_text: "没有找到",
                	disable_search_threshold: 10
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
