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
		$this->load->model('Moa_holidayschedule_model');
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
	 * 修改：by 少彬
	 */
	public function dutyArrangeIn() {
		if (isset($_SESSION['user_id'])) {
			// 每次存入新的排班表前清空旧排班表
			$this->Moa_duty_model->clear();
			// 每个时段存入一条记录，共有36条记录
			// 周一至周五有6个时段，周六周日，每天三个时段，从第7个开始计数

			$week = array(
						// 星期几，划分的时段，每天开始的第一个时段
						array('MON', 6, 1),
						array('TUE', 6, 1),
						array('WED', 6, 1),
						array('THU', 6, 1),
						array('FRI', 6, 1),
						array('SAT', 3, 7),
						array('SUN', 3, 7)
					);

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
					$period_wid_list = $which_day.$period_now.'_list';
					if (isset($_POST[$period_wid_list])) {
						$duty_paras['wids'] = '';
						if (!empty($_POST[$period_wid_list])) {
							$duty_paras['wids'] = implode(',', $_POST[$period_wid_list]);
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

			// 取所有值班报名记录
			$duty_obj_list = $this->Moa_nschedule_model->get_all();

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
                            switch ($tmp_periodList[$t]) {
                                case 'MON1':
                                    $schedule[1][1] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'MON2':
                                    $schedule[1][2] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'MON3':
                                    $schedule[1][3] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'MON4':
                                    $schedule[1][4] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'MON5':
                                    $schedule[1][5] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'MON6':
                                    $schedule[1][6] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'TUE1':
                                    $schedule[2][1] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'TUE2':
                                    $schedule[2][2] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'TUE3':
                                    $schedule[2][3] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'TUE4':
                                    $schedule[2][4] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'TUE5':
                                    $schedule[2][5] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'TUE6':
                                    $schedule[2][6] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'WED1':
                                    $schedule[3][1] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'WED2':
                                    $schedule[3][2] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'WED3':
                                    $schedule[3][3] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'WED4':
                                    $schedule[3][4] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'WED5':
                                    $schedule[3][5] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'WED6':
                                    $schedule[3][6] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'THU1':
                                    $schedule[4][1] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'THU2':
                                    $schedule[4][2] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'THU3':
                                    $schedule[4][3] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'THU4':
                                    $schedule[4][4] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'THU5':
                                    $schedule[4][5] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'THU6':
                                    $schedule[4][6] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'FRI1':
                                    $schedule[5][1] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'FRI2':
                                    $schedule[5][2] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'FRI3':
                                    $schedule[5][3] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'FRI4':
                                    $schedule[5][4] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'FRI5':
                                    $schedule[5][5] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'FRI6':
                                    $schedule[5][6] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'SAT1':
                                    $schedule[6][7] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'SAT2':
                                    $schedule[6][8] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'SAT3':
                                    $schedule[6][9] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'SUN1':
                                    $schedule[7][7] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'SUN2':
                                    $schedule[7][8] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                                case 'SUN3':
                                    $schedule[7][9] .= $tmp_name . ' (' . $tmp_groupname . ') <br />';
                                    break;
                            }
                        }
					}
				}
			}

			$data['schedule'] = $schedule;

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

}
