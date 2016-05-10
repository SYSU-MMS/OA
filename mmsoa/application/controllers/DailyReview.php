<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 常检工作审查控制类
 * @author 伟
 */
Class DailyReview extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('moa_user_model');
		$this->load->model('moa_worker_model');
		$this->load->model('moa_check_model');
		$this->load->model('moa_room_model');
		$this->load->model('moa_problem_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	public function index() {
		
	}
	
	/**
	 * 查看常检记录
	 */
	public function dailyReview() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			// 周一为一周的第一天
			$weekcount = PublicMethod::cal_week();
				
			// 1-周一  2-周二  ... 6-周六  7-周日
			$weekday = date("w") == 0 ? 7 : date("w");
			$weekday_desc = PublicMethod::translate_weekday($weekday);
				
			// 已完成早检助理人数
			$m_count = 0;
			$data['m_count'] = $m_count;
				
			// 已完成午检助理人数
			$n_count = 0;
			$data['n_count'] = $n_count;
				
			// 已完成晚检助理人数
			$e_count = 0;
			$data['e_count'] = $e_count;
				
			/*
			 * 今日早检记录
			 */
			// 获取今日所有早检记录
			$check_type = 0;
			$m_check_obj = $this->moa_check_model->get_by_week_type($weekcount, $weekday, $check_type);
			if ($m_check_obj != FALSE) {
				// 获取已完成早检的助理名单
				$m_wid_list = array();
				$m_prob_list = array();
				$m_time_list = array();
				$m_room_list = array();
				$m_name_list = array();
	
				$m_tmp_wid = $m_check_obj[0]->actual_wid;
				$m_wid_list[$m_count] = $m_tmp_wid;
				$m_prob_list[$m_count] = '';
				$m_time_list[$m_count] = $m_check_obj[0]->timestamp;
	
				// 获取常检课室
				$m_worker_obj = $this->moa_worker_model->get($m_tmp_wid);
				$m_room_list[$m_count] = $m_worker_obj->classroom;
	
				// 获取姓名
				$m_user_obj = $this->moa_user_model->get($m_worker_obj->uid);
				$m_name_list[$m_count] = $m_user_obj->name;
	
				for ($i = 0; $i < count($m_check_obj); $i++) {
					// 不同的wid,添加相关信息
					if ($m_check_obj[$i]->actual_wid != $m_tmp_wid) {
						$m_count++;
						$m_tmp_wid = $m_check_obj[$i]->actual_wid;
						$m_wid_list[$m_count] = $m_tmp_wid;
						$m_prob_list[$m_count] = '';
						$m_time_list[$m_count] = $m_check_obj[$i]->timestamp;
						$m_worker_obj = $this->moa_worker_model->get($m_tmp_wid);
						$m_room_list[$m_count] = $m_worker_obj->classroom;
						$m_user_obj = $this->moa_user_model->get($m_worker_obj->uid);
						$m_name_list[$m_count] = $m_user_obj->name;
					}
					// 课室有故障，添加故障说明到$m_prob_list
					if ($m_check_obj[$i]->isChecked == 2) {
						$m_room_obj = $this->moa_room_model->get($m_check_obj[$i]->roomid);
						$m_pro_obj = $this->moa_problem_model->get($m_check_obj[$i]->problemid);
						$m_prob_list[$m_count] = $m_prob_list[$m_count] . '<b>' . $m_room_obj->room . '</b> ' .
								$m_pro_obj->description . ' <br />';
					}
				}
	
				// 装载前端所需数据
				$data['m_count'] = $m_count + 1;
				$data['m_weekcount'] = $weekcount;
				$data['m_weekday'] = $weekday_desc;
				$data['m_name_list'] = $m_name_list;
				$data['m_room_list'] = $m_room_list;
				$data['m_prob_list'] = $m_prob_list;
				$data['m_time_list'] = $m_time_list;
			}
				
				
			/*
			 * 今日午检记录
			 */
			// 获取今日所有午检记录
			$check_type = 1;
			$n_check_obj = $this->moa_check_model->get_by_week_type($weekcount, $weekday, $check_type);
			if ($n_check_obj != FALSE) {
				// 获取已完成早检的助理名单
				$n_wid_list = array();
				$n_prob_list = array();
				$n_time_list = array();
				$n_room_list = array();
				$n_name_list = array();
	
				$n_tmp_wid = $n_check_obj[0]->actual_wid;
				$n_wid_list[$n_count] = $n_tmp_wid;
				$n_prob_list[$n_count] = '';
				$n_time_list[$n_count] = $n_check_obj[0]->timestamp;
	
				// 获取常检课室
				$n_worker_obj = $this->moa_worker_model->get($n_tmp_wid);
				$n_room_list[$n_count] = $n_worker_obj->classroom;
	
				// 获取姓名
				$n_user_obj = $this->moa_user_model->get($n_worker_obj->uid);
				$n_name_list[$n_count] = $n_user_obj->name;
	
				for ($j = 0; $j < count($n_check_obj); $j++) {
					// 不同的wid,添加相关信息
					if ($n_check_obj[$j]->actual_wid != $n_tmp_wid) {
						$n_count++;
						$n_tmp_wid = $n_check_obj[$j]->actual_wid;
						$n_wid_list[$n_count] = $n_tmp_wid;
						$n_prob_list[$n_count] = '';
						$n_time_list[$n_count] = $n_check_obj[$j]->timestamp;
						$n_worker_obj = $this->moa_worker_model->get($n_tmp_wid);
						$n_room_list[$n_count] = $n_worker_obj->classroom;
						$n_user_obj = $this->moa_user_model->get($n_worker_obj->uid);
						$n_name_list[$n_count] = $n_user_obj->name;
					}
					// 课室有故障，添加故障说明到$n_prob_list
					if ($n_check_obj[$j]->isChecked == 2) {
						$n_room_obj = $this->moa_room_model->get($n_check_obj[$j]->roomid);
						$n_pro_obj = $this->moa_problem_model->get($n_check_obj[$j]->problemid);
						$n_prob_list[$n_count] = $n_prob_list[$n_count] . '<b>' . $n_room_obj->room . '</b> ' .
								$n_pro_obj->description . ' <br />';
					}
				}
	
				// 装载前端所需数据
				$data['n_count'] = $n_count + 1;
				$data['n_weekcount'] = $weekcount;
				$data['n_weekday'] = $weekday_desc;
				$data['n_name_list'] = $n_name_list;
				$data['n_room_list'] = $n_room_list;
				$data['n_prob_list'] = $n_prob_list;
				$data['n_time_list'] = $n_time_list;
			}
				
			/*
			 * 今日晚检记录
			 */
			// 获取今日所有晚检记录
			$check_type = 2;
			$e_check_obj = $this->moa_check_model->get_by_week_type($weekcount, $weekday, $check_type);
			if ($e_check_obj != FALSE) {
				// 获取已完成早检的助理名单
				$e_wid_list = array();
				$e_prob_list = array();
				$e_time_list = array();
				$e_room_list = array();
				$e_name_list = array();
	
				$e_tmp_wid = $e_check_obj[0]->actual_wid;
				$e_wid_list[$e_count] = $e_tmp_wid;
				$e_prob_list[$e_count] = '';
				$e_time_list[$e_count] = $e_check_obj[0]->timestamp;
	
				// 获取常检课室
				$e_worker_obj = $this->moa_worker_model->get($e_tmp_wid);
				$e_room_list[$e_count] = $e_worker_obj->classroom;
	
				// 获取姓名
				$e_user_obj = $this->moa_user_model->get($e_worker_obj->uid);
				$e_name_list[$e_count] = $e_user_obj->name;
	
				for ($k = 0; $k < count($e_check_obj); $k++) {
					// 不同的wid,添加相关信息
					if ($e_check_obj[$k]->actual_wid != $e_tmp_wid) {
						$e_count++;
						$e_tmp_wid = $e_check_obj[$k]->actual_wid;
						$e_wid_list[$e_count] = $e_tmp_wid;
						$e_prob_list[$e_count] = '';
						$e_time_list[$e_count] = $e_check_obj[$k]->timestamp;
						$e_worker_obj = $this->moa_worker_model->get($e_tmp_wid);
						$e_room_list[$e_count] = $e_worker_obj->classroom;
						$e_user_obj = $this->moa_user_model->get($e_worker_obj->uid);
						$e_name_list[$e_count] = $e_user_obj->name;
					}
					// 课室有故障，添加故障说明到$e_prob_list
					if ($e_check_obj[$k]->isChecked == 2) {
						$e_room_obj = $this->moa_room_model->get($e_check_obj[$k]->roomid);
						$e_pro_obj = $this->moa_problem_model->get($e_check_obj[$k]->problemid);
						$e_prob_list[$e_count] = $e_prob_list[$e_count] . '<b>' . $e_room_obj->room . '</b> ' .
								$e_pro_obj->description . ' <br />';
					}
				}
	
				// 装载前端所需数据
				$data['e_count'] = $e_count + 1;
				$data['e_weekcount'] = $weekcount;
				$data['e_weekday'] = $weekday_desc;
				$data['e_name_list'] = $e_name_list;
				$data['e_room_list'] = $e_room_list;
				$data['e_prob_list'] = $e_prob_list;
				$data['e_time_list'] = $e_time_list;
			}
				
			$this->load->view('view_daily_review', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	
}