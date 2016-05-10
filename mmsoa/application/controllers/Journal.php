<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 坐班日志录入控制类
 * @author 伟
 */
Class Journal extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('moa_user_model');
		$this->load->model('moa_worker_model');
		$this->load->model('moa_leaderreport_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	public function index() {
		
	}
	
	/**
	 * 发布坐班日志
	 */
	public function writeJournal() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			// 取所有普通助理的wid与name, level: 0-普通助理  1-组长  2-负责人助理  3-助理负责人  4-管理员  5-办公室负责人
			$level = 0;
			$common_worker = $this->moa_user_model->get_by_level($level);
				
			for ($i = 0; $i < count($common_worker); $i++) {
				$uid_list[$i] = $common_worker[$i]->uid;
				$name_list[$i] = $common_worker[$i]->name;
				$wid_list[$i] = $this->moa_worker_model->get_wid_by_uid($uid_list[$i]);
			}
			$data['name_list'] = $name_list;
			$data['wid_list'] = $wid_list;
			$this->load->view('view_write_journal', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/**
	 * 查看坐班日志
	 */
	public function readJournal() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			// 获取最近的一篇坐班日志
			$data['leader_name'] = '';
			$data['group'] = '';
			$data['timestamp'] = '';
			$data['weekcount'] = '';
			$data['weekday'] = '';
			$data['body_list'] = array('', '', '', '', '', '');
			$data['best_list'] = array();
			$data['bad_list'] = array();
				
			// state： 0 - 正常  1- 已删除
			$state = 0;
			$report_obj = $this->moa_leaderreport_model->get_lasted($state);
			// 正确获取到所需记录
			if ($report_obj) {
				$data['group'] = PublicMethod::translate_group($report_obj->group);
				$data['timestamp'] = $report_obj->timestamp;
				$data['weekcount'] = $report_obj->weekcount;
				$data['weekday'] = PublicMethod::translate_weekday($report_obj->weekday);
				$body_list = explode(' ## ', $report_obj->body);
				$data['body_list'] = $body_list;
	
				// 获取组长姓名
				$leader_wid = $report_obj->wid;
				$r_worker_obj = $this->moa_worker_model->get($leader_wid);
				$r_user_obj = $this->moa_user_model->get($r_worker_obj->uid);
				$data['leader_name'] = $r_user_obj->name;
	
				// 获取优秀助理姓名列表
				$best_list = array();
				if (!is_null($report_obj->bestlist)) {
					$best_wid_list = explode(',', $report_obj->bestlist);
					for ($i = 0; $i < count($best_wid_list); $i++) {
						$best_wid = $best_wid_list[$i];
						$best_worker_obj = $this->moa_worker_model->get($best_wid);
						$best_user_obj = $this->moa_user_model->get($best_worker_obj->uid);
						$best_list[$i] = $best_user_obj->name;
					}
				}
				$data['best_list'] = $best_list;
	
				// 获取异常助理姓名列表
				$bad_list = array();
				if (!is_null($report_obj->badlist)) {
					$bad_wid_list = explode(',', $report_obj->badlist);
					for ($j = 0; $j < count($bad_wid_list); $j++) {
						$bad_wid = $bad_wid_list[$j];
						$bad_worker_obj = $this->moa_worker_model->get($bad_wid);
						$bad_user_obj = $this->moa_user_model->get($bad_worker_obj->uid);
						$bad_list[$j] = $bad_user_obj->name;
					}
				}
				$data['bad_list'] = $bad_list;
			}
				
			$this->load->view('view_read_journal', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/*
	 * 发布坐班日志(录入)
	 */
	public function writeJournalIn() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$wid = $this->moa_worker_model->get_wid_by_uid($uid);
			if (isset($_POST['journal_body'])) {
				$journal_paras['wid'] = $wid;
				
				// state： 0-正常  1-已删除
				$journal_paras['state'] = 0;
				
				// group：0 - N  1 - A  2 - B
				$journal_paras['group'] = 0;
				if (isset($_POST['group'])) {
					$journal_paras['group'] = $_POST['group'];
				}
				
				// 周一为一周的第一天
				$journal_paras['weekcount'] = PublicMethod::cal_week();
	
				// 1-周一  2-周二  ... 6-周六  7-周日
				$journal_paras['weekday'] = date("w") == 0 ? 7 : date("w");
				
				$journal_paras['timestamp'] = date('Y-m-d H:i:s');
				
				// 避免journal_body中含有指定分割字符串' ## '
				foreach ($_POST['journal_body'] as &$part) {
					$part = str_replace(' ## ', ' ', $part);
				}
				// 以' ## '作为分割记号存入数据库
				$journal_paras['body'] = implode(' ## ', $_POST['journal_body']);
				
				$journal_paras['bestlist'] = NULL;
				if (isset($_POST['bestlist']) && !empty($_POST['bestlist'])) {
					$journal_paras['bestlist'] = implode(',', $_POST['bestlist']);
				}
				$journal_paras['badlist'] = NULL;
				if (isset($_POST['badlist']) && !empty($_POST['badlist'])) {
					$journal_paras['badlist'] = implode(',', $_POST['badlist']);
				}
				$lrid = $this->moa_leaderreport_model->add($journal_paras);
				
				if ($lrid) {
					echo json_encode(array("status" => TRUE, "msg" => "发布成功"));
					return;
				} else {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				}
				
			} else {
				echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
			}
		}
	}
	
}