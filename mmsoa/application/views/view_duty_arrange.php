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
					                                    <td>
					                                    	<select id="select_MON1" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
					                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																	<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[1][1]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																<?php } ?>
				                                        	</select>
					                                    </td>
					                                    <td>
					                                    	<select id="select_TUE1" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
					                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																	<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[2][1]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																<?php } ?>
				                                        	</select>
					                                    </td>
					                                    <td>
					                                    	<select id="select_WED1" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
					                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																	<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[3][1]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																<?php } ?>
				                                        	</select>
					                                    </td>
					                                    <td>
					                                    	<select id="select_THU1" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
					                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																	<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[4][1]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																<?php } ?>
				                                        	</select>
					                                    </td>
					                                    <td>
					                                    	<select id="select_FRI1" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
					                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																	<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[5][1]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																<?php } ?>
				                                        	</select>
					                                    </td>
					                                    <td rowspan="2">
					                                    	<select id="select_SAT1" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
					                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																	<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[6][7]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																<?php } ?>
				                                        	</select>
					                                    </td>
					                                    <td rowspan="2">
					                                    	<select id="select_SUN1" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
					                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																	<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[7][7]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																<?php } ?>
				                                        	</select>
						                                    </td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">10:30-12:30</th>
						                                    <td>
						                                    	<select id="select_MON2" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[1][2]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_TUE2" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[2][2]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_WED2" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[3][2]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_THU2" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[4][2]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_FRI2" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[5][2]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">12:30-14:00</th>
						                                    <td>
						                                    	<select id="select_MON3" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[1][3]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_TUE3" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[2][3]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_WED3" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[3][3]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_THU3" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[4][3]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_FRI3" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[5][3]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td rowspan="3">
						                                    	<select id="select_SAT2" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[6][8]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td rowspan="3">
						                                    	<select id="select_SUN2" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[7][8]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">14:00-16:00</th>
						                                    <td>
						                                    	<select id="select_MON4" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[1][4]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_TUE4" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[2][4]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_WED4" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[3][4]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_THU4" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[4][4]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_FRI4" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[5][4]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">16:00-18:00</th>
						                                    <td>
						                                    	<select id="select_MON5" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[1][5]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_TUE5" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[2][5]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_WED5" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[3][5]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_THU5" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[4][5]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_FRI5" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[5][5]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                </tr>
						                                <tr>
						                                    <th scope="row">18:00-22:00</th>
						                                    <td>
						                                    	<select id="select_MON6" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[1][6]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_TUE6" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[2][6]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_WED6" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[3][6]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_THU6" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[4][6]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_FRI6" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[5][6]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_SAT3" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[6][9]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                    <td>
						                                    	<select id="select_SUN3" data-placeholder="选择助理" class="chosen-select" multiple tabindex="4">
						                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
																		<option value="<?php echo $wid_list[$i]; ?>" <?php if (in_array($wid_list[$i], $schedule[7][9]) !== FALSE) { echo 'selected'; } ?> hassubinfo="true"><?php echo $name_list[$i]; ?></option>
																	<?php } ?>
					                                        	</select>
						                                    </td>
						                                </tr>
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
