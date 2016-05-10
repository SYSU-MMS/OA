<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>MOA-登录</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.min.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/login.min.css' ?>" rel="stylesheet">
    
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>
        if(window.top!==window.self){window.top.location=window.location};
    </script>

</head>

<body class="signin" onkeydown="keyLogin();">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-7">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <h1>[ MOA ]</h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎使用 <strong>MOA 中山大学多媒体管理系统</strong></h4>
                    <ul class="m-b">
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优秀</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 高效</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优质</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 负责</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 团结</li>
                    </ul>
                    <strong>还没有账号？  请静待助理负责人安排</strong>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="loginform">
                    <h4 class="no-margins">登录：</h4>
                    <p class="m-t-md">登录到MOA中山大学多媒体管理系统</p>
                    <input type="text" id="input-username" class="form-control uname" placeholder="用户名" />
                    <input type="password" id="input-password" class="form-control pword m-b" placeholder="密码" />
                    <a href="">忘记密码了？</a>
                    <button id="fetch-btn" class="btn btn-success btn-block">登录</button>
                    <span class="window-tips" b></span>
                </div>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2016 All Rights Reserved. MOA
            </div>
        </div>
    </div>
    
    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/login.js' ?>"></script>
    
</body>

</html>