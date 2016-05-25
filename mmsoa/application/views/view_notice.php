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
                            <strong>管理通知</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
	            <div class="row">
	                <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>所有通知</h5>
                                <div class="ibox-tools">
                                    <a href="projects.html" class="btn btn-primary btn-xs">发布新通知</a>
                                </div>
                            </div>
                            <div class="ibox-content" style="padding-bottom: 20px;">
                                <div class="row m-b-sm m-t-sm">
                                    <div class="col-md-1">
                                        <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="input-group">
                                            <input type="text" placeholder="请输入项目名称" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="project-list">

                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td class="project-status">
                                                    <span class="label label-primary">进行中
		                                        </td>
		                                        <td class="project-title">
		                                            <a href="project_detail.html">LIKE－一款能够让用户快速获得认同感的兴趣社交应用</a>
		                                            <br/>
		                                            <small>创建于 2014.08.15</small>
		                                        </td>
		                                        <td class="project-completion">
		                                                <small>当前进度： 48%</small>
		                                                <div class="progress progress-mini">
		                                                    <div style="width: 48%;" class="progress-bar"></div>
		                                                </div>
		                                        </td>
		                                        <td class="project-people">
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a3.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a1.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a2.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a4.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a5.jpg' ?>"></a>
		                                        </td>
		                                        <td class="project-actions">
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> 删除 </a>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td class="project-status">
		                                            <span class="label label-primary">进行中
		                                        </td>
		                                        <td class="project-title">
		                                            <a href="project_detail.html">米莫说｜MiMO Show</a>
		                                            <br/>
		                                            <small>创建于 2014.08.15</small>
		                                        </td>
		                                        <td class="project-completion">
		                                            <small>当前进度： 28%</small>
		                                            <div class="progress progress-mini">
		                                                <div style="width: 28%;" class="progress-bar"></div>
		                                            </div>
		                                        </td>
		                                        <td class="project-people">
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a7.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a6.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a3.jpg' ?>"></a>
		                                        </td>
		                                        <td class="project-actions">
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> 删除 </a>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td class="project-status">
		                                            <span class="label label-default">已取消
		                                        </td>
		                                        <td class="project-title">
		                                            <a href="project_detail.html">商家与购物用户的交互试衣应用</a>
		                                            <br/>
		                                            <small>创建于 2014.08.15</small>
		                                        </td>
		                                        <td class="project-completion">
		                                            <small>当前进度： 8%</small>
		                                            <div class="progress progress-mini">
		                                                <div style="width: 8%;" class="progress-bar"></div>
		                                            </div>
		                                        </td>
		                                        <td class="project-people">
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a5.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a3.jpg' ?>"></a>
		                                        </td>
		                                        <td class="project-actions">
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> 删除 </a>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td class="project-status">
		                                            <span class="label label-primary">进行中
		                                        </td>
		                                        <td class="project-title">
		                                            <a href="project_detail.html">天狼---智能硬件项目</a>
		                                            <br/>
		                                            <small>创建于 2014.08.15</small>
		                                        </td>
		                                        <td class="project-completion">
		                                            <small>当前进度： 83%</small>
		                                            <div class="progress progress-mini">
		                                                <div style="width: 83%;" class="progress-bar"></div>
		                                            </div>
		                                        </td>
		                                        <td class="project-people">
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a2.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a3.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a1.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a7.jpg' ?>"></a>
		                                        </td>
		                                        <td class="project-actions">
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> 删除 </a>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td class="project-status">
		                                            <span class="label label-primary">进行中
		                                        </td>
		                                        <td class="project-title">
		                                            <a href="project_detail.html">乐活未来</a>
		                                            <br/>
		                                            <small>创建于 2014.08.15</small>
		                                        </td>
		                                        <td class="project-completion">
		                                            <small>当前进度： 97%</small>
		                                            <div class="progress progress-mini">
		                                                <div style="width: 97%;" class="progress-bar"></div>
		                                            </div>
		                                        </td>
		                                        <td class="project-people">
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a4.jpg' ?>"></a>
		                                        </td>
		                                        <td class="project-actions">
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> 删除 </a>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td class="project-status">
		                                            <span class="label label-primary">进行中
		                                        </td>
		                                        <td class="project-title">
		                                            <a href="project_detail.html">【私人医生项目】</a>
		                                            <br/>
		                                            <small>创建于 2014.08.15</small>
		                                        </td>
		                                        <td class="project-completion">
		                                            <small>当前进度： 48%</small>
		                                            <div class="progress progress-mini">
		                                                <div style="width: 48%;" class="progress-bar"></div>
		                                            </div>
		                                        </td>
		                                        <td class="project-people">
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a1.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a2.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a7.jpg' ?>"></a>
		                                            <a href="projects.html"><img alt="image" class="img-circle" src="<?=base_url().'assets/images/a5.jpg' ?>"></a>
		                                        </td>
		                                        <td class="project-actions">
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 查看 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
		                                            <a href="projects.html#" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> 删除 </a>
		                                        </td>
		                                    </tr>
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
    <script src="<?=base_url().'assets/js/onduty_in.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#mini").attr("href", "Notify#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>
    

</body>

</html>
