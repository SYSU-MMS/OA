<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 值班报名控制类
 * @author 伟
 */
Class DutySignUp extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
        $this->load->model('Moa_config_model');
		$this->load->model('Moa_nschedule_model');
		$this->load->model('Moa_scheduleduty_model');
		$this->load->model('Moa_holidayschedule_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}

	/**
	 * 进入值班报名页面
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 0-普通助理 3-助理负责人 6-超级管理员
			if ($_SESSION['level'] != 0 && $_SESSION['level'] != 3 && $_SESSION['level'] != 6) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}

            $weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
            $weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));
            $data['weekday_breakpoint'] = $weekday_breakpoint;
            $data['weekend_breakpoint'] = $weekend_breakpoint;
            $data['day_name'] = PublicMethod::day_name();
			
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

			$this->load->view('view_duty_signup', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/*
	 * 值班报名
	 */
	public function signUp() {
		if (isset($_SESSION['user_id'])) {
			var_dump($_POST);;
			if($_POST[$select_name] != ""){
				$uid = $_SESSION['user_id'];
				$wid = $this->Moa_worker_model->get_wid_by_uid($uid);
			}else{
				$wid = (int)$_POST[$select_name];
			}


			$groupid = '';
			if (isset($_POST['groupid'])) {
				$groupid = $_POST['groupid'];
			}

			// 值班时间段，以“,”分隔
			$periods = '';

			$day_name = PublicMethod::day_name();
            $weekday_len = count(explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint')));
            $weekend_len = count(explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint')));

			for($j = 0; $j < 5; ++$j) {
                for ($i = 1; $i <= $weekday_len - 1; $i++) {
                    if (isset($_POST[$day_name[$j] . $i])) {
                        if ($periods != '') {
                            $periods = $periods . ',';
                        }
                        $periods = $periods . $day_name[$j] . $i;
                    }
                }
            }
            for($j = 5; $j < 7; ++$j) {
                for ($i = 1; $i <= $weekend_len - 1; $i++) {
                    if (isset($_POST[$day_name[$j] . $i])) {
                        if ($periods != '') {
                            $periods = $periods . ',';
                        }
                        $periods = $periods . $day_name[$j] . $i;
                    }
                }
            }

			$ns_paras['wid'] = $wid;
			$ns_paras['groupid'] = $groupid;
			$ns_paras['period'] = $periods;

			// 写入数据库
			if ($periods != '') {
				$schedule_obj_list = $this->Moa_nschedule_model->get($wid);
				// 该助理已报过名，则删除原记录
				if (count($schedule_obj_list) != 0) {
					$delete_res = $this->Moa_nschedule_model->delete($schedule_obj_list[0]->nsid);
					if ($delete_res == 0) {
						//echo json_encode(array("status" => FALSE, "msg" => "你之前报过名，请联系助理负责人"));
						echo("提交失败");
						return;
					}
				}

				// 增加新记录
				$nsid = $this->Moa_nschedule_model->add($ns_paras);
				if ($nsid == FALSE) {
					$this->signup_failure();
					return;
				} else {
					$this->signup_success();
					return;
				}
			}
		}
	}

	/**
	 * 值班报名成功页面
	 */
	private function signup_success() {
		$data['status'] = TRUE;
		$this->load->view('view_signup_result', $data);
	}

	/**
	 * 值班报名失败页面
	 */
	private function signup_failure() {
		$data['status'] = FALSE;
		$this->load->view('view_signup_result', $data);
	}

	/**
	 * 值班报名结果
	 */
	public function signUpResult() {
		// Starting the PHPExcel library
		$this -> load -> library('PHPExcel');
		$this -> load -> library('PHPExcel/IOFactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel -> getProperties() -> setTitle("export") -> setDescription("none");

		$objPHPExcel -> setActiveSheetIndex(0);
		// Field names in the first row
		$fields = array('姓名', '组别', '值班时间段');
		$col = 0;
		foreach($fields as $field)
		{
			$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}
		// Fetching the table data
		$row = 2;
		$datas = array(
				array('林伟', 'A', 'MON1'),
				array('林伟彬', 'B', 'TUE2'),
				array('林', 'C', 'MON3')
		);
		foreach($datas as $data)
		{
			$col = 0;
			foreach($fields as $field)
			{
				$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($col, $row, $data[$col]);
				$col++;
			}
			$row++;
		}
		$objPHPExcel -> setActiveSheetIndex(0);
		$objWriter = IOFactory :: createWriter($objPHPExcel, 'Excel5');
		// Sending headers to force the user to download the file
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Products_' . date('dMy') . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter -> save('php://output');
	}

	/**
	 * 清空报名记录
	 */
	public function cleanSignUp() {
		// 检查权限: 3-助理负责人 6-超级管理员
		if ($_SESSION['level'] != 3 && $_SESSION['level'] != 6) {
			// 提示权限不够
			PublicMethod::permissionDenied();
		}

		$this->Moa_nschedule_model->clean();
		echo json_encode(array("status" => TRUE, "msg" => "报名记录已清空"));
		return;
	}

	/**
	 * 导出报名记录到txt文件
	 */
	public function exportToTxt() {
		// 检查权限: 3-助理负责人 6-超级管理员
		// if ($_SESSION['level'] != 3 && $_SESSION['level'] != 6) {
		// 	// 提示权限不够
		// 	PublicMethod::permissionDenied();
		// }

		header('Content-type: application/octet-stream');
		header('Accept-Ranges: bytes');
		header('Content-Disposition: attachment; filename="signup.csv"');
		header('Expires: 0');
		header('Content-Transfer-Encoding: gbk');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		// 从数据库获取所有报名记录（空余时间记录）
		$nschedule_obj_list = $this->Moa_nschedule_model->get_all();
		$weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
		$weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));
		
		$week = array("MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");
		echo mb_convert_encoding("时段, 周一, 周二, 周三, 周四, 周五, 时段, 周六, 周日\r\n", "GBK", "UTF-8");

		for($i = 0; $i < count($weekday_breakpoint)-1 || $i < count($weekend_breakpoint)-1; $i++){
			if($i < count($weekday_breakpoint)-1){
				echo $weekday_breakpoint[$i] . "-" . $weekday_breakpoint[$i+1] . ", ";
				for($j = 0; $j < 5; $j++){
					$current_obj_list = $this->Moa_nschedule_model->get_by_period($week[$j].($i+1));
					for($k = 0; $k < count($current_obj_list); $k++){
						$worker_obj = $this->Moa_worker_model->get($current_obj_list[$k]->wid);
						$user_obj = $this->Moa_user_model->get($worker_obj->uid);
						$name = $user_obj->name;
						$groupname = PublicMethod::translate_group($worker_obj->group);

						echo mb_convert_encoding($name . "(" . $groupname . ") ", "GBK", "UTF-8");
					}
					echo ", ";
				}
			}
			if($i < count($weekend_breakpoint)-1){
				echo $weekend_breakpoint[$i] . "-" . $weekend_breakpoint[$i+1] . ", ";
				for($j = 5; $j < 7; $j++){
					$current_obj_list = $this->Moa_nschedule_model->get_by_period($week[$j].($i+1));
					
					for($k = 0; $k < count($current_obj_list); $k++){
						$worker_obj = $this->Moa_worker_model->get($current_obj_list[$k]->wid);
						$user_obj = $this->Moa_user_model->get($worker_obj->uid);
						$name = $user_obj->name;
						$groupname = PublicMethod::translate_group($worker_obj->group);

						echo mb_convert_encoding($name . "(" . $groupname . ") ", "GBK", "UTF-8");
					}
					echo ", ";
				}
			}
			echo "\r\n";
		}

		// for ($i = 0; $i < count($nschedule_obj_list); $i++) {
		// 	// 获取姓名
		// 	$worker_obj = $this->Moa_worker_model->get($nschedule_obj_list[$i]->wid);
		// 	$user_obj = $this->Moa_user_model->get($worker_obj->uid);
		// 	$name = $user_obj->name;
		// 	// 获取意向组别
		// 	$group = $nschedule_obj_list[$i]->groupid;
		// 	// 获取01表示的报名时间段字符串
		// 	$period = $this->periodConvertTo01($nschedule_obj_list[$i]->period);
		// 	// 写入到txt文件
		// 	echo $name . "," . $group . "," . $period . "\r\n";
		// }

		return;
	}

	public function exportTimePeriodToTxt() {
		// 检查权限: 3-助理负责人 6-超级管理员
		// if ($_SESSION['level'] != 3 && $_SESSION['level'] != 6) {
		// 	// 提示权限不够
		// 	PublicMethod::permissionDenied();
		// }

		header('Content-type: application/octet-stream');
		header('Accept-Ranges: bytes');
		header('Content-Disposition: attachment; filename="timeperiod.txt"');
		header('Expires: 0');
		header('Content-Transfer-Encoding: utf-8');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		// 从数据库获取所有报名记录（空余时间记录）
		$weekday_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint'));
		$weekend_breakpoint = explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint'));
		for ($i = 0; $i < count($weekday_breakpoint); $i++) {
			echo $weekday_breakpoint[$i] . "\r\n";
		}
		echo "---\r\n";
		for ($i = 0; $i < count($weekend_breakpoint); $i++) {
			echo $weekend_breakpoint[$i] . "\r\n";
		}
		return;
	}

	/**
	 * 将报名时间段字符串转换为01表示的字符串
	 * @param $period_str 报名时间段字符串
	 */
	private function periodConvertTo01($period_str) {
        $day_name = PublicMethod::day_name();
        $weekday_len = count(explode(',', $this->Moa_config_model->get_by_name('weekday_breakpoint')));
        $weekend_len = count(explode(',', $this->Moa_config_model->get_by_name('weekend_breakpoint')));
		$res_arr = array();
		$period_arr = explode(",", $period_str);
        for($j = 0; $j < 5; ++$j) {
            for ($i = 1; $i <= $weekday_len - 1; $i++) {
                if (in_array($day_name[$j] . $i, $period_arr)) {
                    $res_arr[] = "1";
                } else {
                    $res_arr[] = "0";
                }
            }
        }
        for($j = 5; $j < 7; ++$j) {
            for ($i = 1; $i <= $weekend_len - 1; $i++) {
                if (in_array($day_name[$j] . $i, $period_arr)) {
                    $res_arr[] = "1";
                } else {
                    $res_arr[] = "0";
                }
            }
        }
		$res_str = implode(",", $res_arr);
		return $res_str;
	}

	/**
	 * 将假期／考试周的空闲时间，写入数据库
	 */
	public function writeHolidaySchedule() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$wid = $this->Moa_worker_model->get_wid_by_uid($uid);

			$dateList 	= $_POST['date'];
			$hsid 		= $_POST['hsid'];
			$res = $this->Moa_scheduleduty_model-> addDateList($wid, $hsid, $dateList);

			if(!$res) {
				echo json_encode(array("status" => FALSE, "msg" => "更新信息失败"));
				return;
			}

			echo json_encode(array("status" => TRUE, "msg" => "更新信息成功"));

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/**
	 * 获取用户的假期/考试周空闲时间，写入数据库
	 */

	public function userSchedule() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$wid = $this->Moa_worker_model->get_wid_by_uid($uid);

			$holidaySchedule = $this->Moa_holidayschedule_model->latest();
			$holidaySchedule = $holidaySchedule[0];
			$hsid 		 	 = $holidaySchedule->hsid;

			$res = $this->Moa_scheduleduty_model->get_by_wid_and_hsid($wid, $hsid);

			if(!$res) {
				echo json_encode(array("status" => FALSE, "msg" => "获取信息失败"));
				return;
			}

			echo json_encode(array("status" => TRUE, "data" => $res, "msg" => "获取信息成功"));

		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

}
