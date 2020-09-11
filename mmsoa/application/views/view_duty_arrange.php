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

            <div class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 11;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>助理报名详情</h5>
                            </div>
                            <div class="ibox-content" style="padding: 30px 65px;">
                        
								<div class="form-group">
                                    <div class="row" style="margin-bottom:15px; display: flex; align-items: center">
                                        <div class="col-sm-2">
                                            <select id="select_worker" name="select_worker" data-placeholder="请选择报名的助理" class="chosen-select" tabindex="4"">
                                                <option value="">请选择报名的助理</option>
                                                <?php for ($i = 0; $i < count($signup_names); $i++) {?>
                                        			<option value="<?php echo $i; ?>"><?php echo $signup_names[$i]." (".$groups[$i].")" ?></option>
                                        		<?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 pull-right">
                                            <span style="font-size: 15px;  font-weight: bold;">报名时段总时长: </span>
                                            <span id="totaltime" style="color: #1ab394; font-size: 16px; font-weight: bold;"></span>
                                        </div>
                                        
                                    </div>
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
                                                            echo '<td class="detail_td" id="detail_' . $day_name[$j] . $i . '">';
                                                            echo '</td>';
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
                                                        echo '<td class="detail_td" id="detail_' . $day_name[$j] . $i . '">';
                                                        echo '</td>';
                                                    }
                                                    echo '</tr>';
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>

            <div id="auto-div" class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 10;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>添加日常排班</h5>
                                <?php
                                	// 助理负责人，超级管理员才可以导出报名情况
						        	if ($_SESSION['level'] == 3 || $_SESSION['level'] == 6) {
						        		echo '<div class="ibox-tools">'.
                                            '<button id="autoplan" type="button" class="btn btn-primary btn-xs manager" data-toggle="modal">自动排班'.
                                            '</button>'.
                                        '</div>';
						        	}
						        ?>
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
                                                                '" data-placeholder="选择助理" class="chosen-select auto-select" multiple tabindex="4">';
                                                            for ($k = 0; $k < count($wids); ++$k) {
                                                                if(in_array($day_name[$j] . $i, $periods[$k]) || (isset($schedule[$j + 1][$i]) && in_array($wids[$k], $schedule[$j + 1][$i]))){

                                                                    echo '<option value="' . $wids[$k] . '" ';
                                                                    if (isset($schedule[$j + 1][$i]) &&
                                                                    in_array($wids[$k], $schedule[$j + 1][$i]) !== FALSE) {
                                                                        echo 'selected';
                                                                    }
                                                                    echo ' hassubinfo="true">' . $signup_names[$k]." (".$groups[$k].")" . '</option>';
                                                                }

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
                                                            '" data-placeholder="选择助理" class="chosen-select auto-select" multiple tabindex="4">';
                                                        for ($k = 0; $k < count($wids); ++$k) {
                                                            if(in_array($day_name[$j] . $i, $periods[$k]) || (isset($schedule[$j + 1][$i]) && in_array($wids[$k], $schedule[$j + 1][$i]))){

                                                                echo '<option value="' . $wids[$k] . '" ';
                                                                if (isset($schedule[$j + 1][$i]) &&
                                                                in_array($wids[$k], $schedule[$j + 1][$i]) !== FALSE) {
                                                                    echo 'selected';
                                                                }
                                                                echo ' hassubinfo="true">' . $signup_names[$k]." (".$groups[$k].")" . '</option>';
                                                            }
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

    $("#select_worker").change(function() {
        var checkedVal = $("#select_worker").val();
        var jperiods = eval(<?php echo json_encode($periods);?>);
        var jtotal_times = eval(<?php echo json_encode($total_times);?>);
        
        $("#totaltime").html(jtotal_times[checkedVal]+"h");
        $(".detail_td").html("");
        for(var jperiod in jperiods[checkedVal]){
            $("#detail_"+jperiods[checkedVal][jperiod]).html("已选");
            // alert("#detail_"+jperiod);
        }
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

        var jgroups = eval(<?php echo json_encode($groups);?>);
        var jwids = eval(<?php echo json_encode($wids);?>);
        var jperiods = eval(<?php echo json_encode($periods);?>);
        var jweekday_breakpoint = eval(<?php echo json_encode($weekday_breakpoint);?>);
        var jweekend_breakpoint = eval(<?php echo json_encode($weekend_breakpoint);?>);
        var jweekday_last = eval(<?php echo json_encode($weekday_last);?>);
        var jweekend_last = eval(<?php echo json_encode($weekend_last);?>);
        var jnames = eval(<?php echo json_encode($signup_names);?>);
        var hours;
        var time_limit = {'A': 2.5, 'B': 4.5, 'C': 10, 'AB': 2.5};
        function insert_func(i, day, period, last) {
            if($('#select_'+day+(period+1)).val() != null){
                if(day != 'SAT' && day != 'SUN' && period == 5){
                    if($('#select_'+day+(period+1)).val().length >= 3){
                        return;
                    }
                }else{
                    if($('#select_'+day+(period+1)).val().length >= 2){
                        return;
                    }
                }
            }
            if(hours[i] == undefined && last[period] <= time_limit[group]){
                hours[i] = last[period];
                if($('#select_'+day+(period+1)).val() == null){
                    $('#select_'+day+(period+1)).val(jwids[i]);
                }else{
                    $('#select_'+day+(period+1)).val($('#select_'+day+(period+1)).val().concat([jwids[i]]));
                }
            }else if(hours[i] + last[period] <= time_limit[group]){
                hours[i] += last[period];
                if($('#select_'+day+(period+1)).val() == null){
                    $('#select_'+day+(period+1)).val(jwids[i]);
                }else{
                    $('#select_'+day+(period+1)).val($('#select_'+day+(period+1)).val().concat([jwids[i]]));
                }
            }
        }
        function insert_worker(i, day, period){
            group = jgroups[i];
            if(day == 'SAT' || day == 'SUN'){
                insert_func(i, day, period, jweekend_last);
            }else if(day == 'TUE' || day == 'THU'){
                if(group != 'B' || (period >= 2 && period <= 4)){
                    insert_func(i, day, period, jweekday_last);
                }
            }else{
                if(group != 'A' || (period >= 2 && period <= 4)){
                    insert_func(i, day, period, jweekday_last);
                }
            }
        }
        function day_priority(day) {
            if(day == 'SAT' || day == 'SUN')
                return 1;
            return 0;
        }
        function period_priority(period){
            if(period == 0)
                return 0;
            else if(period == 5)
                return 1;
            else if(period == 2)
                return 3;
            return 2;
        }
        $('#autoplan').click(function() {
            $(".auto-select").val("");
            
            hours = new Array();
            var shuffle = new Array();
            for(var i in jgroups){
                shuffle[i] = i;
            }
            shuffle.sort(function () { 
                return (0.5-Math.random());
            });
            var group_priority = {"A": 0, "B": 1, "C": 2, "AB": 3};
            shuffle.sort(function (a, b) {
                return group_priority[jgroups[a]] - group_priority[jgroups[b]];
            });
            for(var k in jgroups){
                var i = shuffle[k];
                var pshuffle = new Array();
                for(var m in jperiods[i]){
                    pshuffle[m] = m;
                }
                pshuffle.sort(function () { 
                    return (0.5-Math.random());
                });
                pshuffle.sort(function (a, b) {
                    var aday = jperiods[i][a].substr(0, 3);
                    var aperiod = Number(jperiods[i][a].substr(3))-1;
                    var bday = jperiods[i][b].substr(0, 3);
                    var bperiod = Number(jperiods[i][b].substr(3))-1;

                    if(day_priority(aday) == day_priority(bday)){
                        return period_priority(aperiod) - period_priority(bperiod);
                    }
                    return day_priority(aday) - day_priority(bday);
                });
                for(var v in jperiods[i]){
                    var j = pshuffle[v];
                    var day = jperiods[i][j].substr(0, 3);
                    var period = Number(jperiods[i][j].substr(3))-1;
                    insert_worker(i, day, period);
                }
            }
            $(".auto-select").trigger("chosen:updated");
        });

    </script>

</body>

</html>
