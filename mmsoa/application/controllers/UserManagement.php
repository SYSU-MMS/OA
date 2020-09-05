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
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
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
	 * 移除用户
	 */
	public function deleteUser() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 3-助理负责人 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] != 3 && $_SESSION['level'] != 5 && $_SESSION['level'] != 6) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
		
			if (isset($_POST['delete_uid'])) {
				$affected_row = $this->Moa_user_model->delete($_POST['delete_uid']);
				if ($affected_row > 0) {
					echo json_encode(array("status" => TRUE, "msg" => "移除成功"));
					return;
				} else {
					echo json_encode(array("status" => FALSE, "msg" => "移除失败"));
					return;
				}
			} else {
				echo json_encode(array("status" => FALSE, "msg" => "移除失败"));
				return;
			}
		} else {
			echo json_encode(array("status" => FALSE, "msg" => "移除失败"));
			return;
		}
	}
	
	/**
	 * 修改用户重要信息
	 */
	public function updateUser() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 2) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
	
			// 取除超级管理员(level==6)外，其他所有状态正常的用户
			$userid_list = array();
			$username_list = array();
			$level_arr = array(0, 1, 2, 3, 4, 5);
			$state = 0;
			$user_obj_list_on = $this->Moa_user_model->get_by_multiple_level($level_arr, $state);
			$user_obj_list_leave = $this->Moa_user_model->get_by_multiple_level(array(-1), 3);
            $user_obj_list = array_merge($user_obj_list_on, $user_obj_list_leave);
			if ($user_obj_list != FALSE) {
				for ($i = 0; $i < count($user_obj_list); $i++) {
					$userid_list[$i] = $user_obj_list[$i]->uid;
					$username_list[$i] = $user_obj_list[$i]->name;
				}
			}
			
			$data['userid_list'] = $userid_list;
			$data['username_list'] = $username_list;
			$data['daily_classrooms'] = PublicMethod::get_daily_classrooms();
			$data['weekly_classrooms'] = PublicMethod::get_weekly_classrooms();
			$this->load->view('view_update_user', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
    /**
	 * 添加一个名人堂成员
	 */
	public function addStarMember() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 2) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
	
			// 取除超级管理员(level==6)外，其他所有状态正常的用户
			$userid_list = array();
			$username_list = array();
			$level_arr = array(0, 1, 2, 3, 4, 5);
			$state = 0;
			$user_obj_list_on = $this->Moa_user_model->get_by_multiple_level($level_arr, $state);
			$user_obj_list_leave = $this->Moa_user_model->get_by_multiple_level(array(-1), 3);
            $user_obj_list = array_merge($user_obj_list_on, $user_obj_list_leave);
			if ($user_obj_list != FALSE) {
				for ($i = 0; $i < count($user_obj_list); $i++) {
					$userid_list[$i] = $user_obj_list[$i]->uid;
					$username_list[$i] = $user_obj_list[$i]->name;
				}
			}
			
			$data['userid_list'] = $userid_list;
			$data['username_list'] = $username_list;
			$this->load->view('view_add_star', $data);
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
			// state: 0-正常  1-锁定  2-已删除  3-离职
			$state = 0;
			// 取状态为正常的所有用户
			$users = $this->Moa_user_model->get_by_state($state);
            // 取其他状态的用户
            $users_lock = $this->Moa_user_model->get_by_state(1);
            $users_leave = $this->Moa_user_model->get_by_state(3);
            $users_all = array_merge($users, $users_leave, $users_lock);
			// 获取普通助理的常检周检课室列表
			$workers = array();
			for ($i = 0; $i < count($users); $i++) {
				//if ($users[$i]->level == 0) {
			    $tmp_wid = $this->Moa_worker_model->get_wid_by_uid($users[$i]->uid);
				$workers[$i] = $this->Moa_worker_model->get($tmp_wid);
				//}
			}
            // 获取所有助理worker信息
            $workers_all = array();
			for ($i = 0; $i < count($users_all); $i++) {
			    $tmp_wid = $this->Moa_worker_model->get_wid_by_uid($users_all[$i]->uid);
				$workers_all[$i] = $this->Moa_worker_model->get($tmp_wid);
			}
            // 名人堂
            $starObjs = $this->Moa_user_model->get_stars();
            $starUsrs = array();
            for ($i = 0; $i < count($starObjs); $i++) {
                $tmp_uid = $this->Moa_worker_model->get_uid_by_wid($starObjs[$i]->wid);
                $starUsrs[$i] = $this->Moa_user_model->get($tmp_uid);
            }
            // 准备渲染数据
			$data['users'] = $users;
			$data['workers'] = $workers;
            $data['alusers'] = $users_all;
			$data['alworkers'] = $workers_all;
            $data['starobj'] = $starObjs;
            $data['starusrobj'] = $starUsrs;
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
				$user_record = $this->Moa_user_model->get_by_username($_POST['username']);
				// 确保用户名的唯一性
				if (!$user_record) {
					$user_paras['username'] = $_POST['username'];
					if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
						if ($_POST['password'] == $_POST['confirm_password']) {
							$user_paras['password'] = md5($_POST['password']);
							$user_paras['name'] = $_POST['name'];
							$user_paras['level'] = $_POST['level'];
							$user_paras['indate'] = $_POST['indate'];
							// state: 0-正常  1-锁定  2-已删除  3-离职
							$user_paras['state'] = $_POST['level'] == -1 ? 3 : 0;
							$uid = $this->Moa_user_model->add($user_paras);

							if ($uid != FALSE) {
								// 插入Moa_Worker表
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
                                }
								// 离职人员都是N组
                                else if ($_POST['level'] == -1) {
                                    $worker_paras['group'] = 0;
								}
                                // 非普通助理用户的组别为管理
                                else {
									$worker_paras['group'] = 7;
								}
								$wid = $this->Moa_worker_model->add($worker_paras);
										
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
	
	/*
	 * 修改用户重要信息
	 */
	public function updateUserInfo() {
		if (isset($_SESSION['user_id'])) {
			if (isset($_POST['userid']) && isset($_POST['username']) && isset($_POST['level']) && isset($_POST['indate'])) {
				$user_record = $this->Moa_user_model->get_by_username($_POST['username']);
				// 确保用户名的唯一性
				if (!$user_record) {
					// 要修改的用户id
					$update_uid = $_POST['userid'];
					$update_user_obj = $this->Moa_user_model->get($update_uid);
					
					$user_paras['username'] = $_POST['username'];
					// 若没有输入新用户名，则用户名取原来的用户名
					if ($user_paras['username'] == NULL) {
						$user_paras['username'] = $update_user_obj->username;
					}
					
					if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
						if ($_POST['password'] == $_POST['confirm_password']) {
							$user_paras['password'] = md5($_POST['password']);
							if ($_POST['password'] == NULL) {
								$user_paras['password'] = $update_user_obj->password;
							}
							
							$user_paras['level'] = $_POST['level'];
							if ($user_paras['level'] == "9") {
								$user_paras['level'] = $update_user_obj->level;
							}
                            
                            // 离职标记
                            if ($user_paras['level'] == "-1") {
                                $user_paras['state'] = 3;
                            } else {
                                $user_paras['state'] = 0;
                            }
							
							$user_paras['indate'] = $_POST['indate'];
							if ($user_paras['indate'] == NULL) {
								$user_paras['indate'] = $update_user_obj->indate;
							}
							
							// 修改user表
							$user_affected_rows = $this->Moa_user_model->update($update_uid, $user_paras);
								
// 							if ($user_affected_rows != FALSE) {
								// 修改Moa_Worker表
								$update_wid = $this->Moa_worker_model->get_wid_by_uid($update_uid);
								$update_worker_obj = $this->Moa_worker_model->get($update_wid);
								
								$worker_paras['level'] = $user_paras['level'];
								$worker_paras['group'] = $update_worker_obj->group;
								$worker_paras['classroom'] = $update_worker_obj->classroom;
								$worker_paras['week_classroom'] = $update_worker_obj->week_classroom;
								$worker_paras['week_classroom_ab'] = $update_worker_obj->week_classroom_ab;
	
								// 若为普通助理，还应录入组别、常检课室、周检课室
								if ($worker_paras['level'] == 0) {
									if (isset($_POST['group']) || isset($_POST['classroom']) || isset($_POST['week_classroom']) || isset($_POST['week_classroom_ab'])) {
										$worker_paras['group'] = $_POST['group'];
										
										$worker_paras['classroom'] = $_POST['classroom'];
										if ($worker_paras['classroom'] == NULL) {
											$worker_paras['classroom'] = $update_worker_obj->classroom;
										}
										
										$worker_paras['week_classroom'] = $_POST['week_classroom'];
										if ($worker_paras['week_classroom'] == NULL) {
											$worker_paras['week_classroom'] = $update_worker_obj->week_classroom;
										}
										
										// $worker_paras['week_classroom_ab'] = $_POST['week_classroom_ab'];
										// if ($worker_paras['week_classroom_ab'] == NULL) {
										// 	$worker_paras['week_classroom_ab'] = $update_worker_obj->week_classroom_ab;
										// }
										$this->Moa_worker_model->update_ab($update_wid, $_POST['week_classroom_ab']);
									}
								}
                                // 离职人员都是N组
                                else if ($worker_paras['level'] == -1) {
                                    $worker_paras['group'] = 0;
                                }
                                // 非普通助理用户的组别为管理
                                else {
									$worker_paras['group'] = 7;
								}
								$worker_affected_rows = $this->Moa_worker_model->update($update_wid, $worker_paras);
	
// 								if ($worker_affected_rows != FALSE) {
									echo json_encode(array("status" => TRUE, "msg" => "修改成功"));
									return;
// 								} else {
// 									echo json_encode(array("status" => FALSE, "msg" => "修改失败"));
// 									return;
// 								}
	
// 							} else {
// 								echo json_encode(array("status" => FALSE, "msg" => "修改失败"));
// 								return;
// 							}
								
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
			echo json_encode(array("status" => FALSE, "msg" => "修改失败"));
			return;
		}
	}
	
	/*
	 * 添加名人
	 */
	public function addStarInfo() {
		if (isset($_SESSION['user_id'])) {
			if (isset($_POST['userid'])) {
                $twid = $this->Moa_worker_model->get_wid_by_uid($_POST['userid']);
                $paras['wid'] = $twid;
                $paras['description'] = $_POST['description'];
                $user_affected_rows = $this->Moa_user_model->add_star($paras);
                echo json_encode(array("status" => TRUE, "msg" => "添加成功"));
                return;			
            } else {
				echo json_encode(array("status" => FALSE, "msg" => "添加失败"));
				return;
			}
		}
    }
    
    /*
	 * 删除名人
     * @param starid - 名人id
	 */
	public function deleteStarInfo($starid) {
		if (isset($_SESSION['user_id'])) {
            // 检查权限: 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 2) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
            if (isset($starid)) {
                $this->Moa_user_model->delete_star($starid);
                redirect('UserManagement/searchUser');
            }
        }
    }
	
}