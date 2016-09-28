<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 值班登记控制类
 * @author 伟
 */
Class Duty extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_attend_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	/**
	 * 进入值班登记页面
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 0-普通助理  6-超级管理员
			if ($_SESSION['level'] != 0 && $_SESSION['level'] != 6) {
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
				
			$wid = $this->Moa_worker_model->get_wid_by_uid($_SESSION['user_id']);
			$data['wid'] = $wid;
			$data['name_list'] = $name_list;
			$data['wid_list'] = $wid_list;
			// 传入wid列表用于选择被代班助理
			$this->load->view('view_duty', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/*
	 * 值班时间登记
	 */
	public function ondutyRecord() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$wid = $this->Moa_worker_model->get_wid_by_uid($uid);
			
			if (isset($_POST['time_from']) && isset($_POST['time_to'])) {
				// 1-周一  2-周二  ... 6-周六  7-周日
				$weekday = date("w") == 0 ? 7 : date("w");
				$periods_list = PublicMethod::get_duty_periods($weekday, $_POST['time_from'], $_POST['time_to']);
				if ($periods_list == NULL) {
					echo json_encode(array("status" => FALSE, "msg" => "请选取有效的值班时间段"));
					return;
				}
				
				$attend_paras['wid'] = $wid;
				$attend_paras['timestamp'] = date('Y-m-d H:i:s');
				// 周次，周一为一周的第一天
				$attend_paras['weekcount'] = PublicMethod::cal_week();
				// 1-周一  2-周二  ... 6-周六  7-周日
				$attend_paras['weekday'] = date("w") == 0 ? 7 : date("w");
				// 签到type: 0-值班  1-早检 2-午检 3-晚检 4-周检
				$attend_paras['type'] = 0;
				// 是否迟到：0-否 1-是
				$attend_paras['isLate'] = 0;
				
				if (isset($_POST['is_replaced']) && isset($_POST['replaced_wid'])) {
					// 没有代班
					if ($_POST['is_replaced'] == 0) {
						// 是否代班：0 - 否   1 - 是
						$attend_paras['isSubstitute'] = 0;
						// 多个时间段分别插入数据库
						for ($i = 0; $i < count($periods_list); $i++) {
							$attend_paras['dutyPeriod'] = $periods_list[$i];
							$attend_id = $this->Moa_attend_model->add($attend_paras);
							
							// 更新工时
							$contrib = PublicMethod::get_working_hours($periods_list[$i]);
							$affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
							$affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);
							
							if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
								echo json_encode(array("status" => FALSE, "msg" => "登记失败"));
								return;
							}
						}
						echo json_encode(array("status" => TRUE, "msg" => "登记成功"));
						return;
					} 
					else if ($_POST['is_replaced'] == 1) {
						$attend_paras['isSubstitute'] = 1;
						if (!$_POST['replaced_wid']) {
							echo json_encode(array("status" => FALSE, "msg" => "请选择原值班助理"));
							return;
						}
						$attend_paras['substituteFor'] = $_POST['replaced_wid'];
						// 多个时间段分别插入数据库
						for ($i = 0; $i < count($periods_list); $i++) {
							$attend_paras['dutyPeriod'] = $periods_list[$i];
							$attend_id = $this->Moa_attend_model->add($attend_paras);
							
							// 更新工时
							$contrib = PublicMethod::get_working_hours($periods_list[$i]);
							$affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
							$affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);
							
							if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
								echo json_encode(array("status" => FALSE, "msg" => "登记失败"));
								return;
							}
						}
						echo json_encode(array("status" => TRUE, "msg" => "登记成功"));
						return;
					}
				}
				
			}
		}
	}
	
}