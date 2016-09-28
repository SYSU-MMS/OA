<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 后台控制类
 * @author 伟
 */
Class BackEnd extends CI_Controller {
	public function __construct() {
		parent::__construct();
 		$this->load->model('Moa_user_model');
 		$this->load->model('Moa_worker_model');
 		$this->load->model('Moa_check_model');
 		$this->load->model('Moa_room_model');
 		$this->load->model('Moa_problem_model');
 		$this->load->model('Moa_attend_model');
 		$this->load->model('Moa_leaderreport_model');
 		$this->load->helper(array('form', 'url'));
 		$this->load->library('session');
 		$this->load->helper('cookie');
	}

	public function index() {
		
	}

	/**
	 * 根据worker的classroom录入所有课室
	 */
	public function addRoom() {
		$state = 0;
		$level = 0;
		$users = $this->Moa_user_model->get_by_level_state($level, $state);
		$workers = array();
		for ($i = 0; $i < count($users); $i++) {
			$wid = $this->Moa_worker_model->get_wid_by_uid($users[$i]->uid);
			$workers[$i] = $this->Moa_worker_model->get($wid);
			$room_list = array();
			$room_list = explode(',', $workers[$i]->classroom);
			for ($j = 0; $j < count($room_list); $j++) {
				$res = $this->Moa_check_model->get_roomid_by_room($room_list[$j]);
				if (!$res) {
					$paras['room'] = $room_list[$j];
					$paras['wid'] = $wid;
					$paras['state'] = 0;
					$roomid = $this->Moa_room_model->add($paras);
				}
			}
			unset($room_list);
		}
		
	}
	
}