<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 拍摄登记控制类
 * @author 伟
 */
Class Filming extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_attend_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	/**
	 * 进入拍摄登记页面
	 */
	public function index() {
	if (isset($_SESSION['user_id'])) {
			// 检查权限: 0-普通助理  6-超级管理员
			if ($_SESSION['level'] != 0 && $_SESSION['level'] != 6) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
			
			$this->load->view('view_filming');
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	
}