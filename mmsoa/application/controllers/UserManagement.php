<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 添加新用户控制类
 * @author 伟
 */
Class UserManagement extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('moa_user_model');
		$this->load->model('moa_worker_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	public function index() {
		
	}
	
	/**
	 * 添加新用户
	 */
	public function addUser() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 2) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			$data['daily_classrooms'] = PublicMethod::get_daily_classrooms();
			$data['weekly_classrooms'] = PublicMethod::get_weekly_classrooms();
			$this->load->view('view_add_user', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/**
	 * 查看用户列表
	 */
	public function searchUser() {
		if (isset($_SESSION['user_id'])) {
			// state: 0-正常  1-锁定  2-已删除
			$state = 0;
			// 取状态为正常的所有用户
			$users = $this->moa_user_model->get_by_state($state);
			// 获取普通助理的常检周检课室列表
			$workers = array();
			for ($i = 0; $i < count($users); $i++) {
				if ($users[$i]->level == 0) {
					$tmp_wid = $this->moa_worker_model->get_wid_by_uid($users[$i]->uid);
					$workers[$i] = $this->moa_worker_model->get($tmp_wid);
				}
			}
			$data['users'] = $users;
			$data['workers'] = $workers;
			$this->load->view('view_search_user', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/*
	 * 添加新用户
	 */
	public function addNewUser() {
		if (isset($_SESSION['user_id'])) {
			if (isset($_POST['username'])) {
				$user_record = $this->moa_user_model->get_by_username($_POST['username']);
				// 确保用户名的唯一性
				if (!$user_record) {
					$user_paras['username'] = $_POST['username'];
					if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
						if ($_POST['password'] == $_POST['confirm_password']) {
							$user_paras['password'] = md5($_POST['password']);
							$user_paras['name'] = $_POST['name'];
							$user_paras['level'] = $_POST['level'];
							$user_paras['indate'] = $_POST['indate'];
							// state: 0-正常  1-锁定  2-已删除
							$user_paras['state'] = 0;
							$uid = $this->moa_user_model->add($user_paras);
							
							if ($uid != FALSE) {
								// 插入MOA_Worker表
								$worker_paras['uid'] = $uid;
								$worker_paras['level'] = $_POST['level'];
								$worker_paras['group'] = NULL;
								$worker_paras['classroom'] = NULL;
								$worker_paras['week_classroom'] = NULL;
								
								// 若为普通助理，还应录入组别、常检课室、周检课室
								if ($_POST['level'] == 0) {
									if (isset($_POST['group']) && isset($_POST['classroom']) && isset($_POST['week_classroom'])) {
										$worker_paras['group'] = $_POST['group'];
										$worker_paras['classroom'] = $_POST['classroom'];
										$worker_paras['week_classroom'] = $_POST['week_classroom'];
									}
								// 非普通助理用户的组别为N
								} else {
									$worker_paras['group'] = 0;
								}
								$wid = $this->moa_worker_model->add($worker_paras);
										
								if ($wid != FALSE) {
									echo json_encode(array("status" => TRUE, "msg" => "添加成功"));
									return;
								} else {
									echo json_encode(array("status" => FALSE, "msg" => "添加失败"));
									return;
								}
								
							} else {
								echo json_encode(array("status" => FALSE, "msg" => "添加失败"));
								return;
							}
							
						} else {
							echo json_encode(array("status" => FALSE, "msg" => "两次输入的密码不一致"));
							return;
						}
					}
				} else {
					echo json_encode(array("status" => FALSE, "msg" => "该用户名已存在"));
					return;
				}
			}
		} else {
			echo json_encode(array("status" => FALSE, "msg" => "添加失败"));
				return;
		}
	}
	
	
}