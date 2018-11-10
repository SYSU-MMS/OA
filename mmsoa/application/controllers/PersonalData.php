<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 个人信息控制类
 * @author 伟
 */
Class PersonalData extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	/**
	 * 查看/修改个人资料
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			// 获取个人信息
			$obj = $this->Moa_user_model->get($_SESSION['user_id']);
			$data['personal_data'] = $obj;
			$this->load->view('view_personal_data', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
    /**
	 * 查看他人资料
	 */
    public function showOthersPersonalData($uid) {
       if (isset($_SESSION['user_id']) && isset($uid)) {
			// 获取个人信息
			$obj = $this->Moa_user_model->get($uid);
            if ($obj == FALSE) {return;}
			$data['personal_data'] = $obj;
            $data['level_name'] = PublicMethod::translate_level($obj->level);
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            $workerObj = $this->Moa_worker_model->get($wid);
            $data['group_name'] = PublicMethod::translate_group($workerObj->group);
            $data['nowstate'] = PublicMethod::translate_state($obj->state);
			$this->load->view('view_other_personal_data', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
    }
    
	/*
	 * 个人信息（录入 更新）
	 */
	public function personalDataUpdate() {
		if (isset($_SESSION['user_id'])) {
			if (isset($_POST['pd_phone'])) {
				$pd_paras['phone'] = $_POST['pd_phone'];
			}
			if (isset($_POST['pd_shortphone'])) {
				$pd_paras['shortphone'] = $_POST['pd_shortphone'];
			}
			if (isset($_POST['pd_qq'])) {
				$pd_paras['qq'] = $_POST['pd_qq'];
			}
			if (isset($_POST['pd_wechat'])) {
				$pd_paras['wechat'] = $_POST['pd_wechat'];
			}
			if (isset($_POST['pd_studentid'])) {
				$pd_paras['studentid'] = $_POST['pd_studentid'];
			}
			if (isset($_POST['pd_school'])) {
				$pd_paras['school'] = $_POST['pd_school'];
			}
			if (isset($_POST['pd_address'])) {
				$pd_paras['address'] = $_POST['pd_address'];
			}
			if (isset($_POST['pd_creditcard'])) {
				$pd_paras['creditcard'] = $_POST['pd_creditcard'];
			}
            if (isset($_POST['pd_sex'])) {
				$pd_paras['sex'] = $_POST['pd_sex'];
			}
			
			$res = $this->Moa_user_model->update($_SESSION['user_id'], $pd_paras);

			if ($res != FALSE) {
				echo json_encode(array("status" => TRUE, "msg" => "保存成功"));
				return;
			} else {
				echo json_encode(array("status" => FALSE, "msg" => "未修改任何条目"));
				return;
			}
			
		} else {
			echo json_encode(array("status" => FALSE, "msg" => "保存失败B"));
				return;
		}
	}
	
}