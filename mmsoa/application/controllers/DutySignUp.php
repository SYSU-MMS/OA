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
		$this->load->model('moa_user_model');
		$this->load->model('moa_worker_model');
		$this->load->model('moa_nschedule_model');
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
				
			$this->load->view('view_duty_signup');
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
			$uid = $_SESSION['user_id'];
			$wid = $this->moa_worker_model->get_wid_by_uid($uid);
			
			$groupid = '';
			if (isset($_POST['groupid'])) {
				$groupid = $_POST['groupid'];
			}
			
			// 值班时间段，以“,”分隔
			$periods = '';
				
			for($i = 1; $i <= 6; $i++) {
				if(isset($_POST['MON'.$i])) {
					if($periods != '') {
						$periods = $periods . ',';
					}
					$periods = $periods . 'MON' . $i;
				}
			}
			for($i = 1; $i <= 6; $i++) {
				if(isset($_POST['TUE'.$i])) {
					if($periods != '') {
						$periods = $periods . ',';
					}
					$periods = $periods . 'TUE' . $i;
				}
			}
			for($i = 1; $i <= 6; $i++) {
				if(isset($_POST['WED'.$i])) {
					if($periods != '') {
						$periods = $periods . ',';
					}
					$periods = $periods . 'WED' . $i;
				}
			}
			for($i = 1; $i <= 6; $i++) {
				if(isset($_POST['THU'.$i])) {
					if($periods != '') {
						$periods = $periods . ',';
					}
					$periods = $periods . 'THU' . $i;
				}
			}
			for($i = 1; $i <= 6; $i++) {
				if(isset($_POST['FRI'.$i])) {
					if($periods != '') {
						$periods = $periods . ',';
					}
					$periods = $periods . 'FRI' . $i;
				}
			}
			for($i = 1; $i <= 3; $i++) {
				if(isset($_POST['SAT'.$i])) {
					if($periods != '') {
						$periods = $periods . ',';
					}
					$periods = $periods . 'SAT' . $i;
				}
			}
			for($i = 1; $i <= 3; $i++) {
				if(isset($_POST['SUN'.$i])) {
					if($periods != '') {
						$periods = $periods . ',';
					}
					$periods = $periods . 'SUN' . $i;
				}
			}

			$ns_paras['wid'] = $wid;
			$ns_paras['groupid'] = $groupid;
			$ns_paras['period'] = $periods;
			
			// 写入数据库
			if ($periods != '') {
				$schedule_obj_list = $this->moa_nschedule_model->get($wid);
				// 该助理已报过名，则删除原记录
				if (count($schedule_obj_list) != 0) {
					$delete_res = $this->moa_nschedule_model->delete($schedule_obj_list[0]->nsid);
					if ($delete_res == 0) {
						//echo json_encode(array("status" => FALSE, "msg" => "你之前报过名，请联系助理负责人"));
						echo("提交失败");
						return;
					}
				}

				// 增加新记录
				$nsid = $this->moa_nschedule_model->add($ns_paras);
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
	 * 导出报名情况到txt文件
	 */
	public function exportToTxt() {
		header('Content-type: application/octet-stream');
		header('Accept-Ranges: bytes');
		header('Content-Disposition: attachment; filename="test.txt"');
		header('Expires: 0');
		header('Content-Transfer-Encoding: utf-8');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		
		// 从数据库获取所有报名记录（空余时间记录）
		$nschedule_obj_list = $this->moa_nschedule_model->getAll();
		for ($i = 0; $i < count($nschedule_obj_list); $i++) {
			// 获取姓名
			$worker_obj = $this->moa_worker_model->get($nschedule_obj_list[$i]->wid);
			$user_obj = $this->moa_user_model->get($worker_obj->uid);
			$name = $user_obj->name;
			// 获取意向组别
			$group = $nschedule_obj_list[$i]->groupid;
			// 获取01表示的报名时间段字符串
			$period = $this->periodConvertTo01($nschedule_obj_list[$i]->period);
			// 写入到txt文件
			echo $name . "," . $group . "," . $period . "\r\n";
		}
		return;
	}
	
	/**
	 * 将报名时间段字符串转换为01表示的字符串
	 * @param $period_str 报名时间段字符串
	 */
	private function periodConvertTo01($period_str) {
		$res_arr = array();
		$period_arr = explode(",", $period_str);
		// MON1~MON6
		for ($i = 1; $i <= 6; $i++) {
			if (in_array("MON".$i, $period_arr)) {
				$res_arr[] = "1";
			} else {
				$res_arr[] = "0";
			}
		}
		// TUE1~TUE6
		for ($i = 1; $i <= 6; $i++) {
			if (in_array("TUE".$i, $period_arr)) {
				$res_arr[] = "1";
			} else {
				$res_arr[] = "0";
			}
		}
		// WED1~WED6
		for ($i = 1; $i <= 6; $i++) {
			if (in_array("WED".$i, $period_arr)) {
				$res_arr[] = "1";
			} else {
				$res_arr[] = "0";
			}
		}
		// THU1~THU6
		for ($i = 1; $i <= 6; $i++) {
			if (in_array("THU".$i, $period_arr)) {
				$res_arr[] = "1";
			} else {
				$res_arr[] = "0";
			}
		}
		// FRI1~FRI6
		for ($i = 1; $i <= 6; $i++) {
			if (in_array("FRI".$i, $period_arr)) {
				$res_arr[] = "1";
			} else {
				$res_arr[] = "0";
			}
		}
		// SAT1~SAT3
		for ($i = 1; $i <= 3; $i++) {
			if (in_array("SAT".$i, $period_arr)) {
				$res_arr[] = "1";
			} else {
				$res_arr[] = "0";
			}
		}
		// SUN1~SUN3
		for ($i = 1; $i <= 3; $i++) {
			if (in_array("SUN".$i, $period_arr)) {
				$res_arr[] = "1";
			} else {
				$res_arr[] = "0";
			}
		}
		$res_str = implode(",", $res_arr);
		return $res_str;
	}
	
}