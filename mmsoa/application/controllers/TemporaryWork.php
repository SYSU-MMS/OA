<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 代班记录控制类
 * @author 高少彬
 * @description 参考DailyCheck
 */
Class TemporaryWork extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_check_model');
		$this->load->model('Moa_attend_model');
		$this->load->model('Moa_room_model');
		$this->load->model('Moa_problem_model');
		$this->load->model('Moa_school_term_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}


	/**
	 * 查看今日代班记录
	 */
	public function temporaryWork() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}

			// 取出所有处于非删除状态的用户
			$common_worker = $this->Moa_user_model->get_all();

			for ($i = 0; $i < count($common_worker); $i++) {
				$uid_list[$i] = $common_worker[$i]->uid;
				$name_list[$i] = $common_worker[$i]->name;
				$wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
				$wid_hash_name[$wid_list[$i]] = $name_list[$i];
			}

			$data['name_list'] 			= $name_list;
			$data['wid_list'] 			= $wid_list;

			// 周一为一周的第一天
            $today = date("Y-m-d H:i:s");
            $term = $this->Moa_school_term_model->get_term($today);
            if(count($term) == 0) {
                echo json_encode(array("status" => FALSE, "msg" => "没有本学期时间信息，请联系管理员"));
                return;
            }
			$weekcount = PublicMethod::get_week($term[0]->termbeginstamp, $today);

			// 1-周一  2-周二  ... 6-周六  7-周日
			$weekday = date("w") == 0 ? 7 : date("w");
			$weekday_desc = PublicMethod::translate_weekday($weekday);

			/*
			 * 今日代班记录
			 */
			// 获取今日所有代班记录

			// 取出所有代班记录
			// 返回字段：attend_id, wid , timestamp, type, substituteFor, applyid
			$m_check_obj = $this->Moa_attend_model->get_by_isSubstitute();

			// 处理数据库返回数据，得到代班记录列表
			// if ($m_check_obj != FALSE){
			//
			// 	$substituteList = $this->dealSubstituteList($m_check_obj, $wid_hash_name);
			// }
			// else
				$substituteList = array();

				// 装载前端所需数据
				$data['substituteList'] = $substituteList;
				$this->load->view('view_temporary_work', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/**
	 * 查找历史代班记录
	 */
	public function historyTemporaryWork() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}

			if (isset($_POST['start_time']) && isset($_POST['end_time'])){

				$post_start_time = $_POST['start_time'];
				$post_end_time = $_POST['end_time'];
				$post_actual_wid = $_POST['actual_wid'];

				date_default_timezone_set('PRC');
				// 字符串转时间格式
				$query_start_time = date('Y-m-d H:i:s', strtotime($post_start_time));
				$query_end_time = date('Y-m-d H:i:s', strtotime($post_end_time));

				$actual_wid = $post_actual_wid;
				if ($post_actual_wid == -1)
					$actual_wid = NULL;

				// 取出所有代班记录
				// 返回字段：attend_id, wid , timestamp, type, substituteFor, applyid
				$m_check_obj = $this->Moa_attend_model->get_by_time_and_wid($query_start_time, $query_end_time, $actual_wid);

				if(count($m_check_obj) == 0) {
					echo json_encode(array("status" => FALSE, "msg" => "该查询结果为空"));
					return;
				}
				if ($m_check_obj != FALSE) {

					// 取出所有处于非删除状态的用户
					$common_worker = $this->Moa_user_model->get_all();

					for ($i = 0; $i < count($common_worker); $i++) {
						$uid_list[$i] = $common_worker[$i]->uid;
						$name_list[$i] = $common_worker[$i]->name;
						$wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
						$wid_hash_name[$wid_list[$i]] = $name_list[$i];
					}

					// 处理数据库返回数据，得到代班记录列表
					$substituteList = $this->dealSubstituteList($m_check_obj, $wid_hash_name);

					$data['substituteList'] = $substituteList;

					echo json_encode(array("status" => TRUE, "msg" => "查找成功", "data" => $data));
					return;
				}
			}

			echo json_encode(array("status" => FALSE, "msg" => "查找失败"));
			return;
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/**
	 * 根据条件，选择性导出excel
	 */

	 public function exportSubstituteExcel() {
		 if (isset($_SESSION['user_id'])) {
			 // 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			 if ($_SESSION['level'] <= 0) {
				 // 提示权限不够
				 PublicMethod::permissionDenied();
			 }

			 if (isset($_POST['start_time']) && isset($_POST['end_time'])){

				 $post_start_time = $_POST['start_time'];
				 $post_end_time = $_POST['end_time'];
				 $post_actual_wid = $_POST['actual_wid'];

				 date_default_timezone_set('PRC');
				 // 字符串转时间格式
				 $query_start_time = date('Y-m-d H:i:s', strtotime($post_start_time));
				 $query_end_time = date('Y-m-d H:i:s', strtotime($post_end_time));

				 $actual_wid = $post_actual_wid;
				 if ($post_actual_wid == -1)
					 $actual_wid = NULL;

				 // 取出所有代班记录
				 // 返回字段：attend_id, wid , timestamp, type, substituteFor, applyid
				 $m_check_obj = $this->Moa_attend_model->get_by_time_and_wid($query_start_time, $query_end_time, $actual_wid);

				 if(count($m_check_obj) == 0) {
					 echo json_encode(array("status" => FALSE, "msg" => "该查询结果为空"));
					 return;
				 }
				 if ($m_check_obj != FALSE) {

					 // 取出所有处于非删除状态的用户
					 $common_worker = $this->Moa_user_model->get_all();

					 for ($i = 0; $i < count($common_worker); $i++) {
						 $uid_list[$i] = $common_worker[$i]->uid;
						 $name_list[$i] = $common_worker[$i]->name;
						 $wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
						 $wid_hash_name[$wid_list[$i]] = $name_list[$i];
					 }

					 // 处理数据库返回数据，得到代班记录列表
					 $substituteList = $this->dealSubstituteList($m_check_obj, $wid_hash_name);

					 $this->createExcel($substituteList);

					//  echo json_encode(array("status" => TRUE, "msg" => "导出Excel成功"));
					 return;
				 }
			 }

			 echo json_encode(array("status" => FALSE, "msg" => "导出Excel失败"));
			 return;
		 } else {
			 // 未登录的用户请先登录
			 PublicMethod::requireLogin();
		 }
	 }

	 /*  生成excel文件之后，直接下载该文件
	 */

	 public function getExcel() {
		 	 $this->load->helper('download');
			 $name = $this->getFilename();
			 force_download($name, NULL);
	 }

	function dealSubstituteList($m_check_obj, $wid_hash_name) {

		$type_name = array("值班", "常检", "周检", "拍摄");

		$substituteList = array();
		$substituteObj = array();

		for($i = 0; $i < count($m_check_obj); $i++) {

			$substituteFor_wid 			 = $m_check_obj[$i]->substituteFor;
			$substituteObj['m_type'] = $type_name[$m_check_obj[$i]->type];
			$substituteObj['m_time'] = $m_check_obj[$i]->timestamp;

			// wid_hash_name用于查找wid对应的名字
			if($m_check_obj[$i]->wid != NULL)
					$substituteObj['m_name'] = $wid_hash_name[$m_check_obj[$i]->wid];
			else
					$substituteObj['m_name'] = "信息为空";

			if($substituteFor_wid != NULL)
					$substituteObj['m_substituteFor']  = $wid_hash_name[$substituteFor_wid];
			else
					$substituteObj['m_substituteFor'] = "信息为空";

			$substituteList[$i] = $substituteObj;
		}

		return $substituteList;
	}


	/* 用于创建excel，等待导出	*/

  function createExcel($substituteList) {
			// Starting the PHPExcel library
			$this -> load -> library('PHPExcel');
			$this -> load -> library('PHPExcel/IOFactory');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel -> getProperties() -> setTitle("export") -> setDescription("none");

			$objPHPExcel -> setActiveSheetIndex(0);
			// Field names in the first row
			$fields = array('序号', '代班人', '被代班人', '代班类型', '时间');
			$col = 0;
			foreach($fields as $field) {
				$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($col, 1, $field);
				$col++;
			}
			// Fetching the table data
			for ($i = 0; $i < count($substituteList); $i++) {
					$substitute = $substituteList[$i];
					$row = $i + 2;
					$excelData = array($row-1, $substitute['m_name'], $substitute['m_substituteFor'], $substitute['m_type'], $substitute['m_time']);
					for($col = 0; $col < count($excelData); $col++) {
						$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($col, $row, $excelData[$col]);
					}

			}
			$objPHPExcel -> setActiveSheetIndex(0);
			$objWriter = IOFactory :: createWriter($objPHPExcel, 'Excel5');
			// Sending headers to force the user to download the file


			$filename = $this->getFilename();
			$objWriter -> save($filename);
			echo json_encode(array("status" => TRUE, "msg" => "生成Excel成功"));
			return;
		}

		function getFilename() {
			return "./assets/excel/TemporaryWork.xls";
		}

}
