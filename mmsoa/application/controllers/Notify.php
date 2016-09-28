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
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_notice_model');
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
	 * 获取工作通知的标题
	 */
	public function getNotice() {
		if (isset($_SESSION['user_id'])) {
			if (isset($_GET['base_date'])) {
				$base_date = $_GET['base_date'];
				
				// 0表示当前时间
				if ($_GET['base_date'] == '0') {
					$base_date = date('Y-m-d H:i:s');
				}
				
				// 每次最多取指定时间之前的10则通知
				$notice_state = 0;
				$notice_num = 10;
				$notice_obj_list = $this->Moa_notice_model->get_by_date($base_date, $notice_state, $notice_num);
				
				if (empty($notice_obj_list)) {
					echo json_encode(array("status" => FALSE, "msg" => "获取通知失败"));
					return;
				}
				
				$notice_list = array();
				
				for ($i = 0; $i < count($notice_obj_list); $i++) {
					$tmp_notice_nid = $notice_obj_list[$i]->nid;
					$tmp_notice_wid = $notice_obj_list[$i]->wid;
					$tmp_notice_timestamp = $notice_obj_list[$i]->timestamp;
					$tmp_notice_title = $notice_obj_list[$i]->title;
					
					// 获取uid
					$tmp_notice_worker_obj = $this->Moa_worker_model->get($tmp_notice_wid);
					$tmp_notice_uid = $tmp_notice_worker_obj->uid;
					
					// 获取姓名和头像
					$tmp_notice_user_obj = $this->Moa_user_model->get($tmp_notice_uid);
					$tmp_notice_name = $tmp_notice_user_obj->name;
					$tmp_notice_avatar = $tmp_notice_user_obj->avatar;
					
					// 前端渲染所用数据
					$notice_list[$i]['nid'] = $tmp_notice_nid;
					$notice_list[$i]['timestamp'] = $tmp_notice_timestamp;
					$notice_list[$i]['title'] = $tmp_notice_title;
					$notice_list[$i]['name'] = $tmp_notice_name;
					$notice_list[$i]['avatar'] = $tmp_notice_avatar;
					$notice_list[$i]['splited_date'] = PublicMethod::splitDate($tmp_notice_timestamp);
					
				}
				echo json_encode(array("status" => TRUE, "msg" => "获取通知成功", "base_url" => base_url(), 
						"notice_list" => $notice_list));
				return;
			}
	
		}
	}
	
	/**
	 * 查看通知具体内容
	 */
	public function readNotice() {
		if (isset($_SESSION['user_id'])) {
			if (isset($_GET['nid'])) {
				$nid = $_GET['nid'];
				// 通过nid获取指定的通知详情
				$notice_obj = $this->Moa_notice_model->get($nid);
				
				// 获取发布者姓名
				$wid = $notice_obj->wid;
				$worker_obj = $this->Moa_worker_model->get($wid);
				$user_obj = $this->Moa_user_model->get($worker_obj->uid);
				
				$data['title'] = $notice_obj->title;
				$data['body'] = $notice_obj->body;
				$data['name'] = $user_obj->name;
				$data['timestamp'] = substr($notice_obj->timestamp, 0, 10);
				// 跳转到通知详情页面
				$this->load->view('view_notice_detail', $data);
			}
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/**
	 * 进入发布新通知页面
	 */
	public function writeNotice() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 3-助理负责人 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] != 3 && $_SESSION['level'] != 5 && $_SESSION['level'] != 6) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
			
			$this->load->view('view_write_notice');
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/**
	 * 发布新通知(录入)
	 */
	public function writeNoticeIn() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$wid = $this->Moa_worker_model->get_wid_by_uid($uid);
			if (isset($_POST['notice_title']) && isset($_POST['notice_content'])) {
				$notice_paras['wid'] = $wid;
		
				// state： 0-正常  1-已删除
				$notice_paras['state'] = 0;
		
				$notice_paras['timestamp'] = date('Y-m-d H:i:s');
				$notice_paras['title'] = $_POST['notice_title'];
				$notice_paras['body'] =  $_POST['notice_content'];
				
				$nid = $this->Moa_notice_model->add($notice_paras);
		
				if ($nid) {
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