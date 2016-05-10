<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 修改密码控制类
 * @author 伟
 */
Class ChangePassword extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('moa_user_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	/*
	 * 进入修改密码页面
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			// 获取个人信息
			$obj = $this->moa_user_model->get($_SESSION['user_id']);
			$data['username'] = $obj->username;
			$this->load->view('view_change_password', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/*
	 * 修改密码
	 */
	public function changePassword() {
		if (isset($_SESSION['user_id'])) {
			if (isset($_POST['password_old'])) {
				$obj = $this->moa_user_model->get($_SESSION['user_id']);
				$pw_old = $obj->password;
				if ($pw_old != md5($_POST['password_old'])) {
					echo json_encode(array("status" => FALSE, "msg" => "旧密码错误"));
					return;
				} else {
					if (isset($_POST['password_new']) && isset($_POST['confirm_password'])) {
						if ($_POST['password_new'] == $_POST['confirm_password']) {
							$pd_paras['password'] = md5($_POST['password_new']);
							$res = $this->moa_user_model->update($_SESSION['user_id'], $pd_paras);
								
							if ($res != FALSE) {
								echo json_encode(array("status" => TRUE, "msg" => "修改成功"));
								return;
							} else {
								echo json_encode(array("status" => FALSE, "msg" => "修改失败"));
								return;
							}
						} else {
							echo json_encode(array("status" => FALSE, "msg" => "两次输入的密码不一致"));
							return;
						}
					}
					
				}
			} else {
				echo json_encode(array("status" => FALSE, "msg" => "修改失败"));
				return;
			}
		} else {
			echo json_encode(array("status" => FALSE, "msg" => "修改失败"));
				return;
		}
	}
	
}