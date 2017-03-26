<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-值班表</title>
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
                            <strong>值班表</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 999999;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>值班表</h5>
                            </div>
                            <div class="ibox-content" style="padding: 30px 65px;">
								<div class="form-group">
									<div class="row" style="margin-bottom: -15px;">
										<div class="col-sm-12">
					                        <table class="table table-bordered">
					                            <thead>
					                                <tr>
					                                    <th scope="col" abbr="per">时段</th>
					                                    <th scope="col" abbr="mon">周一</th>
					                                    <th scope="col" abbr="tue">周二</th>
					                                    <th scope="col" abbr="wed">周三</th>
					                                    <th scope="col" abbr="thu">周四</th>
					                                    <th scope="col" abbr="fri">周五</th>
					                                    <th scope="col" abbr="sat">周六</th>
					                                    <th scope="col" abbr="sun">周日</th>
					                                </tr>
					                            </thead>
					                            <tbody>
					                                <tr>
					                                    <th scope="row">07:30-10:30</th>
					                                    <td><?php echo $schedule[1][1]; ?></td>
					                                    <td><?php echo $schedule[2][1]; ?></td>
					                                    <td><?php echo $schedule[3][1]; ?></td>
					                                    <td><?php echo $schedule[4][1]; ?></td>
					                                    <td><?php echo $schedule[5][1]; ?></td>
					                                    <td rowspan="2"><?php echo $schedule[6][7]; ?></td>
					                                    <td rowspan="2"><?php echo $schedule[7][7]; ?></td>
					                                </tr>
					                                <tr>
					                                    <th scope="row">10:30-12:30</th>
					                                    <td><?php echo $schedule[1][2]; ?></td>
					                                    <td><?php echo $schedule[2][2]; ?></td>
					                                    <td><?php echo $schedule[3][2]; ?></td>
					                                    <td><?php echo $schedule[4][2]; ?></td>
					                                    <td><?php echo $schedule[5][2]; ?></td>
					                                </tr>
					                                <tr>
					                                    <th scope="row">12:30-14:00</th>
					                                    <td><?php echo $schedule[1][3]; ?></td>
					                                    <td><?php echo $schedule[2][3]; ?></td>
					                                    <td><?php echo $schedule[3][3]; ?></td>
					                                    <td><?php echo $schedule[4][3]; ?></td>
					                                    <td><?php echo $schedule[5][3]; ?></td>
					                                    <td rowspan="3"><?php echo $schedule[6][8]; ?></td>
					                                    <td rowspan="3"><?php echo $schedule[7][8]; ?></td>
					                                </tr>
					                                <tr>
					                                    <th scope="row">14:00-16:00</th>
					                                    <td><?php echo $schedule[1][4]; ?></td>
					                                    <td><?php echo $schedule[2][4]; ?></td>
					                                    <td><?php echo $schedule[3][4]; ?></td>
					                                    <td><?php echo $schedule[4][4]; ?></td>
					                                    <td><?php echo $schedule[5][4]; ?></td>
					                                </tr>
					                                <tr>
					                                    <th scope="row">16:00-18:00</th>
					                                    <td><?php echo $schedule[1][5]; ?></td>
					                                    <td><?php echo $schedule[2][5]; ?></td>
					                                    <td><?php echo $schedule[3][5]; ?></td>
					                                    <td><?php echo $schedule[4][5]; ?></td>
					                                    <td><?php echo $schedule[5][5]; ?></td>
					                                </tr>
					                                <tr>
					                                    <th scope="row">18:00-22:00</th>
					                                    <td><?php echo $schedule[1][6]; ?></td>
					                                    <td><?php echo $schedule[2][6]; ?></td>
					                                    <td><?php echo $schedule[3][6]; ?></td>
					                                    <td><?php echo $schedule[4][6]; ?></td>
					                                    <td><?php echo $schedule[5][6]; ?></td>
					                                    <td><?php echo $schedule[6][9]; ?></td>
					                                    <td><?php echo $schedule[7][9]; ?></td>
					                                </tr>
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

            <div class="wrapper wrapper-content animated fadeInRight" style="position: relative; z-index: 999999;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>考试周/假期时间总表</h5>
                            </div>
                            <div class="ibox-content" style="padding: 30px 65px;">
								<div class="form-group">
									<div class="row" style="margin-bottom: -15px;">
										<div class="col-sm-12">
					                        <table class="table table-bordered">
					                            <thead>
					                                <tr>
					                                    <th scope="col" abbr="per">日期</th>
					                                    <th scope="col" abbr="mon">人员安排</th>
					                                </tr>
					                            </thead>
					                            <tbody>
                                                    <?php
                                                        for($i = 0; $i < count($timeSchedule); $i++) {
                                                            $date = $timeSchedule[$i];
                                                            $td  = '';
                                                            for($j = 0; $j < count($workerTimeSchedule[$i]['name']); $j++) {
                                                                if($workerTimeSchedule[$i]['isPermitted'][$j]) {
                                                                    $name = $workerTimeSchedule[$i]['name'][$j];
                                                                    $td  = $td.$name.'<br/>';
                                                                }
                                                            }
                                                            if($td == '') {
                                                                $td = '暂无排班';
                                                            }
                                                            $dom =  ''.
                                                                    '    <tr> '.
                                                                    '        <th scope="row">'.$date.'</th>'.
                                                                    '        <td>'.
                                                                    '            <br/>'.
                                                                                 $td.
                                                                    '            <br/>'.
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
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>

            <?php $this->load->view('view_footer'); ?>
	    </div>
	</div>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/duty-arrange.js' ?>"></script>

    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-scheduleManagement").addClass("active");
			$("#active-dutySchedule").addClass("active");
			$("#mini").attr("href", "dutySchedule#");
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

</body>

</html>
