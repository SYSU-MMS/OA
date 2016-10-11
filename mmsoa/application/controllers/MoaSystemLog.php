<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 系统日志类
 * @author RKK
 */
Class MoaSystemLog extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_log_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	public function index() {
		Review();
	}
	
	/**
	 * 查看今日常检记录
	 */
	public function Review() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 1) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
			$logarr = $this->Moa_log_model->get();
			$dashlist = array();
			$affectlist = array();
			$desclist = array();
			$timelist = array();
			for ($i = 0; $i < count($logarr); $i++) {
				$tmp_dash_wid = $logarr[$i]->dash_wid;
				$tmp_affect_wid = $logarr[$i]->affect_wid;
				$tmp_dash_uid = $this->Moa_worker_model->get_uid_by_wid($tmp_dash_wid);
				$tmp_affect_uid = $this->Moa_worker_model->get_uid_by_wid($tmp_affect_wid);
				$dashlist[$i] = $this->Moa_user_model->get($tmp_dash_uid)->name;
				$affectlist[$i] = $this->Moa_user_model->get($tmp_affect_uid)->name;
				$desclist[$i] = $logarr[$i]->description;
				$timelist[$i] = $logarr[$i]->logtimestamp;
			}
			$data['encounter'] = count($logarr);
			$data['dashlist'] = $dashlist;
			$data['affectlist'] = $affectlist;
			$data['desclist'] = $desclist;
			$data['timelist'] = $timelist;
			$this->load->view('view_syslog_review', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	
}