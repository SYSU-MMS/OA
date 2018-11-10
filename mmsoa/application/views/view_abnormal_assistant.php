<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-管理异常助理</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/datetimepicker/bootstrap-datetimepicker.css' ?>" rel="stylesheet">
    
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
                            坐班日志
                        </li>
                        <li>
                            <strong>异常助理</strong>
                        </li>   
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12 col-md-10">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>管理异常助理</h5>
                            </div>
                            <div class="ibox-content">
                            
                                <div class="row">
                                    <div class="form-group col-md-4 col-lg-3" id="dtp_group">
                                        <label class="font-noraml">选择时间段</label>
                                        <div class="input-daterange input-group" id="dtp">
                                            <input type="text" id="start_dtp" class="input-sm form-control dtp-input-div" name="start" placeholder="开始时间" value="<?php echo date('Y-m-d',strtotime("-7 day")); ?>" />
                                            <span class="input-group-addon dtp-addon">到</span>
                                            <input type="text" id="end_dtp" class="input-sm form-control dtp-input-div" name="end" placeholder="结束时间" value="<?php echo date('Y-m-d',time()); ?>" />
                                        </div>
                                    </div>
                                    <div id="chosen_name" class="form-group col-md-2" style="height: 30px; position: relative; z-index: 999999;">
                                        <label class="font-noraml">助理</label>
                                        <div>
                                            <select id="select_name" name="select_name" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4">
                                                <option value="-1">全部</option>
                                                <?php 
                                                    for ($i = 0; $i < count($name_list); $i++) {
                                                        echo "<option value='" . $wid_list[$i] . "'>" . $name_list[$i] . "</option>";
                                                    } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="chosen_dealing" class="form-group col-md-2" style="height: 30px; position: relative; z-index: 999999;">
                                        <label class="font-noraml">处理方式</label>
                                        <div>
                                            <select id="select_dealing" name="select_dealing" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4">
                                                <option value="-1">全部</option>
                                                <option value="0">警告</option>
                                                <option value="1">扣工时</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="chosen_dealer" class="form-group col-md-2" style="height: 30px; position: relative; z-index: 999999;">
                                        <label class="font-noraml">处理人</label>
                                        <div>
                                            <select id="select_dealer" name="select_dealer" data-placeholder="" class="chosen-select-name col-sm-12" tabindex="4">
                                                <option value="-1">全部</option>
                                                <?php 
                                                for ($i = 0; $i < count($operator_name_list); $i++) {
                                                    echo "<option value='" . $operator_wid_list[$i] . "'>" . $operator_name_list[$i] . "</option>";
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="search_container" class="form-group col-md-1 col-lg-1">
                                        <label class="font-noraml search-btn"></label>
                                        <div>
                                            <button id="search_btn" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div  id="add_container" class="col-md-1" data-toggle="modal" data-target="#modal-new-table">
                                        <label class="font-noraml search-btn"></label>
                                        <div>
                                            <button id="add_btn" class="btn btn-primary ">新增记录</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="table_container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('view_footer'); ?>
        </div>
    </div>
    <div id="modal-new-table" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class='modal-title' id="modal_header" style='text-align: center'>新建异常助理</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="form" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">时间</label>
                            <div class="col-sm-3">
                                <input type="text" id="start_w_dtp" class="input-sm form-control dtp-input-div" name="time" placeholder="时间" value="<?php echo date('Y-m-d',time()); ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">助理</label>
                            <div class="col-sm-10">
                                <select id="reg_assistant" class="form-control" name="wid">
                                    <option value="-1">选择助理</option>
                                    <?php 
                                    for ($i = 0; $i < count($name_list); $i++) {
                                        echo "<option value='" . $wid_list[$i] . "'>" . $name_list[$i] . "</option>";
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">问题</label>
                            <div class="col-sm-10">
                                <textarea style="height: 100px; !important;" id="reg_pro" class="input-sm form-control" name="problem" placeholder="问题"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">处理方式</label>
                            <div class="col-sm-10">
                                <select id="reg_dealing" class="form-control" name="dealing">
                                    <option value="-1">选择处理方式</option>
                                    <option value="0">警告</option>
                                    <option value="1">扣工时</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">处理人</label>
                            <div class="col-sm-10">
                                <select id="reg_dealer" class="form-control" name="wid">
                                    <option value="-1">选择处理人</option>
                                    <?php 
                                    for ($i = 0; $i < count($operator_name_list); $i++) {
                                        echo "<option value='" . $operator_wid_list[$i] . "'>" . $operator_name_list[$i] . "</option>";
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-10">
                                <textarea style="height: 100px; !important;" id="reg_note" class="input-sm form-control" name="comment" placeholder="备注"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-5">
                                <a class="btn btn-primary" id="add">添加</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-new-table-check" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class='modal-title' id="modal_header_check" style='text-align: center'></h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="form_check" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">时间</label>
                            <div class="col-sm-3">
                                <input type="text" id="start_w_dtp_check" class="input-sm form-control dtp-input-div" name="time" placeholder="时间"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">助理</label>
                            <div class="col-sm-10">
                                <select id="reg_assistant_check" class="form-control" name="wid">
                                    <option value="-1">选择助理</option>
                                    <?php 
                                    for ($i = 0; $i < count($name_list); $i++) {
                                        echo "<option value='" . $wid_list[$i] . "'>" . $name_list[$i] . "</option>";
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">问题</label>
                            <div class="col-sm-10">
                                <textarea style="height: 100px; !important;" id="reg_pro_check" class="input-sm form-control" name="problem" placeholder="问题"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">处理方式</label>
                            <div class="col-sm-10">
                                <select id="reg_dealing_check" class="form-control" name="dealing">
                                    <option value="-1">选择处理方式</option>
                                    <option value="0">警告</option>
                                    <option value="1">扣工时</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">处理人</label>
                            <div class="col-sm-10">
                                <select id="reg_dealer_check" class="form-control" name="wid">
                                    <option value="-1">选择处理人</option>
                                    <?php 
                                    for ($i = 0; $i < count($operator_name_list); $i++) {
                                        echo "<option value='" . $operator_wid_list[$i] . "'>" . $operator_name_list[$i] . "</option>";
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-10">
                                <textarea style="height: 100px; !important;" id="reg_note_check" class="input-sm form-control" name="comment" placeholder="备注"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-5">
                                <a  class="btn btn-primary" id="update_check"></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/abnormal.js' ?>"></script>
    
   <!-- nav item active -->
    <script>
        $(document).ready(function () {
            $("#active-journal").addClass("active");
            $("#active-abnormal").addClass("active");
            $("#mini").attr("href", "manageAbnormal#");
        });
    </script>
    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>
    
    <!-- Chosen -->
    <script src="<?=base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

    <!-- Date time picker -->
    <script src="<?=base_url().'assets/js/plugins/datetimepicker/bootstrap-datetimepicker.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js' ?>"></script>
    
    <!-- Data Tables -->
    <script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>
    
    <script>
        $(document).ready(function () {

            // dataTable
            $('.users-dataTable').dataTable({
                "aaSorting": [[0, "desc"]],
                "iDisplayLength": 25
            });
            /* Calendar */
            $('#start_dtp').datetimepicker({
                format: 'yyyy-mm-dd',
                language: 'zh-CN',
                weekStart: 1,
                todayBtn:  1,
                autoclose: true,
                todayHighlight: true,
                startView: 'month',
                minView: 'month',
                forceParse: 1
            });
            $('#end_dtp').datetimepicker({
                format: 'yyyy-mm-dd',
                language: 'zh-CN',
                weekStart: 1,
                todayBtn:  1,
                autoclose: true,
                todayHighlight: true,
                startView: 'month',
                minView: 'month',
                forceParse: 1
            });
            $('#start_w_dtp').datetimepicker({
                format: 'yyyy-mm-dd',
                language: 'zh-CN',
                weekStart: 1,
                todayBtn:  1,
                autoclose: true,
                todayHighlight: true,
                startView: 'month',
                minView: 'month',
                forceParse: 1
            });
            $('#start_w_dtp_check').datetimepicker({
                format: 'yyyy-mm-dd',
                language: 'zh-CN',
                weekStart: 1,
                todayBtn:  1,
                autoclose: true,
                todayHighlight: true,
                startView: 'month',
                minView: 'month',
                forceParse: 1
            });
        });

        /* Chosen name */
        var config = {
                '.chosen-select-classroom': {
                    // 实现中间字符的模糊查询
                    search_contains: true,
                    no_results_text: "没有找到",
                    disable_search_threshold: 10
                },
                '.chosen-select-classroom-deselect': {
                    allow_single_deselect: true
                },
                '.chosen-select-classroomt-no-single': {
                    disable_search_threshold: 10
                },
                '.chosen-select-classroom-no-results': {
                    no_results_text: 'Oops, nothing found!'
                },
                '.chosen-select-classroom-width': {
                    width: "95%"
                }
            }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

        /* Chosen classroom */
        var config = {
                '.chosen-select-name': {
                    // 实现中间字符的模糊查询
                    search_contains: true,
                    no_results_text: "没有找到",
                    disable_search_threshold: 10
                },
                '.chosen-select-classroom-name': {
                    allow_single_deselect: true
                },
                '.chosen-select-name-no-single': {
                    disable_search_threshold: 10
                },
                '.chosen-select-name-no-results': {
                    no_results_text: 'Oops, nothing found!'
                },
                '.chosen-select-name-width': {
                    width: "95%"
                }
            }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        
    </script>

</body>

</html>
