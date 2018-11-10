<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-个人主页</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

</head>


<body>
    <div id="wrapper">
        <?php $this->load->view('view_nav'); ?>
                
        <div id="page-wrapper" class="gray-bg sidebar-content">
            <?php $this->load->view('view_header'); ?>
            
            <div class="sidebard-panel">
                <div>
					<?php
					// 检查权限: 3-助理负责人 5-办公室负责人 6-超级管理员
					if ($_SESSION['level'] == 3 || $_SESSION['level'] == 5 || $_SESSION['level'] == 6) {
						// 提示权限不够
						echo '<a id="site_url" href="' . site_url('Notify') . '" class="btn btn-xs btn-primary pull-right m-t-n-xs"><i class="fa fa-gear"></i> 编辑</a>';
					} else {
						echo '<a id="site_url" href="' . site_url('Notify') . '" class="btn btn-xs btn-primary pull-right m-t-n-xs"><i class="fa fa-info"></i> 全部</a>';
					}
					?>
                    <h4>通知 </h4>
                    
                    <!-- 通知区 -->
                    
                    <div id="more-notices-btn" class="feed-element" style="margin-top: 25px;">
	                    <div class="social-feed-box">
	                        <button id="more_notices" class="btn btn-primary btn-block"><i class="fa fa-arrow-down"></i> 显示更多</button>
	                    </div>
	                </div>
                    
                    
                    
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <!-- 评论区 -->
                
                <div class="row">
                	<div class="col-lg-12" style="margin-bottom: -25px;">
                		<div class="ibox float-e-margins animated fadeInDown">
				            <div class="ibox-content white-bg" style="border-width: 0;">
				            	<button class="btn btn-primary pull-right m-t-n-xs" data-toggle="modal" data-target="#myModal" style="margin: 4px 8px;">
				            		<i class="fa fa-commenting-o"></i> 留言 
				            	</button>
				            	<h2 style="padding-bottom: 10px;">留言板</h2>
				            </div>
				        </div>
                	</div>
                </div>
                
                <div class="row">
                	<div class="col-lg-12">
		            	<div class="ibox float-e-margins animated fadeInDown">
				            <div class="ibox-content white-bg" style="border-width: 0; padding-bottom: 50px;">
				            	<div id="scroll-content">
					                <div id="post-circle" style="margin-right: 8px;">
					                
						                <!-- 留言&评论区 -->
		
						                <div id="more-btn" class="social-feed-separated" style="margin-top: 25px;">
						                    <div class="social-avatar" style="visibility: hidden;">
						                        <a href="">
						                            <img alt="image" src="">
						                        </a>
						                    </div>
						                    <div class="social-feed-box">
						                        <button id="more_posts" class="btn btn-primary btn-block" style="margin-bottom: -40px;"><i class="fa fa-arrow-down"></i> 显示更多</button>
						                    </div>
						                </div>				                    
						          
						                <!-- paginator
										<div style="margin-left: 150px;">
						            		<ul id="paginator" class="pagination"></ul>
						            	</div>
						            	 -->
						            	 
						            </div>
					            </div>
					        </div>
			            </div>
		            </div>
		            
	         	</div>
	         	<!-- 评论区 -->
            </div>
            
            <?php $this->load->view('view_footer'); ?>
        </div>
    </div>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10;">
	    <div class="modal-dialog">
	        <div class="modal-content" style="margin-top: 90px;">
	            <div class="modal-header">
	                <h4 class="modal-title" id="myModalLabel">我的留言</h4>
	            </div>
	            <div class="modal-body">
	            	<h2 id="submit_result" style="text-align:center;"><i class="fa fa-spin fa-spinner"></i></h2>
	                <div id="input-post" class="input-group input-group-sm">
	                    <textarea id="new-post" class="form-control" placeholder="请输入留言内容" style="height: 50px;"></textarea>
                    	<span class="input-group-btn">
                    		<button id="post-btn" class="btn btn-primary" type="button" data-dismiss="modal" style="height: 50px;"> 发送 </button>
                    	</span>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
    
    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/homepage.js' ?>"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>

    <!-- jQuery UI -->
    <script src="<?=base_url().'assets/js/plugins/jquery-ui/jquery-ui.min.js' ?>"></script>
    
    <!-- jqPaginator -->
    <script src="<?=base_url().'assets/js/plugins/jqPaginator/jqPaginator.min.js' ?>"></script>
    
    <!-- slimscroll -->
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-homepage").addClass("active");

			$("#submit_result").hide();

			/* slimScroll 
	        $(function(){
	            $('#scroll-content').slimScroll({
	                height: boxHeight,//原设为'600px',现改为boxHeight，即slimScroll没有发挥作用
	                railVisible:true,
	                allowPageScroll: true
	            });
	        });
			*/
	        
		});
	</script>
	
	<script>
		/* jqPaginator 
		$("#paginator").jqPaginator({
            totalPages: 100,
            visiblePages: 10,
            currentPage: 1,
            first: '<li class="first"><a href="javascript:void(0);">首页<\/a><\/li>',
            prev: '<li class="prev"><a href="javascript:void(0);"><i class="fa fa-arrow fa-arrow2"><\/i>上一页<\/a><\/li>',
            next: '<li class="next"><a href="javascript:void(0);">下一页<i class="arrow arrow3"><\/i><\/a><\/li>',
            last: '<li class="last"><a href="javascript:void(0);">末页<\/a><\/li>',
            page: '<li class="page"><a href="javascript:void(0);">{{page}}<\/a><\/li>',
            onPageChange: function (page) {
            	//location.href = "homepage?id=" + page;
            	getDataByPage(page); //这个是获取指定页码数据的函数
                $("#page_info").html("当前第" + page + "页");
                $("#pagetxt").load("article.php?id="+page);
                Spinner.spin();
                $.ajax({
            		"url": '/data.php?start=' + this.slice[0] + '&end=' + this.slice[1] + '&page=' + page,
            		"success": function(data) {
            			Spinner.stop();
            			// content replace
            		}
            	});
            }
        });

		$("#pagetxt").ajaxSend(function(event, request, settings){
	        $(this).html("<img src='loading.gif' /> 正在读取。。。");
	    });
		*/
		
    </script>

</body>

</html>
