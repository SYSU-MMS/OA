<<<<<<< HEAD
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-个人资料</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/simditor/simditor.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.min.css?v=4.0.0' ?>" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2 id="time"></h2>
            <ol class="breadcrumb">
                <li>
                    MOA
                </li>
                <li>
                    <strong>个人资料</strong>
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
                        <h5>个人资料 </h5>
                    </div>
                    <div class="ibox-content">
                        <form role="form" id="form" class="form-horizontal">
                        
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">姓名</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_name" placeholder="请输入真实姓名" disabled="" 
                                    id="pd_name" class="form-control" value="<?php echo $_SESSION['name']; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">职务</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_level" placeholder="请输入职务" disabled="" 
                                    id="pd_level" class="form-control" value="<?php echo $_SESSION['level_name']; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">手机</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_phone" placeholder="请输入手机号码"  
                                    id="pd_phone" class="form-control" value="<?php echo $personal_data->phone; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">短号</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_shortphone" placeholder="请输入短号（选填）"  
                                    id="pd_shortphone" class="form-control" value="<?php echo $personal_data->shortphone; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">QQ</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_qq" placeholder="请输入QQ"  
                                    id="pd_qq" class="form-control" value="<?php echo $personal_data->qq; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">微信</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_wechat" placeholder="请输入微信号"  
                                    id="pd_wechat" class="form-control" value="<?php echo $personal_data->wechat; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">学号</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_studentid" placeholder="请输入学号"  
                                    id="pd_studentid" class="form-control" value="<?php echo $personal_data->studentid; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">学院</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pd_school" placeholder="请输入学院"  
                                    id="pd_school" class="form-control" value="<?php echo $personal_data->school; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">宿舍</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pd_address" placeholder="请输入宿舍号，如: 慎思园4号234"  
                                    id="pd_address" class="form-control" value="<?php echo $personal_data->address; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">银行卡号</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pd_creditcard" placeholder="请输入中大银行卡号"  
                                    id="pd_creditcard" class="form-control" value="<?php echo $personal_data->creditcard; ?>">
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">入职日期</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pd_indate" placeholder="请选择入职日期" disabled="" 
                                    id="pd_indate" class="form-control" value="<?php echo substr($personal_data->indate, 0, 10); ?>">
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit" id="submit_personaldata" 
                                    data-toggle="modal" data-target="#myModal">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  -->
                    <h4 class="modal-title" id="myModalLabel">提示</h4>
                </div>
                <div class="modal-body">
                        <h1 id="submit_result" style="color:#ED5565;text-align:center;"></h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/personaldata_in.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#mini").attr("href", "personaldata#");
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
    
        $(document).ready(function () {
            /* Validate */
        	$("#form").validate({
                rules: {
                    pd_phone: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    pd_shortphone: {
                        required: false,
                        number: true
                    },
                    pd_qq: {
                        required: true,
                        number: true
                    },
                    pd_studentid: {
                        required: true,
                        number: true
                    },
                    pd_creditcard: {
                        required: true,
                        number: true,
                        minlength: 19,
                        maxlength: 19
                    }
                }
            });
            
        });
        
    </script>

</body>
=======
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-个人资料</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/simditor/simditor.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.min.css?v=4.0.0' ?>" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2 id="time"></h2>
            <ol class="breadcrumb">
                <li>
                    MOA
                </li>
                <li>
                    <strong>个人资料</strong>
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
                        <h5>个人资料 </h5>
                    </div>
                    <div class="ibox-content">
                        <form role="form" id="form" class="form-horizontal">
                        
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">姓名</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_name" placeholder="请输入真实姓名" disabled="" 
                                    id="pd_name" class="form-control" value="<?php echo $_SESSION['name']; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">职务</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_level" placeholder="请输入职务" disabled="" 
                                    id="pd_level" class="form-control" value="<?php echo $_SESSION['level_name']; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">手机</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_phone" placeholder="请输入手机号码"  
                                    id="pd_phone" class="form-control" value="<?php echo $personal_data->phone; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">短号</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_shortphone" placeholder="请输入短号（选填）"  
                                    id="pd_shortphone" class="form-control" value="<?php echo $personal_data->shortphone; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">QQ</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_qq" placeholder="请输入QQ"  
                                    id="pd_qq" class="form-control" value="<?php echo $personal_data->qq; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">微信</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_wechat" placeholder="请输入微信号"  
                                    id="pd_wechat" class="form-control" value="<?php echo $personal_data->wechat; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">学号</label>
                                <div class="col-sm-2">
                                    <input type="text" name="pd_studentid" placeholder="请输入学号"  
                                    id="pd_studentid" class="form-control" value="<?php echo $personal_data->studentid; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">学院</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pd_school" placeholder="请输入学院"  
                                    id="pd_school" class="form-control" value="<?php echo $personal_data->school; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">宿舍</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pd_address" placeholder="请输入宿舍号，如: 慎思园4号234"  
                                    id="pd_address" class="form-control" value="<?php echo $personal_data->address; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">银行卡号</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pd_creditcard" placeholder="请输入中大银行卡号"  
                                    id="pd_creditcard" class="form-control" value="<?php echo $personal_data->creditcard; ?>">
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-offset-1 control-label">入职日期</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pd_indate" placeholder="请选择入职日期" disabled="" 
                                    id="pd_indate" class="form-control" value="<?php echo substr($personal_data->indate, 0, 10); ?>">
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit" id="submit_personaldata" 
                                    data-toggle="modal" data-target="#myModal">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  -->
                    <h4 class="modal-title" id="myModalLabel">提示</h4>
                </div>
                <div class="modal-body">
                        <h1 id="submit_result" style="color:#ED5565;text-align:center;"></h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/personaldata_in.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#mini").attr("href", "personaldata#");
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
    
        $(document).ready(function () {
            /* Validate */
        	$("#form").validate({
                rules: {
                    pd_phone: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    pd_shortphone: {
                        required: false,
                        number: true
                    },
                    pd_qq: {
                        required: true,
                        number: true
                    },
                    pd_studentid: {
                        required: true,
                        number: true
                    },
                    pd_creditcard: {
                        required: true,
                        number: true,
                        minlength: 19,
                        maxlength: 19
                    }
                }
            });
            
        });
        
    </script>

</body>
>>>>>>> abnormal
</html>