<<<<<<< HEAD
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-值班报名</title>
    <?php $this->load->view('view_keyword'); ?>

    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

    <script>
        //有n个断点就有n-1段
        var weekday_len = <?php echo count($weekday_breakpoint) - 1 ?>;
        var weekend_len = <?php echo count($weekend_breakpoint) - 1 ?>;
        var day_name = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
    </script>

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
                        	值班安排
                        </li>
                        <li>
                            <strong>排班</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>添加考试周／假期时间表报名</h5>
                            </div>
                            <div class="ibox-content">
                                <form role="form" id="form" class="form-horizontal m-t">

                                    <div class="form-group">
                                        <label class="col-sm-3 col-sm-offset-1 control-label">值班表名称</label>
                                        <div class="col-sm-4">
                                            <input id="name" name="name" class="form-control" type="text"
                                            placeholder="请输入值班表名称">
                                        </div>
                                    </div>


                                    <div class="form-group"  id="calendar_date">
	                                    <label class="col-sm-3 col-sm-offset-1 control-label">起始日期</label>
	                                    <div class="col-sm-4">
		                                    <div class="input-group date col-sm-12"
		                                    style="border-left: 1px solid #E5E6E7; border-right: 1px solid #E5E6E7;">
		                                        <input type="text" id="dateFrom" name="dateFrom" class="form-control input-group-addon"
		                                        placeholder="请选择起始日期">
		                                    </div>
	                                    </div>
	                                </div>

                                    <div class="form-group"  id="calendar_date">
                                        <label class="col-sm-3 col-sm-offset-1 control-label">结束日期</label>
                                        <div class="col-sm-4">
                                            <div class="input-group date col-sm-12"
                                            style="border-left: 1px solid #E5E6E7; border-right: 1px solid #E5E6E7;">
                                                <input type="text" id="dateTo" name="dateTo" class="form-control input-group-addon"
                                                placeholder="请选择结束日期">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 col-sm-offset-1 control-label">值班表说明</label>
                                        <div class="col-sm-4">
                                            <textarea id="comment" name="comment" class="form-control" required="" aria-required="true"></textarea>
                                        </div>
                                    </div>


                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-5">
                                            <div class="btn btn-primary" id="submit_add_schedule">值班表发布</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 9;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>添加日常排班</h5>
                            </div>
                            <div class="ibox-content" style="padding: 30px 65px;">
								<div class="form-group">
									<div class="row" style="margin-bottom: -15px;">
										<div class="col-sm-8">
					                        <table class="table table-bordered">
					                            <thead>
					                                <tr>
					                                    <th scope="col" abbr="per">时段</th>
					                                    <th scope="col" abbr="mon">周一</th>
					                                    <th scope="col" abbr="tue">周二</th>
					                                    <th scope="col" abbr="wed">周三</th>
					                                    <th scope="col" abbr="thu">周四</th>
					                                    <th scope="col" abbr="fri">周五</th>
					                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    for($i = 1; $i <= count($weekday_breakpoint) - 1; ++$i) {
                                                        echo '<tr><th scope="row">' . $weekday_breakpoint[$i - 1] .
                                                            '-' . $weekday_breakpoint[$i] .'</th>';
                                                        for($j = 0; $j < 5; ++$j) {
                                                            echo '<td><select id="select_' . $day_name[$j] . $i .
                                                                '" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">';
                                                            for ($k = 0; $k < count($wid_list); ++$k) {
                                                                 echo '<option value="' . $wid_list[$k] . '" ';
                                                                 if (isset($schedule[$j + 1][$i]) &&
                                                                     in_array($wid_list[$k], $schedule[$j + 1][$i]) !== FALSE) {
                                                                     echo 'selected';
                                                                 }
                                                                 echo ' hassubinfo="true">' . $name_list[$k] . '</option>';

                                                            }
                                                            echo '</select></td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-4">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col" abbr="per">时段</th>
                                                    <th scope="col" abbr="sat">周六</th>
                                                    <th scope="col" abbr="sun">周日</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                for($i = 1; $i <= count($weekend_breakpoint) - 1; ++$i) {
                                                    echo '<tr><th scope="row">' . $weekend_breakpoint[$i - 1] .
                                                        '-' . $weekend_breakpoint[$i] .'</th>';
                                                    for($j = 5; $j < 7; ++$j) {
                                                        echo '<td><select id="select_' . $day_name[$j] . $i .
                                                            '" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">';
                                                        for ($k = 0; $k < count($wid_list); ++$k) {
                                                            echo '<option value="' . $wid_list[$k] . '" ';
                                                            if (isset($schedule[$j + 1][$i]) &&
                                                                in_array($wid_list[$k], $schedule[$j + 1][$i]) !== FALSE) {
                                                                echo 'selected';
                                                            }
                                                            echo ' hassubinfo="true">' . $name_list[$k] . '</option>';

                                                        }
                                                        echo '</select></td>';
                                                    }
                                                    echo '</tr>';
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-5">
                                            <button id="submit_duty" class="btn btn-primary" type="submit"
                                                    data-toggle="modal" data-target="#myModal">发布</button>
                                        </div>
                                    </div>
                                </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 9;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>假期考试周空闲时间表</h5>
                            </div>
                            <div class="ibox-content" style="padding: 30px 65px;">
								<div class="form-group">
									<div class="row" style="margin-bottom: -15px;">
										<div class="col-sm-12">
					                        <table class="table table-bordered">
					                            <thead>
					                                <tr>
					                                    <th scope="col" abbr="per">日期</th>
					                                    <th scope="col" abbr="mon">报名人员</th>
					                                </tr>
					                            </thead>
					                            <tbody>
                                                    <?php
                                                        for($i = 0; $i < count($timeSchedule); $i++) {
                                                            $date = $timeSchedule[$i];
                                                            $options = '';
                                                            for($j = 0; $j < count($wid_list); $j++) {
                                                                if (in_array($wid_list[$j], $workerTimeSchedule[$i]['wid']) !== FALSE)
                                                                    $selected = 'selected';
                                                                else
                                                                    $selected = '';

                                                                $singleOption =  ''.
                                                                            '<option value="'.$wid_list[$j].'" hassubinfo="true" '.$selected.'>'.
                                                                            $name_list[$j].'</option>';
                                                                $options = $options.$singleOption;
                                                            }

                                                            $dom =  ''.
                                                                    '    <tr> '.
                                                                    '        <th scope="row">'.$date.'</th>'.
                                                                    '        <td>'.
                                                                    '           <select id="'.$date.'" data-placeholder="选择助理" class="holiday_schdule chosen-select" multiple tabindex="4">'.
                                                                                $options.
                                                                    '           </select>'.
                                                                    '        </td>'.
                                                                    '    </tr>';
                                                            echo $dom;
                                                        }
                                                    ?>

						                        </tbody>
						                        </table>
									        </div>
								        </div>
								    </div>
						            <div class="hr-line-dashed"></div>
						            <div class="row">
	                                    <div class="form-group">
	                                        <div class="col-sm-4 col-sm-offset-5">
	                                            <button id="submit_holiday_scheduel_duty" type="submit" class="btn btn-primary">发布</button>
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
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/dutyArrange.js' ?>"></script>

    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-scheduleManagement").addClass("active");
			$("#active-dutyArrange").addClass("active");
			$("#mini").attr("href", "dutyArrange#");
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

    <!-- Chosen -->
    <script src="<?=base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

    <!-- Input Mask-->
    <script src="<?=base_url().'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>

    <!-- Data Tables -->
    <script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>
    <!-- Date picker -->
    <script src="<?=base_url().'assets/js/plugins/datepicker/bootstrap-datepicker.js' ?>"></script>
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
            '.chosen-select': {
                // 实现中间字符的模糊查询
            	search_contains: true,
            	no_results_text: "没有找到",
            	width: "80px"
            },
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

    <title>MOA-值班报名</title>
    <?php $this->load->view('view_keyword'); ?>

    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/jasny/jasny-bootstrap.min.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

    <script>
        //有n个断点就有n-1段
        var weekday_len = <?php echo count($weekday_breakpoint) - 1 ?>;
        var weekend_len = <?php echo count($weekend_breakpoint) - 1 ?>;
        var day_name = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
    </script>

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
                        	值班安排
                        </li>
                        <li>
                            <strong>排班</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>添加考试周／假期时间表报名</h5>
                            </div>
                            <div class="ibox-content">
                                <form role="form" id="form" class="form-horizontal m-t">

                                    <div class="form-group">
                                        <label class="col-sm-3 col-sm-offset-1 control-label">值班表名称</label>
                                        <div class="col-sm-4">
                                            <input id="name" name="name" class="form-control" type="text"
                                            placeholder="请输入值班表名称">
                                        </div>
                                    </div>


                                    <div class="form-group"  id="calendar_date">
	                                    <label class="col-sm-3 col-sm-offset-1 control-label">起始日期</label>
	                                    <div class="col-sm-4">
		                                    <div class="input-group date col-sm-12"
		                                    style="border-left: 1px solid #E5E6E7; border-right: 1px solid #E5E6E7;">
		                                        <input type="text" id="dateFrom" name="dateFrom" class="form-control input-group-addon"
		                                        placeholder="请选择起始日期">
		                                    </div>
	                                    </div>
	                                </div>

                                    <div class="form-group"  id="calendar_date">
                                        <label class="col-sm-3 col-sm-offset-1 control-label">结束日期</label>
                                        <div class="col-sm-4">
                                            <div class="input-group date col-sm-12"
                                            style="border-left: 1px solid #E5E6E7; border-right: 1px solid #E5E6E7;">
                                                <input type="text" id="dateTo" name="dateTo" class="form-control input-group-addon"
                                                placeholder="请选择结束日期">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 col-sm-offset-1 control-label">值班表说明</label>
                                        <div class="col-sm-4">
                                            <textarea id="comment" name="comment" class="form-control" required="" aria-required="true"></textarea>
                                        </div>
                                    </div>


                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-5">
                                            <div class="btn btn-primary" id="submit_add_schedule">值班表发布</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 9;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>添加日常排班</h5>
                            </div>
                            <div class="ibox-content" style="padding: 30px 65px;">
								<div class="form-group">
									<div class="row" style="margin-bottom: -15px;">
										<div class="col-sm-8">
					                        <table class="table table-bordered">
					                            <thead>
					                                <tr>
					                                    <th scope="col" abbr="per">时段</th>
					                                    <th scope="col" abbr="mon">周一</th>
					                                    <th scope="col" abbr="tue">周二</th>
					                                    <th scope="col" abbr="wed">周三</th>
					                                    <th scope="col" abbr="thu">周四</th>
					                                    <th scope="col" abbr="fri">周五</th>
					                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    for($i = 1; $i <= count($weekday_breakpoint) - 1; ++$i) {
                                                        echo '<tr><th scope="row">' . $weekday_breakpoint[$i - 1] .
                                                            '-' . $weekday_breakpoint[$i] .'</th>';
                                                        for($j = 0; $j < 5; ++$j) {
                                                            echo '<td><select id="select_' . $day_name[$j] . $i .
                                                                '" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">';
                                                            for ($k = 0; $k < count($wid_list); ++$k) {
                                                                 echo '<option value="' . $wid_list[$k] . '" ';
                                                                 if (isset($schedule[$j + 1][$i]) &&
                                                                     in_array($wid_list[$k], $schedule[$j + 1][$i]) !== FALSE) {
                                                                     echo 'selected';
                                                                 }
                                                                 echo ' hassubinfo="true">' . $name_list[$k] . '</option>';

                                                            }
                                                            echo '</select></td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-4">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col" abbr="per">时段</th>
                                                    <th scope="col" abbr="sat">周六</th>
                                                    <th scope="col" abbr="sun">周日</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                for($i = 1; $i <= count($weekend_breakpoint) - 1; ++$i) {
                                                    echo '<tr><th scope="row">' . $weekend_breakpoint[$i - 1] .
                                                        '-' . $weekend_breakpoint[$i] .'</th>';
                                                    for($j = 5; $j < 7; ++$j) {
                                                        echo '<td><select id="select_' . $day_name[$j] . $i .
                                                            '" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">';
                                                        for ($k = 0; $k < count($wid_list); ++$k) {
                                                            echo '<option value="' . $wid_list[$k] . '" ';
                                                            if (isset($schedule[$j + 1][$i]) &&
                                                                in_array($wid_list[$k], $schedule[$j + 1][$i]) !== FALSE) {
                                                                echo 'selected';
                                                            }
                                                            echo ' hassubinfo="true">' . $name_list[$k] . '</option>';

                                                        }
                                                        echo '</select></td>';
                                                    }
                                                    echo '</tr>';
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-5">
                                            <button id="submit_duty" class="btn btn-primary" type="submit"
                                                    data-toggle="modal" data-target="#myModal">发布</button>
                                        </div>
                                    </div>
                                </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 9;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>假期考试周空闲时间表</h5>
                            </div>
                            <div class="ibox-content" style="padding: 30px 65px;">
								<div class="form-group">
									<div class="row" style="margin-bottom: -15px;">
										<div class="col-sm-12">
					                        <table class="table table-bordered">
					                            <thead>
					                                <tr>
					                                    <th scope="col" abbr="per">日期</th>
					                                    <th scope="col" abbr="mon">报名人员</th>
					                                </tr>
					                            </thead>
					                            <tbody>
                                                    <?php
                                                        for($i = 0; $i < count($timeSchedule); $i++) {
                                                            $date = $timeSchedule[$i];
                                                            $options = '';
                                                            for($j = 0; $j < count($wid_list); $j++) {
                                                                if (in_array($wid_list[$j], $workerTimeSchedule[$i]['wid']) !== FALSE)
                                                                    $selected = 'selected';
                                                                else
                                                                    $selected = '';

                                                                $singleOption =  ''.
                                                                            '<option value="'.$wid_list[$j].'" hassubinfo="true" '.$selected.'>'.
                                                                            $name_list[$j].'</option>';
                                                                $options = $options.$singleOption;
                                                            }

                                                            $dom =  ''.
                                                                    '    <tr> '.
                                                                    '        <th scope="row">'.$date.'</th>'.
                                                                    '        <td>'.
                                                                    '           <select id="'.$date.'" data-placeholder="选择助理" class="holiday_schdule chosen-select" multiple tabindex="4">'.
                                                                                $options.
                                                                    '           </select>'.
                                                                    '        </td>'.
                                                                    '    </tr>';
                                                            echo $dom;
                                                        }
                                                    ?>

						                        </tbody>
						                        </table>
									        </div>
								        </div>
								    </div>
						            <div class="hr-line-dashed"></div>
						            <div class="row">
	                                    <div class="form-group">
	                                        <div class="col-sm-4 col-sm-offset-5">
	                                            <button id="submit_holiday_scheduel_duty" type="submit" class="btn btn-primary">发布</button>
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
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/dutyArrange.js' ?>"></script>

    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-scheduleManagement").addClass("active");
			$("#active-dutyArrange").addClass("active");
			$("#mini").attr("href", "dutyArrange#");
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

    <!-- Chosen -->
    <script src="<?=base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

    <!-- Input Mask-->
    <script src="<?=base_url().'assets/js/plugins/jasny/jasny-bootstrap.min.js' ?>"></script>

    <!-- Data Tables -->
    <script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>
    <!-- Date picker -->
    <script src="<?=base_url().'assets/js/plugins/datepicker/bootstrap-datepicker.js' ?>"></script>
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
            '.chosen-select': {
                // 实现中间字符的模糊查询
            	search_contains: true,
            	no_results_text: "没有找到",
            	width: "80px"
            },
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
