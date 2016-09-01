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
			$common_worker = $this->Moa_user_model->get_by_level($level);
			for ($i = 0; $i < count($common_worker); $i++) {
				$uid_list[$i] = $common_worker[$i]->uid;
				$name_list[$i] = $common_worker[$i]->name;
				$wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
			}
			$data['name_list'] = $name_list;
			$data['wid_list'] = $wid_list;
			
			// 存放值班表助理名单的二维数组
			$schedule = array();
			$schedule[1][1] = '';
			$schedule[1][2] = '';
			$schedule[1][3] = '';
			$schedule[1][4] = '';
			$schedule[1][5] = '';
			$schedule[1][6] = '';
			$schedule[2][1] = '';
			$schedule[2][2] = '';
			$schedule[2][3] = '';
			$schedule[2][4] = '';
			$schedule[2][5] = '';
			$schedule[2][6] = '';
			$schedule[3][1] = '';
			$schedule[3][2] = '';
			$schedule[3][3] = '';
			$schedule[3][4] = '';
			$schedule[3][5] = '';
			$schedule[3][6] = '';
			$schedule[4][1] = '';
			$schedule[4][2] = '';
			$schedule[4][3] = '';
			$schedule[4][4] = '';
			$schedule[4][5] = '';
			$schedule[4][6] = '';
			$schedule[5][1] = '';
			$schedule[5][2] = '';
			$schedule[5][3] = '';
			$schedule[5][4] = '';
			$schedule[5][5] = '';
			$schedule[5][6] = '';
			$schedule[6][7] = '';
			$schedule[6][8] = '';
			$schedule[6][9] = '';
			$schedule[7][7] = '';
			$schedule[7][8] = '';
			$schedule[7][9] = '';
				
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
			$data['schedule'] = $schedule;
			
			$this->load->view('view_duty_arrange', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/*
	 * 排班录入
	 */
	public function dutyArrangeIn() {
		if (isset($_SESSION['user_id'])) {
			// 每次存入新的排班表前清空旧排班表
			$this->Moa_duty_model->clear();
			// 每个时段存入一条记录，共有36条记录
			
			// MON1
			if (isset($_POST['MON1_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['MON1_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['MON1_list']);
				}
				$duty_paras['weekday'] = 1;
				$duty_paras['period'] = 1;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// MON2
			if (isset($_POST['MON2_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['MON2_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['MON2_list']);
				}
				$duty_paras['weekday'] = 1;
				$duty_paras['period'] = 2;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// MON3
			if (isset($_POST['MON3_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['MON3_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['MON3_list']);
				}
				$duty_paras['weekday'] = 1;
				$duty_paras['period'] = 3;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// MON4
			if (isset($_POST['MON4_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['MON4_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['MON4_list']);
				}
				$duty_paras['weekday'] = 1;
				$duty_paras['period'] = 4;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// MON5
			if (isset($_POST['MON5_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['MON5_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['MON5_list']);
				}
				$duty_paras['weekday'] = 1;
				$duty_paras['period'] = 5;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// MON6
			if (isset($_POST['MON6_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['MON6_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['MON6_list']);
				}
				$duty_paras['weekday'] = 1;
				$duty_paras['period'] = 6;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			
			// TUE1
			if (isset($_POST['TUE1_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['TUE1_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['TUE1_list']);
				}
				$duty_paras['weekday'] = 2;
				$duty_paras['period'] = 1;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// TUE2
			if (isset($_POST['TUE2_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['TUE2_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['TUE2_list']);
				}
				$duty_paras['weekday'] = 2;
				$duty_paras['period'] = 2;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// TUE3
			if (isset($_POST['TUE3_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['TUE3_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['TUE3_list']);
				}
				$duty_paras['weekday'] = 2;
				$duty_paras['period'] = 3;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// TUE4
			if (isset($_POST['TUE4_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['TUE4_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['TUE4_list']);
				}
				$duty_paras['weekday'] = 2;
				$duty_paras['period'] = 4;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// TUE5
			if (isset($_POST['TUE5_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['TUE5_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['TUE5_list']);
				}
				$duty_paras['weekday'] = 2;
				$duty_paras['period'] = 5;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// TUE6
			if (isset($_POST['TUE6_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['TUE6_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['TUE6_list']);
				}
				$duty_paras['weekday'] = 2;
				$duty_paras['period'] = 6;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			
			// WED1
			if (isset($_POST['WED1_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['WED1_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['WED1_list']);
				}
				$duty_paras['weekday'] = 3;
				$duty_paras['period'] = 1;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// WED2
			if (isset($_POST['WED2_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['WED2_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['WED2_list']);
				}
				$duty_paras['weekday'] = 3;
				$duty_paras['period'] = 2;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// WED3
			if (isset($_POST['WED3_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['WED3_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['WED3_list']);
				}
				$duty_paras['weekday'] = 3;
				$duty_paras['period'] = 3;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// WED4
			if (isset($_POST['WED4_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['WED4_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['WED4_list']);
				}
				$duty_paras['weekday'] = 3;
				$duty_paras['period'] = 4;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// WED5
			if (isset($_POST['WED5_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['WED5_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['WED5_list']);
				}
				$duty_paras['weekday'] = 3;
				$duty_paras['period'] = 5;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// WED6
			if (isset($_POST['WED6_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['WED6_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['WED6_list']);
				}
				$duty_paras['weekday'] = 3;
				$duty_paras['period'] = 6;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			
			// THU1
			if (isset($_POST['THU1_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['THU1_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['THU1_list']);
				}
				$duty_paras['weekday'] = 4;
				$duty_paras['period'] = 1;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// THU2
			if (isset($_POST['THU2_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['THU2_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['THU2_list']);
				}
				$duty_paras['weekday'] = 4;
				$duty_paras['period'] = 2;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// THU3
			if (isset($_POST['THU3_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['THU3_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['THU3_list']);
				}
				$duty_paras['weekday'] = 4;
				$duty_paras['period'] = 3;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// THU4
			if (isset($_POST['THU4_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['THU4_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['THU4_list']);
				}
				$duty_paras['weekday'] = 4;
				$duty_paras['period'] = 4;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// THU5
			if (isset($_POST['THU5_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['THU5_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['THU5_list']);
				}
				$duty_paras['weekday'] = 4;
				$duty_paras['period'] = 5;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// THU6
			if (isset($_POST['THU6_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['THU6_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['THU6_list']);
				}
				$duty_paras['weekday'] = 4;
				$duty_paras['period'] = 6;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			
			// FRI1
			if (isset($_POST['FRI1_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['FRI1_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['FRI1_list']);
				}
				$duty_paras['weekday'] = 5;
				$duty_paras['period'] = 1;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// FRI2
			if (isset($_POST['FRI2_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['FRI2_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['FRI2_list']);
				}
				$duty_paras['weekday'] = 5;
				$duty_paras['period'] = 2;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// FRI3
			if (isset($_POST['FRI3_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['FRI3_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['FRI3_list']);
				}
				$duty_paras['weekday'] = 5;
				$duty_paras['period'] = 3;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// FRI4
			if (isset($_POST['FRI4_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['FRI4_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['FRI4_list']);
				}
				$duty_paras['weekday'] = 5;
				$duty_paras['period'] = 4;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// FRI5
			if (isset($_POST['FRI5_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['FRI5_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['FRI5_list']);
				}
				$duty_paras['weekday'] = 5;
				$duty_paras['period'] = 5;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// FRI6
			if (isset($_POST['FRI6_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['FRI6_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['FRI6_list']);
				}
				$duty_paras['weekday'] = 5;
				$duty_paras['period'] = 6;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			
			// SAT1
			if (isset($_POST['SAT1_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['SAT1_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['SAT1_list']);
				}
				$duty_paras['weekday'] = 6;
				$duty_paras['period'] = 7;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// SAT2
			if (isset($_POST['SAT2_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['SAT2_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['SAT2_list']);
				}
				$duty_paras['weekday'] = 6;
				$duty_paras['period'] = 8;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// SAT3
			if (isset($_POST['SAT3_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['SAT3_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['SAT3_list']);
				}
				$duty_paras['weekday'] = 6;
				$duty_paras['period'] = 9;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			
			// SUN1
			if (isset($_POST['SUN1_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['SUN1_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['SUN1_list']);
				}
				$duty_paras['weekday'] = 7;
				$duty_paras['period'] = 7;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// SUN2
			if (isset($_POST['SUN2_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['SUN2_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['SUN2_list']);
				}
				$duty_paras['weekday'] = 7;
				$duty_paras['period'] = 8;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
			}
			// SUN3
			if (isset($_POST['SUN3_list'])) {
				$duty_paras['wids'] = '';
				if (!empty($_POST['SUN3_list'])) {
					$duty_paras['wids'] = implode(',', $_POST['SUN3_list']);
				}
				$duty_paras['weekday'] = 7;
				$duty_paras['period'] = 9;
				$dutyid = $this->Moa_duty_model->add($duty_paras);
				if ($dutyid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
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
			$schedule[1][1] = '';
			$schedule[1][2] = '';
			$schedule[1][3] = '';
			$schedule[1][4] = '';
			$schedule[1][5] = '';
			$schedule[1][6] = '';
			$schedule[2][1] = '';
			$schedule[2][2] = '';
			$schedule[2][3] = '';
			$schedule[2][4] = '';
			$schedule[2][5] = '';
			$schedule[2][6] = '';
			$schedule[3][1] = '';
			$schedule[3][2] = '';
			$schedule[3][3] = '';
			$schedule[3][4] = '';
			$schedule[3][5] = '';
			$schedule[3][6] = '';
			$schedule[4][1] = '';
			$schedule[4][2] = '';
			$schedule[4][3] = '';
			$schedule[4][4] = '';
			$schedule[4][5] = '';
			$schedule[4][6] = '';
			$schedule[5][1] = '';
			$schedule[5][2] = '';
			$schedule[5][3] = '';
			$schedule[5][4] = '';
			$schedule[5][5] = '';
			$schedule[5][6] = '';
			$schedule[6][7] = '';
			$schedule[6][8] = '';
			$schedule[6][9] = '';
			$schedule[7][7] = '';
			$schedule[7][8] = '';
			$schedule[7][9] = '';
			
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
						for ($j = 0; $j < count($tmp_wid_list); $j++) {
							$tmp_wid = $tmp_wid_list[$j];
							$tmp_worker_obj = $this->Moa_worker_model->get($tmp_wid);
							$tmp_uid = $tmp_worker_obj->uid;
							$tmp_user_obj = $this->Moa_user_model->get($tmp_uid);
							$tmp_name = $tmp_user_obj->name;
							// 如果uid为当前访问用户自己，则高亮显示
							if ($tmp_uid == $uid) {
								$schedule[$tmp_weekday][$tmp_period] .= '<span style="color: #1AB394;"><b>' . $tmp_name . '</b></span> <br />';
							} else {
								$schedule[$tmp_weekday][$tmp_period] .= $tmp_name . ' <br />';
							}
						}
					}
				}
			}

			$data['schedule'] = $schedule;
			
			$this->load->view('view_duty_schedule', $data);
			
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	
}