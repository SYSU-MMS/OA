<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-常检登记</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/js/plugins/layer/skin/layer.css' ?>" rel="stylesheet">

	<link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">

	<link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/switchery/switchery.css' ?>" rel="stylesheet">
    
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
                            <strong>常检</strong>
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
                                <h5>常检考勤 · 情况登记</h5>
                            	<div class="ibox-content">
                                	<div class="panel blank-panel">

	                                    <div class="panel-heading">
	                                        <div class="panel-options">
	                                            <ul class="nav nav-tabs">
	                                                <li id="m_active" class="active"><a data-toggle="tab" href="tabs_panels.html#base">早检</a>
	                                                </li>
	                                                <li id="n_active"><a data-toggle="tab" href="tabs_panels.html#integrated">午检</a>
	                                                </li>
	                                                <li id="e_active"><a data-toggle="tab" href="tabs_panels.html#expand">晚检</a>
	                                                </li>
	                                            </ul>
	                                        </div>
	                                    </div>
	
	                                    <div class="panel-body my-panel-body">
	                                        <div class="tab-content">
	                                            <div id="base" class="tab-pane active">
	                                            	<div style="height:50px;">
	                                            		<h5>签到：
	                                            			<span><input type="checkbox" name="signin_morning" id="morning" class="js-switch" /></span>
	                                            		</h5>
	                                            	</div>

													<div style="height: 30px;">
														<h5>是否代班：
															<span>
	                                            				<label class="radio-inline" style="font-size: 14px;">
														        	<input type="radio" checked="" disabled="" value="0" id="replaced_no_morning" class="my_radio" name="group_radio_morning"> 否 </label>
														    	<label class="radio-inline" style="font-size: 14px;">
														        	<input type="radio" disabled="" value="1" id="replaced_yes_morning" class="my_radio" name="group_radio_morning"> 是 </label>
	                                            			</span>
														</h5>
													</div>

													<div id="chosen_replaced_morning" style="height: 30px; position: relative; z-index: 999999;">
														<h5 class="row">原早检助理：
															<span>
					                                        	<select id="select_replaced_morning" name="replaced_colleague" data-placeholder="请选择原值班助理" class="chosen-select chosen-morning col-sm-12" tabindex="4">
					                                        		<option value="0">请选择原早检助理</option>
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
				                                        	</span>
														</h5>
													</div>


						                            <div class="ibox-content" style="margin-bottom: 0px; padding-bottom: 0px;">
						                                <div class="form-horizontal">
															<div class="form-group">
																<h5>早检情况：&nbsp;<small>无故障的课室无需填写</small></h5>
															</div>
															<div id="rooms_morning"></div>
						                                    <div class="hr-line-dashed"></div>
						                                    <div class="form-group">
						                                        <div class="col-sm-4 col-sm-offset-5">
						                                            <button id="submit_morning" class="btn btn-primary" disabled="" type="submit" 
						                                            data-toggle="modal" data-target="#myModal">提交</button>
						                                        </div>
						                                    </div>
						                                </div>
						                            </div>
	                                            </div>


	                                            <div id="integrated" class="tab-pane">
	                                            	<div style="height:50px;">
	                                            		<h5>签到：
	                                            			<span"><input type="checkbox" name="signin_noon" id="noon" class="js-switch_2" /></span>
	                                            		</h5>
						                            </div>

													<div style="height: 30px;">
														<h5>是否代班：
															<span>
	                                            				<label class="radio-inline" style="font-size: 14px;">
														        	<input type="radio" checked="" disabled="" value="0" id="replaced_no_noon" class="my_radio" name="group_radio_noon"> 否 </label>
														    	<label class="radio-inline" style="font-size: 14px;">
														        	<input type="radio" disabled="" value="1" id="replaced_yes_noon" class="my_radio" name="group_radio_noon"> 是 </label>
	                                            			</span>
														</h5>
													</div>

													<div id="chosen_replaced_noon" style="height: 30px; position: relative; z-index: 999998;">
														<h5 class="row">原午检助理：
															<span>
					                                        	<select id="select_replaced_noon" name="replaced_colleague" data-placeholder="请选择原值班助理" class="chosen-select chosen-noon col-sm-12" tabindex="5">
					                                        		<option value="0">请选择原午检助理</option>
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
				                                        	</span>
														</h5>
													</div>

						                            <div class="ibox-content">
						                                <form method="post" class="form-horizontal">
															<div class="form-group">
																<h5>午检情况：&nbsp;<small>无故障的课室无需填写</small></h5>
															</div>
															<div id="rooms_noon"></div>
						                                    <div class="hr-line-dashed"></div>
						                                    <div class="form-group">
						                                        <div class="col-sm-4 col-sm-offset-5">
						                                            <button id="submit_noon" class="btn btn-primary" disabled="" type="submit" 
						                                            data-toggle="modal" data-target="#myModal" >提交</button>
						                                        </div>
						                                    </div>
						                                </form>
						                            </div>
	                                            </div>
	
	                                            <div id="expand" class="tab-pane">
	                                            	<div style="height:50px;">
	                                            		<h5>签到：
	                                            			<span><input type="checkbox" name="signin_evening" id="evening" class="js-switch_3" /></span>
	                                            		</h5>
						                            </div>

													<div style="height: 30px;">
														<h5>是否代班：
															<span>
	                                            				<label class="radio-inline" style="font-size: 14px;">
														        	<input type="radio" checked="" disabled="" value="0" id="replaced_no_evening" class="my_radio" name="group_radio_evening"> 否 </label>
														    	<label class="radio-inline" style="font-size: 14px;">
														        	<input type="radio" disabled="" value="1" id="replaced_yes_evening" class="my_radio" name="group_radio_evening"> 是 </label>
	                                            			</span>
														</h5>
													</div>

													<div id="chosen_replaced_evening" style="height: 30px; position: relative; z-index: 999997;">
														<h5 class="row">原晚检助理：
															<span>
					                                        	<select id="select_replaced_evening" name="replaced_colleague" data-placeholder="请选择原值班助理" class="chosen-select chosen-evening col-sm-12" tabindex="6">
					                                        		<option value="0">请选择原晚检助理</option>
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
				                                        	</span>
														</h5>
													</div>

						                            <div class="ibox-content">
						                                <form method="post" class="form-horizontal">
															<div class="form-group">
																<h5>晚检情况：&nbsp;<small>无故障的课室无需填写</small></h5>
															</div>
															<div id="rooms_evening"></div>
						                                    <div class="hr-line-dashed"></div>
						                                    <div class="form-group">
						                                        <div class="col-sm-4 col-sm-offset-5">
						                                            <button id="submit_evening" class="btn btn-primary" disabled="" type="submit" 
						                                            data-toggle="modal" data-target="#myModal">提交</button>
						                                            <!-- <button class="btn btn-white" type="submit">取消</button>  -->
						                                        </div>
						                                    </div>
						                                </form>
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
	        <?php $this->load->view('view_footer')?>
	    </div>
    </div>
    
    <?php $this->load->view('view_modal'); ?>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/dailycheck_in.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-workrecord").addClass("active");
			$("#active-dailycheck").addClass("active");
			$("#mini").attr("href", "DailyCheck#");
		});
	</script>

	<!-- classroom info  -->
	<script>
		var classroom = JSON.parse(<?php echo '\''.$classroom_json.'\''  ?>);
		var wid = <?php echo $wid ?>;
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
    
    <!-- layer javascript -->
    <script src="<?=base_url().'assets/js/plugins/layer/layer.js' ?>"></script>
    <script>
        layer.use('extend/layer.ext.js'); //载入layer拓展模块
    </script>

    <script src="<?=base_url().'assets/js/demo/layer-demo.js' ?>"></script>
    
    <!-- Switchery -->
    <script src="<?=base_url().'assets/js/plugins/switchery/switchery.js' ?>"></script>

    <!-- ios switch -->
    <script>
    	$(document).ready(function () {
    		// 页签active贴心设置
        	var myDate = new Date();
        	var time_now = myDate.getHours();
        	// 早上时间，早检页签active
        	if (time_now >= 6 && time_now <= 10) {
            	$('#m_active a:first-child').click();
        	}
        	// 中午下午时间，午检页签active
        	else if (time_now >= 11 && time_now <= 16) {
        		$('#n_active a:first-child').click();
            }
        	// 傍晚晚上时间，晚检页签active
        	else {
        		$('#e_active a:first-child').click();
            }
        	
    		var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {
                color: '#1AB394'
            });

            var elem_2 = document.querySelector('.js-switch_2');
            var switchery_2 = new Switchery(elem_2, {
                color: '#1AB394'
            });

            var elem_3 = document.querySelector('.js-switch_3');
            var switchery_3 = new Switchery(elem_3, {
                color: '#1AB394'
            });

			/* Radio */
			$('#replaced_yes_morning').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});

			$('#replaced_no_morning').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});

			$('#replaced_yes_noon').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});

			$('#replaced_no_noon').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});

			$('#replaced_yes_evening').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});

			$('#replaced_no_evening').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});

			// 默认隐藏原值班助理选择框
			$("#chosen_replaced_morning").hide();
			$("#chosen_replaced_noon").hide();
			$("#chosen_replaced_evening").hide();

        });


		/* Chosen */
		var config = {
			'.chosen-select': {
				// 实现中间字符的模糊查询
				search_contains: true,
				no_results_text: "没有找到",
				disable_search_threshold: 10,
				width: "220px"
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
		};

		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}

    </script>

</body>

</html>
