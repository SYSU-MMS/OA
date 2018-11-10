<<<<<<< HEAD
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-查看用户列表</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/simditor/simditor.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/dialog/bootstrap-dialog.min.css' ?>" rel="stylesheet">
    
    <!-- Data Tables -->
    <link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

</head>

<body onload="startTime()">
    <!-- 主部 -->
    <div id="wrapper">
        <?php $this->load->view('view_nav'); ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <!-- 头部 -->
            <?php $this->load->view('view_header'); ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2 id="time"></h2>
                    <ol class="breadcrumb">
                        <li>
                            MOA
                        </li>
                        <?php 
	                        if ($_SESSION['level'] >= 3) { echo 
		                        '<li>' . 
		                        	'用户管理' . 
		                        '</li>';
	                        } 
                        ?>
                        <li>
                            <strong>通讯录</strong>
                        </li>	
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            
            <!-- 主内容 -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="panel blank-panel">
                    <div class="ibox-content">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li id="m_active" class="active"><a data-toggle="tab" href="tabs_panels.html#onwork">在岗员工</a>
                                    </li>
                                    <li id="n_active"><a data-toggle="tab" href="tabs_panels.html#allusr">全体用户</a>
                                    </li>
                                    <li id="e_active"><a data-toggle="tab" href="tabs_panels.html#stars">名人堂</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body my-panel-body">
                            <div class="tab-content">
                                <div id="onwork" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox float-e-margins">
                                                <table class="table table-striped table-bordered table-hover users-dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>序号</th>
                                                            <th>姓名</th>
                                                            <th>性别</th>
                                                            <th>职务</th>
                                                            <th>组别</th>
                                                            <th>手机</th>
                                                            <th>常检课室</th>
                                                            <th>周检课室</th>
                                                            <th>操作</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < count($users); $i++) { 
                                                            if ($users[$i]->level == 6) {
                                                                continue;
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo('<a href="' . site_url() . '/PersonalData/showOthersPersonalData/' . $users[$i]->uid . '">' . $users[$i]->name . '</a>'); ?></td>
                                                                <td><?php echo($users[$i]->sex == 0 ? '男':'女'); ?></td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($users[$i]->level) {
                                                                            case 0: echo '普通助理'; break;
                                                                            case 1: echo '组长'; break;
                                                                            case 2: echo '负责人助理'; break;
                                                                            case 3: echo '助理负责人'; break;
                                                                            case 4: echo '管理员'; break;
                                                                            case 5: echo '办公室负责人'; break;
                                                                            case 6: echo '超级管理员'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($workers[$i]->group) {
                                                                            case 0: echo 'N'; break;
                                                                            case 1: echo 'A'; break;
                                                                            case 2: echo 'B'; break;
                                                                            case 3: echo 'C'; break;
                                                                            case 4: echo '拍摄'; break;
                                                                            case 5: echo '网页'; break;
                                                                            case 6: echo '系统'; break;
                                                                            case 7: echo '管理'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td><?php echo $users[$i]->phone; ?></td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($workers[$i]->group) {
                                                                            case 0: echo str_replace(',', ' ', $workers[$i]->classroom); break;
                                                                            case 1: echo str_replace(',', ' ', $workers[$i]->classroom); break;
                                                                            case 2: echo str_replace(',', ' ', $workers[$i]->classroom); break;
                                                                            default: echo '无'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($workers[$i]->group) {
                                                                            case 0: echo str_replace(',', ' ', $workers[$i]->week_classroom); break;
                                                                            case 1: echo str_replace(',', ' ', $workers[$i]->week_classroom); break;
                                                                            case 2: echo str_replace(',', ' ', $workers[$i]->week_classroom); break;
                                                                            default: echo '无'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" data-toggle="modal" href="<?php echo 'searchuser#modal-form' . $i; ?>" id="<?php echo $i; ?>" name="more_info"
                                                                    class="btn btn-xs btn-outline btn-default" value="<?php echo $i; ?>" onclick="showMore(event);" style="margin-bottom: -5px;">更多信息</button>
                                                                    <?php 
                                                                        // 检查权限: 3-助理负责人 5-办公室负责人 6-超级管理员
                                                                        if ($_SESSION['level'] != 3 && $_SESSION['level'] != 5 && $_SESSION['level'] != 6) {
                                                                            echo '<button type="button" data-toggle="modal" data-target="#myModal" id="' .  $users[$i]->uid . '" name="delete"' . ' style="display: none;"' . 
                                                                                'class="btn btn-xs btn-outline btn-danger" value="' . $users[$i]->uid . '" onclick="setId(this.id);" style="margin-bottom: -5px;"><i class="fa fa-close"></i><span> 移除</span></button>';
                                                                        } else {
                                                                            echo '<button type="button" data-toggle="modal" data-target="#myModal" id="' .  $users[$i]->uid . '" name="delete"' . 
                                                                                'class="btn btn-xs btn-outline btn-danger" value="' . $users[$i]->uid . '" onclick="setId(this.id);" style="margin-bottom: -5px;"><i class="fa fa-close"></i><span> 移除</span></button>';
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div id="allusr" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox float-e-margins">
                                                <table class="table table-striped table-bordered table-hover users-dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>序号</th>
                                                            <th>姓名</th>
                                                            <th>性别</th>
                                                            <th>职务</th>
                                                            <th>组别</th>
                                                            <th>手机</th>
                                                            <th>学院</th>
                                                            <th>状态</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < count($alusers); $i++) { 
                                                            if ($alusers[$i]->level == 6) {
                                                                continue;
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo('<a href="' . site_url() . '/PersonalData/showOthersPersonalData/' . $alusers[$i]->uid . '">' . $alusers[$i]->name . '</a>'); ?></td>
                                                                <td><?php echo($alusers[$i]->sex == 0 ? '男':'女'); ?></td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($alusers[$i]->level) {
                                                                            case -1: echo '贵宾'; break;
                                                                            case 0: echo '普通助理'; break;
                                                                            case 1: echo '组长'; break;
                                                                            case 2: echo '负责人助理'; break;
                                                                            case 3: echo '助理负责人'; break;
                                                                            case 4: echo '管理员'; break;
                                                                            case 5: echo '办公室负责人'; break;
                                                                            case 6: echo '超级管理员'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($alworkers[$i]->group) {
                                                                            case 0: echo 'N'; break;
                                                                            case 1: echo 'A'; break;
                                                                            case 2: echo 'B'; break;
                                                                            case 3: echo 'C'; break;
                                                                            case 4: echo '拍摄'; break;
                                                                            case 5: echo '网页'; break;
                                                                            case 6: echo '系统'; break;
                                                                            case 7: echo '管理'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td><?php echo $alusers[$i]->phone; ?></td>
                                                                <td><?php echo $alusers[$i]->school; ?></td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($alusers[$i]->state) {
                                                                            case 0: echo '在岗'; break;
                                                                            case 1: echo '封停'; break;
                                                                            case 3: echo '离职'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="stars" class="tab-pane" style="padding-bottom: 15px">
                                    <?php
                                        if ($_SESSION['level'] >= 3) {
                                            echo('<div class="col-sm-12" style="text-align: right">');
                                            echo('<h3><a href="' . site_url() . '/UserManagement/addStarMember">添加</a></h3>');
                                            echo('</div>');
                                            echo('<br/>');
                                        }
                                    ?>
                                    <?php
                                        $maxLen = count($starobj);
                                        $maxLine = ceil($maxLen / 2.0);
                                        for ($i = 0; $i < $maxLen; $i++) {
                                            echo('<div class="col-sm-6 clearfix" style="margin-bottom:5px">');
                                            echo('<img alt="image" id="nav-avatar" class="img-circle pull-left" style="margin-right: 15px" src="' . base_url() . 'upload/avatar/' . $starusrobj[$i]->avatar . '" />');
                                            echo('<div style="margin-top: 5px; height: 65px">');
                                            echo('<a href="' . site_url() . '/PersonalData/showOthersPersonalData/' . $starusrobj[$i]->uid . '"><b>' . $starusrobj[$i]->name . '</b></a>');
                                            if ($_SESSION['level'] >= 3) {
                                                echo('&nbsp;&nbsp;&nbsp;&nbsp;');
                                                echo('<a href="' . site_url() . '/UserManagement/deleteStarInfo/' . $starobj[$i]->starid . '">删除</a>');
                                            }
                                            echo('<br/>');
                                            echo($starobj[$i]->description);
                                            echo('</div>');
                                            echo('<br/>');
                                            if (ceil(($i + 1) / 2.0) != $maxLine) {
                                                echo('<div class="hr-line-dashed" style="margin: 10px"></div>');
                                            }
                                            echo('</div>');
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('view_footer'); ?>
        </div>
    </div>
    
    <!-- 弹出的详细框 -->
    <?php for ($i = 0; $i < count($users); $i++) { ?>
	    <div id="<?php echo 'modal-form' . $i; ?>" class="modal fade" aria-hidden="true">
	        <div class="modal-dialog">
	            <div class="modal-content">
	            	<div class="modal-header">
	            		<h4 class='modal-title' id="modal_header" style='text-align: center'><?php echo($users[$i]->name . ' (' . ($users[$i]->sex == 0 ? '男':'女') .')'); ?> - 详细信息</h4>
	                </div>
                    <br>
                    <div class="col-sm-offset-5">
		            	&nbsp;&nbsp;&nbsp;&nbsp;<img alt="image" id="nav-avatar" class="img-circle" src="<?=base_url() . 'upload/avatar/' . $users[$i]->avatar ?>" />
		            </div>
	                <div class="modal-body">
	                    <div class="row">
	                    
	                            <div class="list-group col-sm-6">
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">用户名</h3>
	                                    <p class="list-group-item-text" id="info_username"><?php echo $users[$i]->username; ?></p>
                                        </p>
	                                </div>
	
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">QQ</h3>
	                                    <p class="list-group-item-text" id="info_qq"><?php echo $users[$i]->qq; ?></p>
	                                </div>
	
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">微信</h3>
	                                    <p class="list-group-item-text" id="info_wechat"><?php echo $users[$i]->wechat; ?></p>
	                                </div>
	                            </div>
	                            
	                            <div class="list-group col-sm-6">
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">学院</h3>
	                                    <p class="list-group-item-text" id="info_school"><?php echo $users[$i]->school; ?></p>
	                                </div>
	
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">宿舍</h3>
	                                    <p class="list-group-item-text" id="info_address"><?php echo $users[$i]->address; ?></p>
	                                </div>
	                                
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">入职日期</h3>
	                                    <p class="list-group-item-text" id="info_indate"><?php echo substr($users[$i]->indate, 0, 10); ?></p>
	                                </div>
	                            </div>
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
    <?php } ?>
    
    <!-- 弹出的抛弃用户框 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10;">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="myModalLabel">温馨提示</h4>
	            </div>
	            <div id="modal-body" class="modal-body">
	                <h2 id="submit_result" style="text-align:center;"><i class="fa fa-exclamation-circle exclamation-info"><span class="exclamation-desc"> 移除后不可恢复，确定要抛弃Ta吗？</span></i></h2>
	            </div>
	            <div id="modal-footer" class="modal-footer">
	            	<div class="row">
	            		<div class="col-sm-6">
			            	<button id="confirm_delete" type="button" class="btn btn-primary" onclick="deleteUser(this.id)">确定</button>
	            		</div>
	            		<div class="col-sm-6">
	            			<button type="button" class="btn btn-danger cancelBtn" data-dismiss="modal">取消</button>
	            		</div>
	            	</div>
	            </div>
	        </div>
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
			$("#active-userManagement").addClass("active");
			$("#active-searchUser").addClass("active");
			$("#mini").attr("href", "searchUser#");
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
    
    <!-- Dialog -->
    <script src="<?=base_url().'assets/js/plugins/dialog/bootstrap-dialog.min.js' ?>"></script>
    
    <!-- Data Tables -->
    <script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>
    
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
=======
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-查看用户列表</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/simditor/simditor.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/dialog/bootstrap-dialog.min.css' ?>" rel="stylesheet">
    
    <!-- Data Tables -->
    <link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

</head>

<body onload="startTime()">
    <!-- 主部 -->
    <div id="wrapper">
        <?php $this->load->view('view_nav'); ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <!-- 头部 -->
            <?php $this->load->view('view_header'); ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2 id="time"></h2>
                    <ol class="breadcrumb">
                        <li>
                            MOA
                        </li>
                        <?php 
	                        if ($_SESSION['level'] >= 3) { echo 
		                        '<li>' . 
		                        	'用户管理' . 
		                        '</li>';
	                        } 
                        ?>
                        <li>
                            <strong>通讯录</strong>
                        </li>	
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            
            <!-- 主内容 -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="panel blank-panel">
                    <div class="ibox-content">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li id="m_active" class="active"><a data-toggle="tab" href="tabs_panels.html#onwork">在岗员工</a>
                                    </li>
                                    <li id="n_active"><a data-toggle="tab" href="tabs_panels.html#allusr">全体用户</a>
                                    </li>
                                    <li id="e_active"><a data-toggle="tab" href="tabs_panels.html#stars">名人堂</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body my-panel-body">
                            <div class="tab-content">
                                <div id="onwork" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox float-e-margins">
                                                <table class="table table-striped table-bordered table-hover users-dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>序号</th>
                                                            <th>姓名</th>
                                                            <th>性别</th>
                                                            <th>职务</th>
                                                            <th>组别</th>
                                                            <th>手机</th>
                                                            <th>常检课室</th>
                                                            <th>周检课室</th>
                                                            <th>操作</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < count($users); $i++) { 
                                                            if ($users[$i]->level == 6) {
                                                                continue;
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo('<a href="' . site_url() . '/PersonalData/showOthersPersonalData/' . $users[$i]->uid . '">' . $users[$i]->name . '</a>'); ?></td>
                                                                <td><?php echo($users[$i]->sex == 0 ? '男':'女'); ?></td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($users[$i]->level) {
                                                                            case 0: echo '普通助理'; break;
                                                                            case 1: echo '组长'; break;
                                                                            case 2: echo '负责人助理'; break;
                                                                            case 3: echo '助理负责人'; break;
                                                                            case 4: echo '管理员'; break;
                                                                            case 5: echo '办公室负责人'; break;
                                                                            case 6: echo '超级管理员'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($workers[$i]->group) {
                                                                            case 0: echo 'N'; break;
                                                                            case 1: echo 'A'; break;
                                                                            case 2: echo 'B'; break;
                                                                            case 3: echo 'C'; break;
                                                                            case 4: echo '拍摄'; break;
                                                                            case 5: echo '网页'; break;
                                                                            case 6: echo '系统'; break;
                                                                            case 7: echo '管理'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td><?php echo $users[$i]->phone; ?></td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($workers[$i]->group) {
                                                                            case 0: echo str_replace(',', ' ', $workers[$i]->classroom); break;
                                                                            case 1: echo str_replace(',', ' ', $workers[$i]->classroom); break;
                                                                            case 2: echo str_replace(',', ' ', $workers[$i]->classroom); break;
                                                                            default: echo '无'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($workers[$i]->group) {
                                                                            case 0: echo str_replace(',', ' ', $workers[$i]->week_classroom); break;
                                                                            case 1: echo str_replace(',', ' ', $workers[$i]->week_classroom); break;
                                                                            case 2: echo str_replace(',', ' ', $workers[$i]->week_classroom); break;
                                                                            default: echo '无'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" data-toggle="modal" href="<?php echo 'searchuser#modal-form' . $i; ?>" id="<?php echo $i; ?>" name="more_info"
                                                                    class="btn btn-xs btn-outline btn-default" value="<?php echo $i; ?>" onclick="showMore(event);" style="margin-bottom: -5px;">更多信息</button>
                                                                    <?php 
                                                                        // 检查权限: 3-助理负责人 5-办公室负责人 6-超级管理员
                                                                        if ($_SESSION['level'] != 3 && $_SESSION['level'] != 5 && $_SESSION['level'] != 6) {
                                                                            echo '<button type="button" data-toggle="modal" data-target="#myModal" id="' .  $users[$i]->uid . '" name="delete"' . ' style="display: none;"' . 
                                                                                'class="btn btn-xs btn-outline btn-danger" value="' . $users[$i]->uid . '" onclick="setId(this.id);" style="margin-bottom: -5px;"><i class="fa fa-close"></i><span> 移除</span></button>';
                                                                        } else {
                                                                            echo '<button type="button" data-toggle="modal" data-target="#myModal" id="' .  $users[$i]->uid . '" name="delete"' . 
                                                                                'class="btn btn-xs btn-outline btn-danger" value="' . $users[$i]->uid . '" onclick="setId(this.id);" style="margin-bottom: -5px;"><i class="fa fa-close"></i><span> 移除</span></button>';
                                                                        }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div id="allusr" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox float-e-margins">
                                                <table class="table table-striped table-bordered table-hover users-dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>序号</th>
                                                            <th>姓名</th>
                                                            <th>性别</th>
                                                            <th>职务</th>
                                                            <th>组别</th>
                                                            <th>手机</th>
                                                            <th>学院</th>
                                                            <th>状态</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 0; $i < count($alusers); $i++) { 
                                                            if ($alusers[$i]->level == 6) {
                                                                continue;
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo('<a href="' . site_url() . '/PersonalData/showOthersPersonalData/' . $alusers[$i]->uid . '">' . $alusers[$i]->name . '</a>'); ?></td>
                                                                <td><?php echo($alusers[$i]->sex == 0 ? '男':'女'); ?></td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($alusers[$i]->level) {
                                                                            case -1: echo '贵宾'; break;
                                                                            case 0: echo '普通助理'; break;
                                                                            case 1: echo '组长'; break;
                                                                            case 2: echo '负责人助理'; break;
                                                                            case 3: echo '助理负责人'; break;
                                                                            case 4: echo '管理员'; break;
                                                                            case 5: echo '办公室负责人'; break;
                                                                            case 6: echo '超级管理员'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($alworkers[$i]->group) {
                                                                            case 0: echo 'N'; break;
                                                                            case 1: echo 'A'; break;
                                                                            case 2: echo 'B'; break;
                                                                            case 3: echo 'C'; break;
                                                                            case 4: echo '拍摄'; break;
                                                                            case 5: echo '网页'; break;
                                                                            case 6: echo '系统'; break;
                                                                            case 7: echo '管理'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td><?php echo $alusers[$i]->phone; ?></td>
                                                                <td><?php echo $alusers[$i]->school; ?></td>
                                                                <td>
                                                                    <?php 
                                                                        switch ($alusers[$i]->state) {
                                                                            case 0: echo '在岗'; break;
                                                                            case 1: echo '封停'; break;
                                                                            case 3: echo '离职'; break;
                                                                        }
                                                                     ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="stars" class="tab-pane" style="padding-bottom: 15px">
                                    <?php
                                        if ($_SESSION['level'] >= 3) {
                                            echo('<div class="col-sm-12" style="text-align: right">');
                                            echo('<h3><a href="' . site_url() . '/UserManagement/addStarMember">添加</a></h3>');
                                            echo('</div>');
                                            echo('<br/>');
                                        }
                                    ?>
                                    <?php
                                        $maxLen = count($starobj);
                                        $maxLine = ceil($maxLen / 2.0);
                                        for ($i = 0; $i < $maxLen; $i++) {
                                            echo('<div class="col-sm-6 clearfix" style="margin-bottom:5px">');
                                            echo('<img alt="image" id="nav-avatar" class="img-circle pull-left" style="margin-right: 15px" src="' . base_url() . 'upload/avatar/' . $starusrobj[$i]->avatar . '" />');
                                            echo('<div style="margin-top: 5px; height: 65px">');
                                            echo('<a href="' . site_url() . '/PersonalData/showOthersPersonalData/' . $starusrobj[$i]->uid . '"><b>' . $starusrobj[$i]->name . '</b></a>');
                                            if ($_SESSION['level'] >= 3) {
                                                echo('&nbsp;&nbsp;&nbsp;&nbsp;');
                                                echo('<a href="' . site_url() . '/UserManagement/deleteStarInfo/' . $starobj[$i]->starid . '">删除</a>');
                                            }
                                            echo('<br/>');
                                            echo($starobj[$i]->description);
                                            echo('</div>');
                                            echo('<br/>');
                                            if (ceil(($i + 1) / 2.0) != $maxLine) {
                                                echo('<div class="hr-line-dashed" style="margin: 10px"></div>');
                                            }
                                            echo('</div>');
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('view_footer'); ?>
        </div>
    </div>
    
    <!-- 弹出的详细框 -->
    <?php for ($i = 0; $i < count($users); $i++) { ?>
	    <div id="<?php echo 'modal-form' . $i; ?>" class="modal fade" aria-hidden="true">
	        <div class="modal-dialog">
	            <div class="modal-content">
	            	<div class="modal-header">
	            		<h4 class='modal-title' id="modal_header" style='text-align: center'><?php echo($users[$i]->name . ' (' . ($users[$i]->sex == 0 ? '男':'女') .')'); ?> - 详细信息</h4>
	                </div>
                    <br>
                    <div class="col-sm-offset-5">
		            	&nbsp;&nbsp;&nbsp;&nbsp;<img alt="image" id="nav-avatar" class="img-circle" src="<?=base_url() . 'upload/avatar/' . $users[$i]->avatar ?>" />
		            </div>
	                <div class="modal-body">
	                    <div class="row">
	                    
	                            <div class="list-group col-sm-6">
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">用户名</h3>
	                                    <p class="list-group-item-text" id="info_username"><?php echo $users[$i]->username; ?></p>
                                        </p>
	                                </div>
	
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">QQ</h3>
	                                    <p class="list-group-item-text" id="info_qq"><?php echo $users[$i]->qq; ?></p>
	                                </div>
	
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">微信</h3>
	                                    <p class="list-group-item-text" id="info_wechat"><?php echo $users[$i]->wechat; ?></p>
	                                </div>
	                            </div>
	                            
	                            <div class="list-group col-sm-6">
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">学院</h3>
	                                    <p class="list-group-item-text" id="info_school"><?php echo $users[$i]->school; ?></p>
	                                </div>
	
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">宿舍</h3>
	                                    <p class="list-group-item-text" id="info_address"><?php echo $users[$i]->address; ?></p>
	                                </div>
	                                
	                                <div class="list-group-item">
	                                    <h3 class="list-group-item-heading">入职日期</h3>
	                                    <p class="list-group-item-text" id="info_indate"><?php echo substr($users[$i]->indate, 0, 10); ?></p>
	                                </div>
	                            </div>
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
    <?php } ?>
    
    <!-- 弹出的抛弃用户框 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10;">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="myModalLabel">温馨提示</h4>
	            </div>
	            <div id="modal-body" class="modal-body">
	                <h2 id="submit_result" style="text-align:center;"><i class="fa fa-exclamation-circle exclamation-info"><span class="exclamation-desc"> 移除后不可恢复，确定要抛弃Ta吗？</span></i></h2>
	            </div>
	            <div id="modal-footer" class="modal-footer">
	            	<div class="row">
	            		<div class="col-sm-6">
			            	<button id="confirm_delete" type="button" class="btn btn-primary" onclick="deleteUser(this.id)">确定</button>
	            		</div>
	            		<div class="col-sm-6">
	            			<button type="button" class="btn btn-danger cancelBtn" data-dismiss="modal">取消</button>
	            		</div>
	            	</div>
	            </div>
	        </div>
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
			$("#active-userManagement").addClass("active");
			$("#active-searchUser").addClass("active");
			$("#mini").attr("href", "searchUser#");
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
    
    <!-- Dialog -->
    <script src="<?=base_url().'assets/js/plugins/dialog/bootstrap-dialog.min.js' ?>"></script>
    
    <!-- Data Tables -->
    <script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>
    
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
>>>>>>> abnormal
