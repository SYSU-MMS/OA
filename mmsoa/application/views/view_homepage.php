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
                
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php $this->load->view('view_header'); ?>
            
            <div class="sidebard-panel">
                <div>
                    <h4>通知 <span class="badge badge-info pull-right">16</span></h4>
                    <div class="feed-element">
                        <a href="index_3.html#" class="pull-left">
                            <img alt="image" class="img-circle" src="<?=base_url().'assets/images/a1.jpg' ?>" >
                        </a>
                        <div class="media-body">
                            【通知】清明节放假安排
                            <br>
                            <small class="text-muted">Today 4:21 pm</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <a href="index_3.html#" class="pull-left">
                            <img alt="image" class="img-circle" src="<?=base_url().'assets/images/a1.jpg' ?>" >
                        </a>
                        <div class="media-body">
                            【排班结果】2016春多媒体3-17周排班结果
                            <br>
                            <small class="text-muted">Today 4:21 pm</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <a href="index_3.html#" class="pull-left">
                            <img alt="image" class="img-circle" src="<?=base_url().'assets/images/a2.jpg' ?>">
                        </a>
                        <div class="media-body">
                            【值班报名】2015-2016学年第三学期空余时间表
                            <br>
                            <small class="text-muted">Yesterday 2:45 pm</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <a href="index_3.html#" class="pull-left">
                            <img alt="image" class="img-circle" src="<?=base_url().'assets/images/a3.jpg' ?>">
                        </a>
                        <div class="media-body">
                            【通讯录核对】多媒体最新版通讯录信息核对
                            <br>
                            <small class="text-muted">Yesterday 1:10 pm</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <a href="index_3.html#" class="pull-left">
                            <img alt="image" class="img-circle" src="<?=base_url().'assets/images/a4.jpg' ?>">
                        </a>
                        <div class="media-body">
                            【A组常检抽查】A组第3周常检抽查结果公示
                            <br>
                            <small class="text-muted">Monday 8:37 pm</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <a href="index_3.html#" class="pull-left">
                            <img alt="image" class="img-circle" src="<?=base_url().'assets/images/a3.jpg' ?>">
                        </a>
                        <div class="media-body">
                            【B组常检抽查】B组第2周常检抽查结果公示
                            <br>
                            <small class="text-muted">Yesterday 1:10 pm</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <a href="index_3.html#" class="pull-left">
                            <img alt="image" class="img-circle" src="<?=base_url().'assets/images/a4.jpg' ?>">
                        </a>
                        <div class="media-body">
                            【周检抽查】第2周周检抽查结果公示
                            <br>
                            <small class="text-muted">Monday 8:37 pm</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInDown">
                <!-- 评论区 -->
                
                <div class="row col-sm-10">
                
	            	<div class="ibox">
	                	
			            <div class="ibox-content white-bg" style="border-width: 0;">
			            	<div id="scroll-content">
				                <div id="post-circle" style="margin-right: 8px;">
				                
					                <!-- 留言&评论区 -->
	
					                <div id="more-btn" class="social-feed-separated" style="margin-top: 25px;">
					                    <div class="social-avatar" style="visibility: hidden;">
					                        <a href="">
					                            <img alt="image" src="">
					                        </a>
					                    </div>
					                    <div class="social-feed-box" style="">
					                        <button id="more_posts" class="btn btn-block btn-outline btn-primary" type="button">更多</button>
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
		            <div id="small-chat">
			            <button class="open-small-chat div-shadow" data-toggle="modal" data-target="#myModal">
			                <i class="fa fa-plus" style="font-size: 18px;"></i>
			            </button>
			        </div>
	         	</div>
	         	<!-- 评论区 -->
            </div>
            
            <?php $this->load->view('view_footer'); ?>
        </div>
    </div>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10;">
	    <div class="modal-dialog" style="margin-top: 430px; margin-left: 266px;">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="myModalLabel">我的留言</h4>
	            </div>
	            <div class="modal-body">
	            	<h2 id="submit_result" style="text-align:center;"><i class="fa fa-spin fa-spinner"></i></h2>
	                <div id="input-post" class="input-group input-group-sm">
	                    <textarea id="new-post" class="form-control" placeholder="请输入留言内容" style="height: 50px;"></textarea>
                    	<span class="input-group-btn">
                    		<button id="post-btn" class="btn btn-primary" type="button" data-dismiss="modal" style="height: 50px;">留言</button>
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
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>

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

			/* slimScroll */
	        $(function(){
	            $('#scroll-content').slimScroll({
	                height: '520px',
	                railVisible:true,
	                allowPageScroll: true
	            });
	        });
	        
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
