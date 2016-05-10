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
						                            <h5>周检情况：&nbsp;<small>请在有问题的课室后面填写好记录，无问题的课室无需填写</small></h5>
						                            <div class="ibox-content" style="margin-bottom: 0px; padding-bottom: 0px;">
						                                <form role="form" class="form-horizontal" id="week_form">
						                                	<?php for ($i = 0; $i < count($classroom_list); $i++) { ?>
							                                	<div class="form-group">
							                                        <label class="col-sm-2 control-label"><?php echo $classroom_list[$i]; ?></label>
							                                        <div class="col-sm-8">
							                                            <input type="text" name="<?php echo 'cond_week_' . $i; ?>" placeholder="正常" disabled="" 
							                                            id="<?php echo 'week_' . $i; ?>" class="form-control">
							                                        </div>
							                                    </div>
							                                    <div class="form-group">
							                                        <div class="col-sm-2 col-sm-offset-2" style="width:150px;">
							                                            <input type="number" name="<?php echo 'cond_lamp_' . $i; ?>" placeholder="投影仪灯时" disabled="" 
							                                            id="<?php echo 'lamp_' . $i; ?>" class="form-control">
							                                        </div>
							                                        <h3><small>小时</small></h3>
							                                    </div>
							                                <?php } ?>
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
            
        });
    </script>
    
</body>

</html>
