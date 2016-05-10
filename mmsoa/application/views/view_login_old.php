<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-登录</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">MOA</h1>

            </div>
            <h3>欢迎使用 MOA</h3>

            <!-- <form class="m-t" role="form" method="post" action="<?=base_url().'index.php/login/loginValidation' ?>">  -->
                <div class="form-group">
                    <input type="text" id="input-username" class="form-control" name="username" placeholder="用户名" required="">
                </div>
                <div class="form-group">
                    <input type="password" id="input-password" class="form-control" name="password" placeholder="密码" required="">
                </div>
                <button type="submit" id="fetch-btn" class="btn btn-primary block full-width m-b">登 录</button>


                <!--<p class="text-muted text-center"> -->
                	<span class="window-tips" b></span>
                <!--</p>-->

            <!-- </form>  -->
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/login.js' ?>"></script>

</body>

</html>
