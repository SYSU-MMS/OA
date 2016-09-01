<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 周检录入控制类
 * @author 伟
 */
Class WeeklyCheck extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_check_model');
		$this->load->model('Moa_attend_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	/**
	 * 周检签到、课室情况登记页面
	 * 周检课室列表加载
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 0-普通助理  6-超级管理员
			if ($_SESSION['level'] != 0 && $_SESSION['level'] != 6) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			// 获取周检课室
			$uid = $_SESSION['user_id'];
			$wid = $this->Moa_worker_model->get_wid_by_uid($uid);
			$classrooms = $this->Moa_worker_model->get($wid)->week_classroom;
			$classroom_list = explode(',', $classrooms);
			$data['classroom_list'] = $classroom_list;
			$this->load->view('view_weekly_check', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/*
	 * 周检
	 */
	public function weeklyCheck() {
		if (isset($_SESSION['user_id'])) {
			// 获取周检课室
			$uid = $_SESSION['user_id'];
			$wid = $this->Moa_worker_model->get_wid_by_uid($uid);
			$classrooms = $this->Moa_worker_model->get($wid)->week_classroom;
			$classroom_list = explode(',', $classrooms);
			$room_count = count($classroom_list);
			$success_count = 0;
			$time = date('Y-m-d H:i:s');
	
			if (isset($_POST['cond_week']) && isset($_POST['cond_lamp'])) {
				// 周一为一周的第一天
				$check_paras['weekcount'] = PublicMethod::cal_week();
	
				// 1-周一  2-周二  ... 6-周六  7-周日
				$check_paras['weekday'] = date("w") == 0 ? 7 : date("w");
	
				// type: 0-早检  1-午检  2-晚检  3-周检
				$check_paras['type'] = 3;
	
				// isChecked: 0-否     1-是，正常     2-是，课室有故障
				$check_paras['isChecked'] = 0;
				$check_paras['actual_wid'] = $wid;
				$check_paras['timestamp'] = $time;
	
				for ($i = 0; $i < $room_count; $i++) {
					$check_paras['problemid'] = NULL;
					$roomid = $this->Moa_check_model->get_roomid_by_room($classroom_list[$i]);
					$check_paras['roomid'] = $roomid;
					// 课室情况
					$prob_description = $_POST['cond_week'][$i];
					// 灯时
					$check_paras['light'] = 0;
					if (!empty($_POST['cond_lamp'][$i])) {
						$check_paras['light'] = $_POST['cond_lamp'][$i];
					}
					
					// 课室正常
					if ($prob_description == "" || $prob_description == "正常") {
						$check_paras['isChecked'] = 1;
						// 添加早检记录
						$checkid = $this->Moa_check_model->add_check($check_paras);
						if ($checkid) {
							$success_count++;
							continue;
						} else {
							echo json_encode(array("status" => FALSE, "msg" => "提交失败"));
							return;
						}
					}
					// 课室有故障
					else {
						$check_paras['isChecked'] = 2;
						// 添加问题（故障）记录
						$prob_paras['founder_wid'] = $wid;
						$prob_paras['roomid'] = $roomid;
						$prob_paras['description'] = $prob_description;
						$prob_paras['found_time'] = $time;
						$prob_paras['solved_time'] = $time;
						$problemid = $this->Moa_check_model->add_problem($prob_paras);
						// 添加周检记录
						$check_paras['problemid'] = $problemid;
						$checkid = $this->Moa_check_model->add_check($check_paras);
						if ($problemid && $checkid) {
							$success_count++;
							continue;
						} else {
							echo json_encode(array("status" => FALSE, "msg" => "提交失败"));
							return;
						}
					}
				} // for
				// 是否全部成功写入数据库
				if ($success_count == $room_count) {
					// 添加考勤记录
					$attend_paras['wid'] = $wid;
					$attend_paras['timestamp'] = $time;
					// 周次，周一为一周的第一天
					$attend_paras['weekcount'] = PublicMethod::cal_week();
					// 1-周一  2-周二  ... 6-周六  7-周日
					$attend_paras['weekday'] = date("w") == 0 ? 7 : date("w");
					// 签到type: 0-值班  1-早检 2-午检 3-晚检 4-周检
					$attend_paras['type'] = 4;
					// 是否迟到：0-否 1-是
					$attend_paras['isLate'] = 0;
					// 是否代班：0 - 否   1 - 是
					$attend_paras['isSubstitute'] = 0;
					$attend_id = $this->Moa_attend_model->add($attend_paras);
					
					// 更新工时
					$contrib = PublicMethod::get_weekly_working_hours($room_count);
					$affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
					$affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);
					
					if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
						echo json_encode(array("status" => FALSE, "msg" => "登记失败"));
						return;
					}
					// 成功写入考勤记录
					echo json_encode(array("status" => TRUE, "msg" => "提交成功"));
					return;
				} else {
					echo json_encode(array("status" => FALSE, "msg" => "提交失败"));
					return;
				}
			} else {
				echo json_encode(array("status" => FALSE, "msg" => "提交失败"));
				return;
			}
		}
	}
}