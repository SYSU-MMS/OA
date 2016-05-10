<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-拍摄登记</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/js/plugins/layer/skin/layer.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/switchery/switchery.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/nouslider/nouislider.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/plugins/nouslider/nouislider.pips.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/plugins/nouslider/nouislider.tooltips.css' ?>" rel="stylesheet">
    
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
                            <strong>拍摄</strong>
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
                                <h5>拍摄登记</h5>
                            	<div class="ibox-content">
                                	<div class="panel blank-panel">

	                                    <div class="panel-heading">
	                                        <div class="panel-options">
	                                            <ul class="nav nav-tabs">
	                                                <li class="active"><a data-toggle="tab" href="tabs_panels.html#base">拍摄</a>
	                                                </li>
	                                            </ul>
	                                        </div>
	                                    </div>
	
	                                    <div class="panel-body my-panel-body">
	                                        <div class="tab-content">
	                                            <div id="base" class="tab-pane active">
	                                            	<div style="height:50px;">
	                                            		<h5>签到：
	                                            			<span><input type="checkbox" name="signin_filming" id="filming" class="js-switch" /></span>
	                                            		</h5>
	                                            	</div>
						                            <h5>拍摄时间：&nbsp;<small>请拖动绿条选择时间段</small></h5>
						                            <div class="ibox-content" style="margin-bottom: 0px; padding-bottom: 0px;">
						                                <div class="form-horizontal" id="filming_form">
						                                    <div class="form-group"  style="height: 70px;">
						                                		<div id="range_slider"></div>
						                                	</div>
						                                    <div class="hr-line-dashed"></div>
						                                    <div class="form-group">
						                                        <div class="col-sm-4 col-sm-offset-5">
						                                            <button id="submit_filming" class="btn btn-primary" disabled="" type="submit" 
						                                            data-toggle="modal" data-target="#myModal">提交</button>
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
    <script src="<?=base_url().'assets/js/filming_in.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-workrecord").addClass("active");
			$("#active-filming").addClass("active");
			$("#mini").attr("href", "Filming#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>
    
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

			/* ios switch */
			var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {
                color: '#1AB394'
            });

            /* ionRangeSlider */
            $("#range_slider").ionRangeSlider({
            	min: +moment().subtract(6, "hours").format("X"),
                max: +moment().add(5, "hours").format("X"),
                from: +moment().subtract(2, "hours").format("X"),
                to: +moment().format("X"),
                type: "double",
                keyboard: true,
                keyboard_step: 1,
                grid: true,
                grid_num: 11,
                prettify: function (num) {
                	return moment(num, "X").format("HH:mm");
                }
            });
            
		});
	</script>

</body>

</html>
