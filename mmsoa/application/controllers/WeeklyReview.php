<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 周检工作审查控制类
 * @author 伟
 */
Class WeeklyReview extends CI_Controller {
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
	 * 查看周检记录
	 */
	public function weeklyReview() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			// 周一为一周的第一天
			$weekcount = PublicMethod::cal_week();
	
			// 已完成早检助理人数
			$w_count = 0;
			$data['w_count'] = $w_count;
				
			// 获取本周所有周检记录
			$check_type = 3;
			$w_check_obj = $this->moa_check_model->get_by_weekcount_type($weekcount, $check_type);
			if ($w_check_obj != FALSE) {
				// 获取已完成周检的助理名单
				$w_wid_list = array();
				$w_prob_list = array();
				$w_time_list = array();
				$w_room_list = array();
				$w_name_list = array();
				$w_day_list = array();
				$w_lamp_list = array();
	
				for ($i = 0; $i < count($w_check_obj); $i++) {
					$w_tmp_wid = $w_check_obj[$i]->actual_wid;
					$w_wid_list[$w_count] = $w_tmp_wid;
					$w_day_list[$w_count] = PublicMethod::translate_weekday($w_check_obj[$i]->weekday);
					$w_time_list[$w_count] = $w_check_obj[$i]->timestamp;
					$w_lamp_list[$w_count] = $w_check_obj[$i]->light;
					$w_worker_obj = $this->moa_worker_model->get($w_tmp_wid);
					$w_user_obj = $this->moa_user_model->get($w_worker_obj->uid);
					$w_name_list[$w_count] = $w_user_obj->name;
					$w_room_obj = $this->moa_room_model->get($w_check_obj[$i]->roomid);
					$w_room_list[$w_count] = $w_room_obj->room;
						
					// 课室有故障，添加故障说明到$w_prob_list
					$w_prob_list[$w_count] = '';
					if ($w_check_obj[$i]->isChecked == 2) {
						$w_pro_obj = $this->moa_problem_model->get($w_check_obj[$i]->problemid);
						$w_prob_list[$w_count] = $w_prob_list[$w_count] . $w_pro_obj->description;
					}
						
					$w_count++;
				}
	
				// 装载前端所需数据
				$data['w_count'] = $w_count;
				$data['w_weekcount'] = $weekcount;
				$data['w_day_list'] = $w_day_list;
				$data['w_name_list'] = $w_name_list;
				$data['w_room_list'] = $w_room_list;
				$data['w_prob_list'] = $w_prob_list;
				$data['w_lamp_list'] = $w_lamp_list;
				$data['w_time_list'] = $w_time_list;
			}
	
			$this->load->view('view_weekly_review', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	
}