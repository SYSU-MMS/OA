<<<<<<< HEAD
<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 值班工作审查控制类
 * @author 伟
 */
Class DutyReview extends CI_Controller {
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
	
	public function index() {
		
	}
	
	/**
	 * 查看值班记录
	 */
	public function dutyReview() {
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
				
			// 已完成值班助理人数
			$d_count = 0;
			$data['d_count'] = $d_count;
				
			// 获取今日所有值班记录
			// 考勤类型：0 - 值班 1 - 早检 2 - 午检 3 - 晚检 4 - 周检
			$attend_type = 0;
			$d_attend_obj = $this->Moa_attend_model->get_by_week_type($weekcount, $weekday, $attend_type);
			if ($d_attend_obj != FALSE) {
				// 获取已完成值班的助理名单
				$d_wid_list = array();
				$d_time_list = array();
				$d_duration_list = array();
				$d_name_list = array();
				$d_sub_list = array();
					
				for ($i = 0; $i < count($d_attend_obj); $i++) {
					$d_tmp_wid = $d_attend_obj[$i]->wid;
					$d_wid_list[$d_count] = $d_tmp_wid;
					$d_time_list[$d_count] = $d_attend_obj[$i]->timestamp;
					$d_tmp_period = $d_attend_obj[$i]->dutyPeriod;
					$d_tmp_duration = PublicMethod::get_duty_duration($d_tmp_period);
					$d_tmp_hours = PublicMethod::get_working_hours($d_tmp_period);
					$d_duration_list[$d_count] = '<b>' . $d_tmp_duration . '</b> &nbsp;&nbsp;' . $d_tmp_hours . '小时';
						
					// 获取姓名
					$d_worker_obj = $this->Moa_worker_model->get($d_tmp_wid);
					$d_user_obj = $this->Moa_user_model->get($d_worker_obj->uid);
					$d_name_list[$d_count] = $d_user_obj->name;
	
					// 若有代班，添加代班说明到$d_sub_list
					$d_sub_list[$d_count] = '';
					// 是否代班： 0 - 否  1 - 是
					if ($d_attend_obj[$i]->isSubstitute == 1) {
						// 获取被代班助理姓名
						$d_subed_wid = $d_attend_obj[$i]->substituteFor;
						$d_subed_worker_obj = $this->Moa_worker_model->get($d_subed_wid);
						$d_subed_user_obj = $this->Moa_user_model->get($d_subed_worker_obj->uid);
						$d_subed_tmp_name = $d_subed_user_obj->name;
						$d_sub_list[$d_count] = '代 ' . $d_subed_tmp_name;
					}
	
					$d_count++;
				}
					
				// 装载前端所需数据
				$data['d_count'] = $d_count;
				$data['d_weekcount'] = $weekcount;
				$data['d_weekday'] = $weekday;
				$data['d_name_list'] = $d_name_list;
				$data['d_duration_list'] = $d_duration_list;
				$data['d_sub_list'] = $d_sub_list;
				$data['d_time_list'] = $d_time_list;
			}
				
			$this->load->view('view_duty_review', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	
=======
<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 值班工作审查控制类
 * @author 伟
 */
Class DutyReview extends CI_Controller {
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
	
	public function index() {
		
	}
	
	/**
	 * 查看值班记录
	 */
	public function dutyReview() {
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
				
			// 已完成值班助理人数
			$d_count = 0;
			$data['d_count'] = $d_count;
				
			// 获取今日所有值班记录
			// 考勤类型：0 - 值班 1 - 早检 2 - 午检 3 - 晚检 4 - 周检
			$attend_type = 0;
			$d_attend_obj = $this->Moa_attend_model->get_by_week_type($weekcount, $weekday, $attend_type);
			if ($d_attend_obj != FALSE) {
				// 获取已完成值班的助理名单
				$d_wid_list = array();
				$d_time_list = array();
				$d_duration_list = array();
				$d_name_list = array();
				$d_sub_list = array();
					
				for ($i = 0; $i < count($d_attend_obj); $i++) {
					$d_tmp_wid = $d_attend_obj[$i]->wid;
					$d_wid_list[$d_count] = $d_tmp_wid;
					$d_time_list[$d_count] = $d_attend_obj[$i]->timestamp;
					$d_tmp_period = $d_attend_obj[$i]->dutyPeriod;
					$d_tmp_duration = PublicMethod::get_duty_duration($d_tmp_period);
					$d_tmp_hours = PublicMethod::get_working_hours($d_tmp_period);
					$d_duration_list[$d_count] = '<b>' . $d_tmp_duration . '</b> &nbsp;&nbsp;' . $d_tmp_hours . '小时';
						
					// 获取姓名
					$d_worker_obj = $this->Moa_worker_model->get($d_tmp_wid);
					$d_user_obj = $this->Moa_user_model->get($d_worker_obj->uid);
					$d_name_list[$d_count] = $d_user_obj->name;
	
					// 若有代班，添加代班说明到$d_sub_list
					$d_sub_list[$d_count] = '';
					// 是否代班： 0 - 否  1 - 是
					if ($d_attend_obj[$i]->isSubstitute == 1) {
						// 获取被代班助理姓名
						$d_subed_wid = $d_attend_obj[$i]->substituteFor;
						$d_subed_worker_obj = $this->Moa_worker_model->get($d_subed_wid);
						$d_subed_user_obj = $this->Moa_user_model->get($d_subed_worker_obj->uid);
						$d_subed_tmp_name = $d_subed_user_obj->name;
						$d_sub_list[$d_count] = '代 ' . $d_subed_tmp_name;
					}
	
					$d_count++;
				}
					
				// 装载前端所需数据
				$data['d_count'] = $d_count;
				$data['d_weekcount'] = $weekcount;
				$data['d_weekday'] = $weekday;
				$data['d_name_list'] = $d_name_list;
				$data['d_duration_list'] = $d_duration_list;
				$data['d_sub_list'] = $d_sub_list;
				$data['d_time_list'] = $d_time_list;
			}
				
			$this->load->view('view_duty_review', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	
>>>>>>> abnormal
}