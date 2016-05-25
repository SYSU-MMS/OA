<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 通知控制类
 * @author 伟
 */
Class Notify extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('moa_user_model');
		$this->load->model('moa_worker_model');
		$this->load->model('moa_notice_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	/**
	 * 进入通知管理页面
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			$this->load->view('view_notice');
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	
	
	/**
	 * 发布工作通知
	 */
	public function addNotice() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$user_obj = $this->moa_user_model->get($uid);
			$name = $user_obj->name;
			$avatar = $user_obj->avatar;
				
			// 添加新通知
			if (1) {
				// state：0-正常  1-已删除
				$notice_paras['state'] = 0;
				$notice_paras['wid'] = 1;
				$timestamp = date('Y-m-d H:i:s');
				$notice_paras['timestamp'] = $timestamp;
				$notice_paras['title'] = "今日头条";
				$notice_paras['body'] = "发工资啦";
				$nid = $this->moa_notice_model->add($notice_paras);
				if ($nid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "发布失败"));
					return;
				} else {
					$splited_date = PublicMethod::splitDate($timestamp);
					echo json_encode(array("status" => TRUE, "msg" => "发布成功", "name" => $name, "avatar" => $avatar,
							"splited_date" => $splited_date, "nid" => $nid, "base_url" => base_url()));
					return;
				}
			}
		}
	}
	
}