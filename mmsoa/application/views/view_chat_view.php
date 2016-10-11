<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>聊天窗口</title>
    <meta name="keywords" content="moa私信页面">
    <meta name="description" content="私信页面">

    <link href="<?=base_url().'assets/css/plugins/jsTree/style.min.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>rel="stylesheet">

    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/datepicker/datepicker3.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <?php $this->load->view('view_nav'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php $this->load->view('view_header'); ?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>聊天窗口</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">首页</a>
                        </li>

                        <li>
                            <strong>聊天窗口</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content  animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox chat-view">
                            <div class="ibox-title">
                                <small class="pull-right text-muted"></small> 聊天窗口
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-9 ">
                                        <div class="chat-discussion">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="chat-users">
                                            <div class="users-list">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="chat-message-form">
                                            <div class="form-group">
                                                <textarea class="form-control message-input" name="message" placeholder="输入消息内容，按回车键发送"></textarea>
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
    <script src="<?=base_url().'assets/js/socket.io-client/socket.io.js' ?>"></script>
    <script src="<?=base_url().'assets/js/chat_view.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
</body>

</html>
