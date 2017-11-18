<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-查看个人资料</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/simditor/simditor.css' ?>" rel="stylesheet">
    
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
                            <strong>查看个人资料</strong>
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
                                <h5><?php echo('['.$personal_data->name.']'); ?>的个人资料 </h5>
                            </div>
                            <div class="ibox-content">
                                
                                    <img src="<?=base_url() . 'upload/avatar/' . $personal_data->avatar ?>" class="img-circle circle-border m-b-md per-time-avatar" alt="profile">
                                
                                <form role="form" id="form" class="form-horizontal">
                                	<div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">姓名</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $personal_data->name; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">性别</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo($personal_data->sex == 0 ? '男' : '女'); ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">职务</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label">
                                            <?php if ($level_name == "贵宾") {
                                                echo($level_name . '&nbsp;&nbsp;');
                                                echo('<img src="'. base_url() . 'assets/images/lrzvip.png" title="这里的今天，有我过往努力的见证~">');
                                            } else {
                                                echo($level_name);
                                            } ?>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">组别</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $group_name; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">状态</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $nowstate; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">手机</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $personal_data->phone; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">短号</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $personal_data->shortphone; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">QQ</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $personal_data->qq; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">微信</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $personal_data->wechat; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">学号</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $personal_data->studentid; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">学院</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $personal_data->school; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">宿舍</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo $personal_data->address; ?></label>
                                        </div>
                                    </div>
                                    
                                	<div class="form-group">
                                        <label class="col-sm-1" style="padding-top: 7px">入职日期</label>
                                        <div class="col-sm-4">
                                            <label class="col-sm-offset-1 control-label"><?php echo substr($personal_data->indate, 0, 10); ?></label>
                                        </div>
                                    </div>
                                    <br/><br/>
                                </form>
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
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#mini").attr("href", "#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>

    <!-- Input Mask-->
    <script src="<?=base_url().'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>
    
    <!-- Jquery Validate -->
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/validate/jquery.validate.min.js' ?>"></script>
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/validate/messages_zh.min.js' ?>"></script>
    
</body>

</html>
