<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-周检登记</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/js/plugins/layer/skin/layer.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/switchery/switchery.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
    
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
                            <strong>周检</strong>
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
                                <h5>周检考勤 · 情况登记</h5>
                            	<div class="ibox-content">
                                	<div class="panel blank-panel">

	                                    <div class="panel-heading">
	                                        <div class="panel-options">
	                                            <ul class="nav nav-tabs">
	                                                <li class="active"><a data-toggle="tab" href="tabs_panels.html#base">周检</a>
	                                                </li>
	                                            </ul>
	                                        </div>
	                                    </div>
	
	                                    <div class="panel-body my-panel-body">
	                                        <div class="tab-content">
	                                            <div id="base" class="tab-pane active">
	                                            	<div style="height:50px;">
	                                            		<h5>签到：
	                                            			<span><input type="checkbox" name="signin_week" id="week" class="js-switch" /></span>
	                                            		</h5>
	                                            	</div>

                                                    <div style="height: 30px;">
                                                        <h5>是否代班：
                                                            <span>
	                                            				<label class="radio-inline" style="font-size: 14px;">
														        	<input type="radio" checked="" disabled="" value="0" id="replaced_no" class="my_radio" name="group_radio"> 否 </label>
														    	<label class="radio-inline" style="font-size: 14px;">
														        	<input type="radio" disabled="" value="1" id="replaced_yes" class="my_radio" name="group_radio"> 是 </label>
	                                            			</span>
                                                        </h5>
                                                    </div>

                                                    <div  id="chosen_replaced" style="height: 30px; position: relative; z-index: 999999;">
                                                        <h5>原周检助理：
                                                            <span>
					                                        	<select id="select_replaced" name="replaced_colleague" data-placeholder="请选择原值班助理" class="chosen-select col-sm-12" tabindex="4">
					                                        		<option value="">请选择原周检助理</option>
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
						                                <form role="form" class="form-horizontal" id="week_form">
                                                            <div class="form-group">
                                                                <h5>周检情况：&nbsp;<small>请在有问题的课室后面填写好记录，无问题的课室无需填写</small></h5>
                                                            </div>
                                                            <div id="rooms"></div>
						                                    <div class="hr-line-dashed"></div>
						                                    <div class="form-group">
						                                        <div class="col-sm-4 col-sm-offset-5">
						                                            <button id="submit_week" class="btn btn-primary" disabled="" type="submit"
						                                            data-toggle="modal" data-target="#myModal">提交</button>
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
            <?php $this->load->view('view_footer'); ?>
        </div>
    </div>
    
    <?php $this->load->view('view_modal'); ?>

    <!-- classroom info  -->
    <script>
        var classroom = JSON.parse(<?php echo '\''.$classroom_json.'\''  ?>);
        var wid = <?php echo $wid ?>;
    </script>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/weeklycheck_in.js' ?>"></script>
    
    <!-- nav item active -->
    <script>
		$(document).ready(function () {
			$("#active-workrecord").addClass("active");
			$("#active-weeklycheck").addClass("active");
			$("#mini").attr("href", "WeeklyCheck#");
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
    
    <!-- jQuery Validation plugin javascript-->
    <script src="<?=base_url().'assets/js/plugins/validate/jquery.validate.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/validate/messages_zh.min.js' ?>"></script>
    <script>
	  	//以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
	    $.validator.setDefaults({
	        highlight: function (element) {
	            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
	        },
	        success: function (element) {
	            element.closest('.form-group').removeClass('has-error').addClass('has-success');
	        },
	        errorElement: "span",
	        errorClass: "color-error m-b-none",
	        validClass: "color-success m-b-none"
	
	    });

         //以下为官方示例
        $().ready(function () {
            // validate the week form when it is submitted
            $("#week_form").validate({
            	rules: {
            		cond_lamp_0: {
                        required: true,
                        number: true
                    },
                    cond_lamp_1: {
                        required: true,
                        number: true
                    },
                    cond_lamp_2: {
                        required: true,
                        number: true
                    }
                }
            });

        });
    </script>
    
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
        	
    		var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {
                color: '#1AB394'
            });

            $("#chosen_replaced").hide();

            /* Radio */
            $('#replaced_yes').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#replaced_no').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
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
