<<<<<<< HEAD
<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 排班控制类
 * @author 伟
 */
Class DutyArrange extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_nschedule_model');
		$this->load->model('Moa_duty_model');
        $this->load->model('Moa_config_model');
		$this->load->model('Moa_holidayschedule_model');
		$this->load->model('Moa_scheduleduty_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}

	public function index() {

	}

	/**
	 * 排班页面加载
	 */
	public function dutyArrange() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 3-助理负责人 6-超级管理员
			if ($_SESSION['level'] != 3 && $_SESSION['level'] != 6) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}

			// 取所有普通助理的wid与name, level: 0-普通助理  1-组长  2-负责人助理  3-助理负责人  4-管理员  5-办公室负责人
			$level = 0;
			$common_worker = $this->Moa_user_model->get_all($level);
            $uid_list = array();
            $name_list = array();
            $wid_list = array();
			for ($i = 0; $i < count($common_worker); $i++) {
				$uid_list[$i] = $common_worker[$i]->uid;
				$name_list[$i] = $common_worker[$i]->name;
				$wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
			}

			$data['name_list'] 	= $name_list;
			$data['wid_list'] 	= $wid_list;

			$schedule = $this->getSchedule();
			$data['schedule'] = $schedule;

			$hsdata = $this->getHolidaySchedule();
			$data['workerTimeSchedule'] = $hsdata['workerTimeSchedule'];
			$data['timeSchedule']		= $hsdata['timeSchedule'];
            $weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
            $weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));
            $data['day_name'] = array('MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN');
            $data['weekday_breakpoint'] = $weekday_breakpoint;
            $data['weekend_breakpoint'] = $weekend_breakpoint;

			$this->load->view('view_duty_arrange', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	function getHolidaySchedule() {
		// 获取假期考试周空闲时间表

		date_default_timezone_set("PRC");
		$holidaySchedule = $this->Moa_holidayschedule_model->latest();
		$holidaySchedule = $holidaySchedule[0];

		$hsid 		 = $holidaySchedule->hsid;
		$name 		 = $holidaySchedule->name;
		$description = $holidaySchedule->description;
		$startDate 	 = date_format(date_create($holidaySchedule->dayfrom), "Y-m-d");
		$endDate 	 = date_format(date_create($holidaySchedule->dayto), "Y-m-d");

		$workerSchedule = $this->Moa_scheduleduty_model->get_by_hsid($hsid);
		$workerTimeSchedule = array();
		$timeSchedule = array();
		for($i = $startDate; $i <= $endDate; $i = PublicMethod::addOneDay($i)) {
			array_push($timeSchedule, $i);
		}

		for($i = 0; $i < count($timeSchedule); $i++) {
			$workerTimeSchedule[$i] = array("wid" => array(), "timestamp" => $timeSchedule[$i], "name" => array(), "isPermitted" => array());
		}

		for($i = 0; $i < count($workerSchedule); $i++) {

			$timestamp 	= date_format(date_create($workerSchedule[$i]->timestamp), "Y-m-d");
			// 从$startDate起，是数组下标为0的元素，计算时间间隔来得到偏移量
			$index = PublicMethod::getTimeInterval($timestamp, $startDate);
			$wid 		 = $workerSchedule[$i]->wid;
			$name 		 = $this->Moa_worker_model->get_name_by_wid($wid);
			$isPermitted = $workerSchedule[$i]->isPermitted;
			array_push($workerTimeSchedule[$index]['wid'], $wid);
			array_push($workerTimeSchedule[$index]['name'], $name[0]->name);
			array_push($workerTimeSchedule[$index]['isPermitted'], $isPermitted);
		}

		return array("workerTimeSchedule" => $workerTimeSchedule, "timeSchedule" =>  $timeSchedule);
	}

	function getSchedule() {
		// 存放值班表助理名单的二维数组
		$schedule = array();

		// 取原有值班表记录
		$duty_obj_list = $this->Moa_duty_model->get_all();
		if (!empty($duty_obj_list)) {
			// 提取每个时段的值班助理wid
			for ($i = 0; $i < count($duty_obj_list); $i++) {
				$tmp_weekday = $duty_obj_list[$i]->weekday;
				$tmp_period = $duty_obj_list[$i]->period;
				$schedule[$tmp_weekday][$tmp_period] = explode(',', $duty_obj_list[$i]->wids);
			}
		}
		return $schedule;
	}

	/*
	 * 排班录入
	 * 修改by： 少彬
	 */
	public function dutyArrangeIn() {
		if (isset($_SESSION['user_id'])) {
			// 每次存入新的排班表前清空旧排班表
			$this->Moa_duty_model->clear();
			// 每个时段存入一条记录，共有36条记录
			// 周一至周五有6个时段，周六周日，每天三个时段，从第7个开始计数
            $weekday_len = count(explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint')));
            $weekend_len = count(explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint')));
			$week = array(
						// 星期几，划分的时段，每天开始的第一个时段
                        //有n个间断点就有n-1个时段嘛
						array('MON', $weekday_len - 1, 1),
						array('TUE', $weekday_len - 1, 1),
						array('WED', $weekday_len - 1, 1),
						array('THU', $weekday_len - 1, 1),
						array('FRI', $weekday_len - 1, 1),
						array('SAT', $weekend_len - 1, 1),
						array('SUN', $weekend_len - 1, 1)
					);
			$arrange_list = $_POST['arrange_list'];

		    for($i = 0; $i < count($week); $i++) {
		        $day = $week[$i];
		        // 记录当前星期几
		        $which_day = $day[0];
		        // 今天有多少个时段
		        $period_limit = $day[1];
		        // 开始的时段
		        $period_start = $day[2];
		        $period_now = $period_start;

		        for($period = $period_start; $period < $period_limit + $period_start; $period++) {
					// such as 'MON1_list'
					$period_wid_list = $which_day.$period.'_list';
					if (isset($arrange_list[$period_wid_list])) {
						$duty_paras['wids'] = '';
						if (!empty($arrange_list[$period_wid_list])) {
							$duty_paras['wids'] = implode(',', $arrange_list[$period_wid_list]);
						}
						$duty_paras['weekday'] = $i + 1;
						$duty_paras['period'] = $period;
						$dutyid = $this->Moa_duty_model->add($duty_paras);
						if ($dutyid == FALSE) {
							echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
							return;
						}
					}
		        }
		    }
            echo json_encode(array("status" => TRUE, "msg" => "发布成功"));
            return;
		}
	}

	/**
	 * 查看值班表（排班结果）
	 */
	public function dutySchedule() {
		if (isset($_SESSION['user_id'])) {

			$uid = $_SESSION['user_id'];

			// 存放值班表助理名单的二维数组
			$schedule = array();

			// 取所有值班表记录
			$duty_obj_list = $this->Moa_duty_model->get_all();

			if (!empty($duty_obj_list)) {
				// 提取每个时段的值班助理名单wid-uid-name
				for ($i = 0; $i < count($duty_obj_list); $i++) {
					if (!empty($duty_obj_list[$i]->wids)) {
						$tmp_weekday = $duty_obj_list[$i]->weekday;
						$tmp_period = $duty_obj_list[$i]->period;
						$tmp_wid_list = explode(',', $duty_obj_list[$i]->wids);
						// 提取该时段每位助理的姓名
                        $schedule[$tmp_weekday][$tmp_period] = '';
						for ($j = 0; $j < count($tmp_wid_list); $j++) {
							$tmp_wid = $tmp_wid_list[$j];
							$tmp_worker_obj = $this->Moa_worker_model->get($tmp_wid);
                            $tmp_groupname = PublicMethod::translate_group($tmp_worker_obj->group);
							$tmp_uid = $tmp_worker_obj->uid;
							$tmp_user_obj = $this->Moa_user_model->get($tmp_uid);
							$tmp_name = $tmp_user_obj->name;
							// 如果uid为当前访问用户自己，则高亮显示
							if ($tmp_uid == $uid) {
								$schedule[$tmp_weekday][$tmp_period] .= '<span style="color: #1AB394;"><b>' . $tmp_name . ' (' . $tmp_groupname . ')</b></span> <br />';
							} else {
								$schedule[$tmp_weekday][$tmp_period] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
							}
						}
					}
				}
			}

			$hsdata = $this->getHolidaySchedule();
			$data['workerTimeSchedule'] = $hsdata['workerTimeSchedule'];
			$data['timeSchedule']		= $hsdata['timeSchedule'];

            $weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
            $weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));
            $data['weekday_breakpoint'] = $weekday_breakpoint;
            $data['weekend_breakpoint'] = $weekend_breakpoint;
			$data['schedule'] = $schedule;

			$this->load->view('view_duty_schedule', $data);

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/**
	 * 查看空余时间总表
	 */
	public function freeTable() {
		if (isset($_SESSION['user_id'])) {

			$uid = $_SESSION['user_id'];

			// 存放值班表助理名单的二维数组
			$schedule = array();

			// 取所有值班报名记录
			$duty_obj_list = $this->Moa_nschedule_model->get_all();

			$day_name = array('MON' => 1, 'TUE' => 2, 'WED' => 3, 'THU' => 4,
                                'FRI' => 5, 'SAT' => 6, 'SUN' => 7);
			$weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
			$weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));

            $weekday_len = count($weekday_breakpoint);
            $weekend_len = count($weekend_breakpoint);

            for($i = 1; $i <= 5; ++$i) {
                //有n个间断点就有n-1个时段嘛
                for($j = 1; $j <= $weekday_len - 1; ++$j) {
                    $schedule[$i][$j] = '';
                }
            }

            for($i = 6; $i <= 7; ++$i) {
                //有n个间断点就有n-1个时段嘛
                for($j = 1; $j <= $weekend_len - 1; ++$j) {
                    $schedule[$i][$j] = '';
                }
            }

			if (!empty($duty_obj_list)) {
				// 提取每个时段的值班助理名单wid-uid-name
				for ($i = 0; $i < count($duty_obj_list); $i++) {
                    $lineitem = $duty_obj_list[$i];
					if (!empty($lineitem->wid)) {
                        $tmp_wid = $lineitem->wid;
                        $tmp_groupid = $lineitem->groupid;
                        $tmp_periodList = explode(',', $lineitem->period);
                        $tmp_worker_obj = $this->Moa_worker_model->get($tmp_wid);

						$tmp_uid = $tmp_worker_obj->uid;
                        $tmp_groupname = PublicMethod::translate_group($tmp_worker_obj->group);

						$tmp_user_obj = $this->Moa_user_model->get($tmp_uid);
						$tmp_name = $tmp_user_obj->name;
                        // 将其加入到对应空余时间槽里
                        for ($t = 0; $t < count($tmp_periodList); $t++) {
                            $indexa = $day_name[substr($tmp_periodList[$t], 0, 3)];
                            $indexb = intval(substr($tmp_periodList[$t], 3, 1));
                            //if(isset($schedule[$indexa][$indexb])) {
                                $schedule[$indexa][$indexb] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                            //}

                        }
					}
				}
			}


			$data['schedule'] = json_encode($schedule);
            $data['weekday_breakpoint'] = json_encode($weekday_breakpoint);
            $data['weekend_breakpoint'] = json_encode($weekend_breakpoint);

			$this->load->view('view_duty_free', $data);

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	public function holidaySchedule() {
		if (isset($_SESSION['user_id'])) {

			// 普通助理没有权限
			if ($_SESSION['level'] == 0) {
				PublicMethod::permissionDenied();
			}

			$name 		 = $_POST['name'];
			$from 		 = $_POST['from'];
			$to 		 = $_POST['to'];
			$description = $_POST['description'];

			$res = $this->Moa_holidayschedule_model->add($name, $from, $to, $description);

			if(!$res) {
				echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
				return;
			}

			echo json_encode(array("status" => TRUE, "msg" => "发布成功"));

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	public function publishHolidaySchedule() {
		if (isset($_SESSION['user_id'])) {

			// 普通助理没有权限
			if ($_SESSION['level'] == 0) {
				PublicMethod::permissionDenied();
			}
			$holidaySchedule = $this->Moa_holidayschedule_model->latest();
			$holidaySchedule = $holidaySchedule[0];

			$hsid 		 	 = $holidaySchedule->hsid;
			$dataList 		 = $_POST['list'];

			$res = $this->Moa_scheduleduty_model->updatePermitted($dataList, $hsid);

			if(!$res) {
				echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
				return;
			}

			echo json_encode(array("status" => TRUE, "msg" => "发布成功"));

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	public function latestHolidaySchedule() {
		if (isset($_SESSION['user_id'])) {

			$res = $this->Moa_holidayschedule_model->latest();

			if(!$res) {
				echo json_encode(array("status" => FALSE, "msg" => "获取失败"));
				return;
			}

			echo json_encode(array("status" => TRUE, "data" => $res, "msg" => "获取成功"));

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

}
=======
<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 排班控制类
 * @author 伟
 */
Class DutyArrange extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_nschedule_model');
		$this->load->model('Moa_duty_model');
        $this->load->model('Moa_config_model');
		$this->load->model('Moa_holidayschedule_model');
		$this->load->model('Moa_scheduleduty_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}

	public function index() {

	}

	/**
	 * 排班页面加载
	 */
	public function dutyArrange() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 3-助理负责人 6-超级管理员
			if ($_SESSION['level'] != 3 && $_SESSION['level'] != 6) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}

			// 取所有普通助理的wid与name, level: 0-普通助理  1-组长  2-负责人助理  3-助理负责人  4-管理员  5-办公室负责人
			$level = 0;
			$common_worker = $this->Moa_user_model->get_all($level);
            $uid_list = array();
            $name_list = array();
            $wid_list = array();
			for ($i = 0; $i < count($common_worker); $i++) {
				$uid_list[$i] = $common_worker[$i]->uid;
				$name_list[$i] = $common_worker[$i]->name;
				$wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
			}

			$data['name_list'] 	= $name_list;
			$data['wid_list'] 	= $wid_list;

			$schedule = $this->getSchedule();
			$data['schedule'] = $schedule;

			$hsdata = $this->getHolidaySchedule();
			$data['workerTimeSchedule'] = $hsdata['workerTimeSchedule'];
			$data['timeSchedule']		= $hsdata['timeSchedule'];
            $weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
            $weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));
            $data['day_name'] = array('MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN');
            $data['weekday_breakpoint'] = $weekday_breakpoint;
            $data['weekend_breakpoint'] = $weekend_breakpoint;

			$this->load->view('view_duty_arrange', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	function getHolidaySchedule() {
		// 获取假期考试周空闲时间表

		date_default_timezone_set("PRC");
		$holidaySchedule = $this->Moa_holidayschedule_model->latest();
		$holidaySchedule = $holidaySchedule[0];

		$hsid 		 = $holidaySchedule->hsid;
		$name 		 = $holidaySchedule->name;
		$description = $holidaySchedule->description;
		$startDate 	 = date_format(date_create($holidaySchedule->dayfrom), "Y-m-d");
		$endDate 	 = date_format(date_create($holidaySchedule->dayto), "Y-m-d");

		$workerSchedule = $this->Moa_scheduleduty_model->get_by_hsid($hsid);
		$workerTimeSchedule = array();
		$timeSchedule = array();
		for($i = $startDate; $i <= $endDate; $i = PublicMethod::addOneDay($i)) {
			array_push($timeSchedule, $i);
		}

		for($i = 0; $i < count($timeSchedule); $i++) {
			$workerTimeSchedule[$i] = array("wid" => array(), "timestamp" => $timeSchedule[$i], "name" => array(), "isPermitted" => array());
		}

		for($i = 0; $i < count($workerSchedule); $i++) {

			$timestamp 	= date_format(date_create($workerSchedule[$i]->timestamp), "Y-m-d");
			// 从$startDate起，是数组下标为0的元素，计算时间间隔来得到偏移量
			$index = PublicMethod::getTimeInterval($timestamp, $startDate);
			$wid 		 = $workerSchedule[$i]->wid;
			$name 		 = $this->Moa_worker_model->get_name_by_wid($wid);
			$isPermitted = $workerSchedule[$i]->isPermitted;
			array_push($workerTimeSchedule[$index]['wid'], $wid);
			array_push($workerTimeSchedule[$index]['name'], $name[0]->name);
			array_push($workerTimeSchedule[$index]['isPermitted'], $isPermitted);
		}

		return array("workerTimeSchedule" => $workerTimeSchedule, "timeSchedule" =>  $timeSchedule);
	}

	function getSchedule() {
		// 存放值班表助理名单的二维数组
		$schedule = array();

		// 取原有值班表记录
		$duty_obj_list = $this->Moa_duty_model->get_all();
		if (!empty($duty_obj_list)) {
			// 提取每个时段的值班助理wid
			for ($i = 0; $i < count($duty_obj_list); $i++) {
				$tmp_weekday = $duty_obj_list[$i]->weekday;
				$tmp_period = $duty_obj_list[$i]->period;
				$schedule[$tmp_weekday][$tmp_period] = explode(',', $duty_obj_list[$i]->wids);
			}
		}
		return $schedule;
	}

	/*
	 * 排班录入
	 * 修改by： 少彬
	 */
	public function dutyArrangeIn() {
		if (isset($_SESSION['user_id'])) {
			// 每次存入新的排班表前清空旧排班表
			$this->Moa_duty_model->clear();
			// 每个时段存入一条记录，共有36条记录
			// 周一至周五有6个时段，周六周日，每天三个时段，从第7个开始计数
            $weekday_len = count(explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint')));
            $weekend_len = count(explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint')));
			$week = array(
						// 星期几，划分的时段，每天开始的第一个时段
                        //有n个间断点就有n-1个时段嘛
						array('MON', $weekday_len - 1, 1),
						array('TUE', $weekday_len - 1, 1),
						array('WED', $weekday_len - 1, 1),
						array('THU', $weekday_len - 1, 1),
						array('FRI', $weekday_len - 1, 1),
						array('SAT', $weekend_len - 1, 1),
						array('SUN', $weekend_len - 1, 1)
					);
			$arrange_list = $_POST['arrange_list'];

		    for($i = 0; $i < count($week); $i++) {
		        $day = $week[$i];
		        // 记录当前星期几
		        $which_day = $day[0];
		        // 今天有多少个时段
		        $period_limit = $day[1];
		        // 开始的时段
		        $period_start = $day[2];
		        $period_now = $period_start;

		        for($period = $period_start; $period < $period_limit + $period_start; $period++) {
					// such as 'MON1_list'
					$period_wid_list = $which_day.$period.'_list';
					if (isset($arrange_list[$period_wid_list])) {
						$duty_paras['wids'] = '';
						if (!empty($arrange_list[$period_wid_list])) {
							$duty_paras['wids'] = implode(',', $arrange_list[$period_wid_list]);
						}
						$duty_paras['weekday'] = $i + 1;
						$duty_paras['period'] = $period;
						$dutyid = $this->Moa_duty_model->add($duty_paras);
						if ($dutyid == FALSE) {
							echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
							return;
						}
					}
		        }
		    }
            echo json_encode(array("status" => TRUE, "msg" => "发布成功"));
            return;
		}
	}

	/**
	 * 查看值班表（排班结果）
	 */
	public function dutySchedule() {
		if (isset($_SESSION['user_id'])) {

			$uid = $_SESSION['user_id'];

			// 存放值班表助理名单的二维数组
			$schedule = array();

			// 取所有值班表记录
			$duty_obj_list = $this->Moa_duty_model->get_all();

			if (!empty($duty_obj_list)) {
				// 提取每个时段的值班助理名单wid-uid-name
				for ($i = 0; $i < count($duty_obj_list); $i++) {
					if (!empty($duty_obj_list[$i]->wids)) {
						$tmp_weekday = $duty_obj_list[$i]->weekday;
						$tmp_period = $duty_obj_list[$i]->period;
						$tmp_wid_list = explode(',', $duty_obj_list[$i]->wids);
						// 提取该时段每位助理的姓名
                        $schedule[$tmp_weekday][$tmp_period] = '';
						for ($j = 0; $j < count($tmp_wid_list); $j++) {
							$tmp_wid = $tmp_wid_list[$j];
							$tmp_worker_obj = $this->Moa_worker_model->get($tmp_wid);
                            $tmp_groupname = PublicMethod::translate_group($tmp_worker_obj->group);
							$tmp_uid = $tmp_worker_obj->uid;
							$tmp_user_obj = $this->Moa_user_model->get($tmp_uid);
							$tmp_name = $tmp_user_obj->name;
							// 如果uid为当前访问用户自己，则高亮显示
							if ($tmp_uid == $uid) {
								$schedule[$tmp_weekday][$tmp_period] .= '<span style="color: #1AB394;"><b>' . $tmp_name . ' (' . $tmp_groupname . ')</b></span> <br />';
							} else {
								$schedule[$tmp_weekday][$tmp_period] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
							}
						}
					}
				}
			}

			$hsdata = $this->getHolidaySchedule();
			$data['workerTimeSchedule'] = $hsdata['workerTimeSchedule'];
			$data['timeSchedule']		= $hsdata['timeSchedule'];

            $weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
            $weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));
            $data['weekday_breakpoint'] = $weekday_breakpoint;
            $data['weekend_breakpoint'] = $weekend_breakpoint;
			$data['schedule'] = $schedule;

			$this->load->view('view_duty_schedule', $data);

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/**
	 * 查看空余时间总表
	 */
	public function freeTable() {
		if (isset($_SESSION['user_id'])) {

			$uid = $_SESSION['user_id'];

			// 存放值班表助理名单的二维数组
			$schedule = array();

			// 取所有值班报名记录
			$duty_obj_list = $this->Moa_nschedule_model->get_all();

			$day_name = array('MON' => 1, 'TUE' => 2, 'WED' => 3, 'THU' => 4,
                                'FRI' => 5, 'SAT' => 6, 'SUN' => 7);
			$weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
			$weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));

            $weekday_len = count($weekday_breakpoint);
            $weekend_len = count($weekend_breakpoint);

            for($i = 1; $i <= 5; ++$i) {
                //有n个间断点就有n-1个时段嘛
                for($j = 1; $j <= $weekday_len - 1; ++$j) {
                    $schedule[$i][$j] = '';
                }
            }

            for($i = 6; $i <= 7; ++$i) {
                //有n个间断点就有n-1个时段嘛
                for($j = 1; $j <= $weekend_len - 1; ++$j) {
                    $schedule[$i][$j] = '';
                }
            }

			if (!empty($duty_obj_list)) {
				// 提取每个时段的值班助理名单wid-uid-name
				for ($i = 0; $i < count($duty_obj_list); $i++) {
                    $lineitem = $duty_obj_list[$i];
					if (!empty($lineitem->wid)) {
                        $tmp_wid = $lineitem->wid;
                        $tmp_groupid = $lineitem->groupid;
                        $tmp_periodList = explode(',', $lineitem->period);
                        $tmp_worker_obj = $this->Moa_worker_model->get($tmp_wid);

						$tmp_uid = $tmp_worker_obj->uid;
                        $tmp_groupname = PublicMethod::translate_group($tmp_worker_obj->group);

						$tmp_user_obj = $this->Moa_user_model->get($tmp_uid);
						$tmp_name = $tmp_user_obj->name;
                        // 将其加入到对应空余时间槽里
                        for ($t = 0; $t < count($tmp_periodList); $t++) {
                            $indexa = $day_name[substr($tmp_periodList[$t], 0, 3)];
                            $indexb = intval(substr($tmp_periodList[$t], 3, 1));
                            //if(isset($schedule[$indexa][$indexb])) {
                                $schedule[$indexa][$indexb] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                            //}

                        }
					}
				}
			}


			$data['schedule'] = json_encode($schedule);
            $data['weekday_breakpoint'] = json_encode($weekday_breakpoint);
            $data['weekend_breakpoint'] = json_encode($weekend_breakpoint);

			$this->load->view('view_duty_free', $data);

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	public function holidaySchedule() {
		if (isset($_SESSION['user_id'])) {

			// 普通助理没有权限
			if ($_SESSION['level'] == 0) {
				PublicMethod::permissionDenied();
			}

			$name 		 = $_POST['name'];
			$from 		 = $_POST['from'];
			$to 		 = $_POST['to'];
			$description = $_POST['description'];

			$res = $this->Moa_holidayschedule_model->add($name, $from, $to, $description);

			if(!$res) {
				echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
				return;
			}

			echo json_encode(array("status" => TRUE, "msg" => "发布成功"));

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	public function publishHolidaySchedule() {
		if (isset($_SESSION['user_id'])) {

			// 普通助理没有权限
			if ($_SESSION['level'] == 0) {
				PublicMethod::permissionDenied();
			}
			$holidaySchedule = $this->Moa_holidayschedule_model->latest();
			$holidaySchedule = $holidaySchedule[0];

			$hsid 		 	 = $holidaySchedule->hsid;
			$dataList 		 = $_POST['list'];

			$res = $this->Moa_scheduleduty_model->updatePermitted($dataList, $hsid);

			if(!$res) {
				echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
				return;
			}

			echo json_encode(array("status" => TRUE, "msg" => "发布成功"));

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	public function latestHolidaySchedule() {
		if (isset($_SESSION['user_id'])) {

			$res = $this->Moa_holidayschedule_model->latest();

			if(!$res) {
				echo json_encode(array("status" => FALSE, "msg" => "获取失败"));
				return;
			}

			echo json_encode(array("status" => TRUE, "data" => $res, "msg" => "获取成功"));

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

}
>>>>>>> abnormal
