<<<<<<< HEAD
<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="renderer" content="webkit">

	<title>MOA-通知</title>
	<?php $this->load->view('view_keyword'); ?>

	<link href="<?= base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

	<link href="<?= base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
	<link href="<?= base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

	<link href="<?= base_url().'assets/css/animate.css' ?>" rel="stylesheet">
	<link href="<?= base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

	<!-- Data Tables -->
	<link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">

</head>
<style>
	<?php
        $is_manager = ($_SESSION['level'] == 3 || $_SESSION['level'] == 5 || $_SESSION['level'] == 6);
        if (!$is_manager) {
            echo '.manager { display: none; }';
        }
    ?>
</style>

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
						通知
					</li>
					<?php
					if ($is_manager) echo "<li><strong>管理</strong></li>";
					?>
				</ol>
			</div>
		</div>
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>所有通知</h5>
							<div class="ibox-tools">
								<a href="<?php echo site_url('Notify/writeNotice'); ?>"
								   class="btn btn-primary btn-xs manager">发布新通知</a>
							</div>
						</div>
						<div class="ibox-content" style="padding-bottom: 20px;">
							<table class="table table-striped table-bordered table-hover users-dataTable">
								<thead>
								<tr>
									<th>序号</th>
									<th>通知</th>
									<th>发布人</th>
									<th>发布日期</th>
									<th>操作</th>
								</tr>
								</thead>
								<tbody id="notice-list">
								<tr>
									<td>0</td>
									<td>无</td>
									<td>无</td>
									<td>0</td>
									<td>无</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('view_footer'); ?>
	</div>
</div>

<!-- Mainly scripts -->
<script src="<?= base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
<script src="<?= base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
<script src="<?= base_url().'assets/js/onduty_in.js' ?>"></script>
<script src="<?= base_url().'assets/js/notice.js' ?>"></script>

<!-- nav item active -->
<script>
	$(document).ready(function () {
		$("#mini").attr("href", "Notify#");
	});
</script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>

<!-- Dynamic date -->
<script src="<?= base_url().'assets/js/dynamicDate.js' ?>"></script>

<!-- Chosen -->
<script src="<?= base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

<!-- Data Tables -->
<script src="<?= base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>


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
=======
<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="renderer" content="webkit">

	<title>MOA-通知</title>
	<?php $this->load->view('view_keyword'); ?>

	<link href="<?= base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

	<link href="<?= base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
	<link href="<?= base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

	<link href="<?= base_url().'assets/css/animate.css' ?>" rel="stylesheet">
	<link href="<?= base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

	<!-- Data Tables -->
	<link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">

</head>
<style>
	<?php
        $is_manager = ($_SESSION['level'] == 3 || $_SESSION['level'] == 5 || $_SESSION['level'] == 6);
        if (!$is_manager) {
            echo '.manager { display: none; }';
        }
    ?>
</style>

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
						通知
					</li>
					<?php
					if ($is_manager) echo "<li><strong>管理</strong></li>";
					?>
				</ol>
			</div>
		</div>
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>所有通知</h5>
							<div class="ibox-tools">
								<a href="<?php echo site_url('Notify/writeNotice'); ?>"
								   class="btn btn-primary btn-xs manager">发布新通知</a>
							</div>
						</div>
						<div class="ibox-content" style="padding-bottom: 20px;">
							<table class="table table-striped table-bordered table-hover users-dataTable">
								<thead>
								<tr>
									<th>序号</th>
									<th>通知</th>
									<th>发布人</th>
									<th>发布日期</th>
									<th>操作</th>
								</tr>
								</thead>
								<tbody id="notice-list">
								<tr>
									<td>0</td>
									<td>无</td>
									<td>无</td>
									<td>0</td>
									<td>无</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('view_footer'); ?>
	</div>
</div>

<!-- Mainly scripts -->
<script src="<?= base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
<script src="<?= base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
<script src="<?= base_url().'assets/js/onduty_in.js' ?>"></script>
<script src="<?= base_url().'assets/js/notice.js' ?>"></script>

<!-- nav item active -->
<script>
	$(document).ready(function () {
		$("#mini").attr("href", "Notify#");
	});
</script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>

<!-- Dynamic date -->
<script src="<?= base_url().'assets/js/dynamicDate.js' ?>"></script>

<!-- Chosen -->
<script src="<?= base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

<!-- Data Tables -->
<script src="<?= base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
<script src="<?= base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>


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
>>>>>>> abnormal
