<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="free-educational-responsive-web-template-webEdu">
	<meta name="author" content="webThemez.com">
	<title>MOA -东校区多媒体管理系统-</title>
	
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
	<link href="<?=base_url().'assets/images/favicon.png' ?>" rel="stylesheet">
	<link href="<?=base_url().'assets/css/bootstrap.min.css' ?>" rel="stylesheet">
	<link href="<?=base_url().'assets/css/font-awesome.min.css' ?>" rel="stylesheet">
	<link href="<?=base_url().'assets/css/bootstrap-theme.css' ?>" rel="stylesheet" media="screen">
	<link href="<?=base_url().'assets/css/home_style.css' ?>" rel="stylesheet">
	<link id='camera-css' href="<?=base_url().'assets/css/camera.css' ?>" rel="stylesheet" type='text/css' media='all'>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    <div class="logo">
        <a href="index.html"><img src="<?=base_url().'assets/images/m.png' ?>" width="150" align="center"></a>
    </div>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse">
		<div class="container">

			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav  mainNav">
					<li class="active"><a href="index.html">首页</a></li>
					<li><a href="index.php/lost_found/index">失物招领</a></li>
					<li><a href="testimonial.html">通知</a></li>
					<li><a href="contact.html">联系我们</a></li>

				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	<!-- /.navbar -->

	<!-- Header -->
	<header id="head">
		<div class="container">
             <div class="heading-text">							
							<h1 class="animated flipInY delay1">中山大学东校区多媒体管理系统</h1>
              <button type="button" onclick=<?php echo "'window.location.href=\"" . site_url("login") . "\"'"; ?> class="infos-button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;登陆&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
              
						</div>
            
			       <div class="fluid_container">                       
                <div class="camera_wrap camera_emboss pattern_1" id="camera_wrap_4">
                    <div data-thumb="<?=base_url().'assets/images/slides/thumbs/img1.jpg' ?>" data-src="<?=base_url().'assets/images/slides/img2.jpg' ?>">
                        <h2>We develop.</h2>
                    </div> 
                    <div data-thumb="<?=base_url().'assets/images/slides/thumbs/img2.jpg' ?>" data-src="<?=base_url().'assets/images/slides/img4.jpg' ?>">
                    </div>
                    <div data-thumb="<?=base_url().'assets/images/slides/thumbs/img3.jpg' ?>" data-src="<?=base_url().'assets/images/slides/img3.jpg' ?>">
                    </div> 
                </div><!-- #camera_wrap_3 -->
              </div><!-- .fluid_container -->
      		  </div>
      	 </header>
	<!-- /Header -->
    <section class="main-contents">
      <h2 class="text-center sub-texts">Welcome to MOA</h2>
      <div class="container">
      <hr>
         <div class="item-section col-md-4 col-sm-4 col-xs-12">
            <ul>
              <li class="inline-text">
                <i class="fa fa-star"></i><p class="icon-text">失物招领信息</p>
              </li>
            </ul>  
         </div>
         <div class="item-section col-md-4 col-sm-4 col-xs-12">
            <ul>
              <li class="inline-text">
                <i class="fa fa-star"></i><p class="icon-text">多媒体服务信息</p>
              </li>
            </ul>  
         </div>
         <div class="item-section col-md-4 col-sm-4 col-xs-12">
            <ul>
              <li class="inline-text">
                <i class="fa fa-star"></i><p class="icon-text">联系我们</p>
              </li>
            </ul>  
         </div>
     </div>
  </section>



  <footer>
    <div class="footer-bottom">
      <div class="container">
        <div class="social pull-left">
          <p><i class="fa fa-phone"></i>内线&nbsp;801&nbsp;/&nbsp;802<i class="fa fa-envelope-o"></i>rinkako@homu.me</p>
        </div>
        <div class="navigation">
          <ul class="pull-right">
            <li>Powered by MMS OA System</a></li>
          </ul>
        </div> 
      </div>
    </div>

	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="<?=base_url().'assets/js/modernizr-latest.js' ?>"></script>
	<script type='text/javascript' src="<?=base_url().'assets/js/jquery.min.js' ?>"></script>
	<script type='text/javascript' src="<?=base_url().'assets/js/jquery.mobile.customized.min.js' ?>"></script>
	<script type='text/javascript' src="<?=base_url().'assets/js/jquery.easing.1.3.js' ?>"></script>
	<script type='text/javascript' src="<?=base_url().'assets/js/camera.min.js' ?>"></script>
	<script src="<?=base_url().'assets/js/bootstrap.min.js' ?>"></script>
    
    <script>
		jQuery(function(){
			
			jQuery('#camera_wrap_4').camera({
                transPeriod: 500,
                time: 3000,
				height: '530',
				loader: 'false',
				pagination: true,
				thumbnails: false,
				hover: false,
                playPause: false,
                navigation: false,
				opacityOnGrid: false,
				imagePath: 'assets/images/'
			});

		});
      
	</script>
    
</body>
</html>
