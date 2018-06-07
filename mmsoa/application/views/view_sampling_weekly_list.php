<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>MOA-抽查记录</title>
    <?php $this->load->view('view_keyword');?>

    <link href="<?=base_url() . 'assets/images/moa.ico'?>" rel="shortcut icon">

    <link href="<?=base_url() . 'assets/css/bootstrap.min.css?v=3.4.0'?>" rel="stylesheet">
    <link href="<?=base_url() . 'assets/font-awesome/css/font-awesome.min.css'?>" rel="stylesheet">

    <link href="<?=base_url() . 'assets/css/animate.css'?>" rel="stylesheet">
    <link href="<?=base_url() . 'assets/css/style.css?v=2.2.0'?>" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?=base_url() . 'assets/css/plugins/dataTables/dataTables.bootstrap.css'?>" rel="stylesheet">

</head>
<style>
    <?php
$is_manager = ($_SESSION['level'] == 1 || $_SESSION['level'] == 6);
if (!$is_manager) {
	echo '.manager { display: none !important; }';
	echo "@media (min-width: 768px) { .manager { display: none !important; } }";
} else {
	echo '.viewer { display: none !important; }';
}
?>
</style>

<body onload="startTime()">
<div id="wrapper">
    <?php $this->load->view('view_nav');?>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php $this->load->view('view_header');?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2 id="time"></h2>
                <ol class="breadcrumb">
                    <li>
                        MOA
                    </li>
                    <li>
                        周检抽查记录
                    </li>
                    <?php
if ($is_manager) {
	echo "<li><strong>管理</strong></li>";
}

?>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>所有周检抽查记录表</h5>
                            <div class="ibox-tools">
                                <a class="btn btn-primary btn-xs manager" onclick="new_last_week_weekly()">新建上周周检抽查记录表</a>
                                <a class="btn btn-primary btn-xs manager" onclick="new_this_week_weekly()">新建本周周检抽查记录表</a>
                                <a class="btn btn-primary btn-xs manager" onclick="new_n_week_weekly()">新建第n周周检抽查记录表</a>
                                <a class="btn btn-primary btn-xs manager" ">n = <select id="n_week" style="color: black;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                    </select></a>
                            </div>
                        </div>
                        <div id="table-contianer" class="ibox-content" style="padding-bottom: 20px;">
                           <table class="table table-striped table-bordered table-hover users-dataTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>创建时间</th>
                                    <th>周检抽查记录标题</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody id="sample-list">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('view_footer');?>
    </div>
</div>

<!-- Mainly scripts -->
<script src="<?=base_url() . 'assets/js/jquery-2.1.1.min.js'?>"></script>
<script src="<?=base_url() . 'assets/js/bootstrap.min.js?v=3.4.0'?>"></script>
<script src="<?=base_url() . 'assets/js/plugins/metisMenu/jquery.metisMenu.js'?>"></script>
<script src="<?=base_url() . 'assets/js/plugins/slimscroll/jquery.slimscroll.min.js'?>"></script>
<script src="<?=base_url() . 'assets/js/sample_weekly_list.js'?>"></script>

<!-- nav item active -->
<script>
    $(document).ready(function () {
        $("#active-sampling-weekly").addClass("active");
        $("#active-getTableList-weekly").addClass("active");
        $("#mini").attr("href", "SamplingWeekly#");
    });
</script>

<!-- Custom and plugin javascript -->
<script src="<?=base_url() . 'assets/js/hplus.js?v=2.2.0'?>"></script>
<script src="<?=base_url() . 'assets/js/plugins/pace/pace.min.js'?>"></script>

<!-- Dynamic date -->
<script src="<?=base_url() . 'assets/js/dynamicDate.js'?>"></script>

<!-- Chosen -->
<script src="<?=base_url() . 'assets/js/plugins/chosen/chosen.jquery.js'?>"></script>

<!-- Data Tables -->
<script src="<?=base_url() . 'assets/js/plugins/dataTables/jquery.dataTables.js'?>"></script>
<script src="<?=base_url() . 'assets/js/plugins/dataTables/dataTables.bootstrap.js'?>"></script>


<script>
    $(document).ready(function () {
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
