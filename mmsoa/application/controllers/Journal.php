<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 坐班日志录入控制类
 * @author 伟、RKK
 */
Class Journal extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_worker_model');
		$this->load->model('Moa_leaderreport_model');
        $this->load->model('Moa_school_term_model');
        $this->load->model('Moa_room_model');
        $this->load->model("Moa_abnormal_model");
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
			$common_worker = $this->Moa_user_model->get_by_level($level);
				
			for ($i = 0; $i < count($common_worker); $i++) {
				$uid_list[$i] = $common_worker[$i]->uid;
				$name_list[$i] = $common_worker[$i]->name;
				$wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
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
	 * 查看坐班日志列表
	 */
	public function listJournal() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
			// 获取基本信息
			$baselist = $this->Moa_leaderreport_model->get_baselist();
            $namelist = array();
			for ($i = 0; $i < count($baselist); $i++) {
				$tmp_wid = $baselist[$i]->wid;
				$tmp_uid = $this->Moa_worker_model->get_uid_by_wid($tmp_wid);
				$namelist[$i] = $this->Moa_user_model->get($tmp_uid)->name;
			}
			$data['journallist'] = $baselist;
			$data['journalname'] = $namelist;
			$this->load->view('view_journal_review', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
    /**
	 * 管理异常助理
	 */   
	public function manageAbnormal() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}

			// 取所有普通助理的wid与name, level: 0-普通助理  1-组长  2-负责人助理  3-助理负责人  4-管理员  5-办公室负责人
			$level = 0;
			$common_worker = $this->Moa_user_model->get_by_level($level);
			for ($i = 0; $i < count($common_worker); $i++) {
				$uid_list[$i] = $common_worker[$i]->uid;
				$name_list[$i] = $common_worker[$i]->name;
				$wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
			}
			$data['name_list'] = $name_list;
			$data['wid_list'] = $wid_list;

			$operator_name_list = array();
			$operator_wid_list = array();
			$o_count = 0;
			// 获取operator
			for ($i = 1; $i <= 5; $i++) {
				$result = $this->Moa_worker_model->get_by_level($i);
				if ($result == false) continue;
				for ($j = 0; $j < count($result); $j++,$o_count++) {
					$temp_wid = $result[$j]->wid;
					$name_res = $this->Moa_user_model->get($result[$j]->uid);
					if ($name_res == false) continue;
					$operator_wid_list[$o_count] = $temp_wid;
					$operator_name_list[$o_count] = $name_res->name;
				}
			}
			$data['operator_name_list'] = $operator_name_list;
			$data['operator_wid_list'] = $operator_wid_list;
			$data['o_count'] = $o_count;
			$this->load->view('view_abnormal_assistant', $data);
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

    /**
	 * 统计异常助理的次数
	 */
    public function AbnormalStatistics() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
			$this->load->view('view_abnormal_statistics');
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
    }

	/**
	 * 搜索指定的异常助理的记录
	 */
	public function searchAbnormalRecords() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 1) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			if (isset($_POST['start_time']) && isset($_POST['end_time']) &&
					isset($_POST['actual_wid']) && isset($_POST['dealing']) && isset($_POST['dealer'])) {
							
						$post_start_time = $_POST['start_time'];
						$post_end_time = $_POST['end_time'];
						$post_actual_wid = $_POST['actual_wid'];
						$post_dealing = $_POST['dealing'];
						$post_dealer = $_POST['dealer'];
						// 字符串转时间格式
						$query_start_time = date('Y-m-d H:i:s', strtotime($post_start_time));
						$query_end_time = date('Y-m-d H:i:s', strtotime($post_end_time));
						$actual_wid = $post_actual_wid;
						if ($actual_wid == -1) $actual_wid = NULL;
						$dealing = $post_dealing;
						if ($post_dealing == -1) $dealing = NULL;
						$dealer = $post_dealer;
						if ($dealer == -1) $dealer = NULL;
						$w_id_list = array();
						$w_wid_list = array();
						$w_day_list = array();
						$w_name_list = array();
						$w_problem_list = array();
						$w_dealing_list = array();
						$w_dealer_list = array();
						$w_comment_list = array();
						$w_count = 0;
						// 获取数据
						$returnData = $this->Moa_abnormal_model->get_records($query_start_time, $query_end_time, $actual_wid, $dealing, $dealer);
	
						if ($returnData != FALSE) {
							for ($i = 0; $i < count($returnData); $i++, $w_count++) {
								$w_id_list[$i] = $returnData[$i]->abnormal_id;
								$w_tmp_wid = $returnData[$i]->actual_wid;
								$w_wid_list[$i] = $w_tmp_wid;
								$w_day_list[$i] = date('Y-m-d', strtotime($returnData[$i]->timestamp));
								$w_problem_list[$i] = $returnData[$i]->problem;
								$dealing_index = $returnData[$i]->dealing;
								if ($dealing_index == 0)
									$w_dealing_list[$i] = "警告";
								else
									$w_dealing_list[$i] = "扣工时";
								$dealer_wid = $returnData[$i]->dealer;
								$dealer_worker_obj = $this->Moa_worker_model->get($dealer_wid);
								$dealer_user_obj = $this->Moa_user_model->get($dealer_worker_obj->uid);
								$dealer = $dealer_user_obj->name;
								$w_dealer_list[$i] = $dealer;
								$w_comment_list[$i] = $returnData[$i]->comment;
								$w_worker_obj = $this->Moa_worker_model->get($w_tmp_wid);
								$w_user_obj = $this->Moa_user_model->get($w_worker_obj->uid);
								$w_name_list[$i] = $w_user_obj->name;
							}
						}
						// 装载前端所需数据
						$data['w_count'] = $w_count;
						$data['w_id_list'] = $w_id_list;
						$data['w_day_list'] = $w_day_list;
						$data['w_name_list'] = $w_name_list;
						$data['w_problem_list'] = $w_problem_list;
						$data['w_dealing_list'] = $w_dealing_list;
						$data['w_dealer_list'] = $w_dealer_list;
						$data['w_comment_list'] = $w_comment_list;
						echo json_encode(array("status" => TRUE, "level" => $_SESSION['level'], "msg" => "查找成功", "data" => $data));
						return;
					} else {
						echo json_encode(array("status" => FALSE, "msg" => "查找失败"));
						return;
					}
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}	

	public function getAbnormalRank() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			if (isset($_POST['type'])) {
							
						$type = $_POST['type'];

						$res = $this->Moa_worker_model->get_abnormal_counts_by_type($type);
						$name_list = array();
						$count_list = array();
						//$level_list = array();
						$num = 0;
						for ($i = 0; $i < count($res); $i++) {
							$level = $this->Moa_user_model->get_level($res[$i]->uid);
							//$level_list[$i] = $level;
							if ($level == 0) {
								$user_obj = $this->Moa_user_model->get($res[$i]->uid);
								$name_list[$num] = $user_obj->name;
								$acount = 0;
								if ($type == 0) $acount = $res[$i]->abnormal_count_0;
								else $acount = $res[$i]->abnormal_count_1;
								$count_list[$num] = $acount;
								$num++;
							}
						}
						$data['type'] = $type;
						$data['num'] = $num;
						$data['name_list'] = $name_list;
						$data['count_list'] = $count_list;
						//$data['level_list'] = $level_list;
						if ($res == false) 
							echo json_encode(array("status" => FALSE, "msg" => "查找失败"));
						else {
							echo json_encode(array("status" => TRUE, "msg" => "查找成功", 'data' => $data));
						}
						return;
					} else {
						echo json_encode(array("status" => FALSE, "msg" => "查找失败"));
						return;
					}
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}		
	}

	/**
	 * 新增异常助理
	 */
	public function addAbnormalRecord() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			if (isset($_POST['time']) && isset($_POST['actual_wid']) &&
					isset($_POST['problem']) && isset($_POST['dealing']) && isset($_POST['dealer']) && isset($_POST['comment'])) {
							
						$time = $_POST['time'];
						$actual_wid = $_POST['actual_wid'];
						$problem = $_POST['problem'];
						$dealing = $_POST['dealing'];
						$dealer = $_POST['dealer'];
						$comment = $_POST['comment'];
						
						// 字符串转时间格式
						$timestamp = date('Y-m-d H:i:s', strtotime($time));

						$in_id = $this->Moa_abnormal_model->add_record(array(
								'timestamp' => $timestamp,
								'actual_wid' => $actual_wid,
								'problem' => $problem,
								'dealing' => $dealing,
								'dealer' => $dealer,
								'comment' => $comment
							)
						);
						// 助理异常次数+1
						$res0 = $this->Moa_worker_model->get($actual_wid);
						$abcount = $res0->abnormal_count_0;
						if ($dealing == 1) $abcount = $res0->abnormal_count_1;
						$abcount++;
						if ($abcount <= 0) $abcount = 1;
						if ($dealing == 0)
							$res = $this->Moa_worker_model->update($actual_wid, array("abnormal_count_0" => $abcount));
						else
							$res = $this->Moa_worker_model->update($actual_wid, array("abnormal_count_1" => $abcount));
						$res0 = $this->Moa_worker_model->get($actual_wid);
						$abcount = $res0->abnormal_count_0;
						if ($dealing == 1) $abcount = $res0->abnormal_count_1;
						if ($in_id == false) 
							echo json_encode(array("status" => FALSE, "msg" => "添加失败，数据库错误"));
						else {
							echo json_encode(array("status" => TRUE, "msg" => "添加成功"));
						}
						return;
					} else {
						echo json_encode(array("status" => FALSE, "msg" => "添加失败，请检查输入"));
						return;
					}
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/**
	 * 删除指定的异常助理记录
	 */
	public function deleteAbnormalRecord() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			if (isset($_POST['id'])) {
							
						$id = $_POST['id'];
						$record = $this->Moa_abnormal_model->get_record_by_id($id);
						$in_id = $this->Moa_abnormal_model->delete_record_by_id($id);
						// 助理异常次数-1
						$dealing_type = $record[0]->dealing;
						$actual_wid = $record[0]->actual_wid;
						$res0 = $this->Moa_worker_model->get($actual_wid);
						$abcount = $res0->abnormal_count_0;
						if ($dealing_type == 1) $abcount = $res0->abnormal_count_1;
						$abcount--;
						if ($abcount < 0) $abcount = 0;
						if ($dealing_type == 0)
							$res = $this->Moa_worker_model->update($actual_wid, array("abnormal_count_0" => $abcount));
						else
							$res = $this->Moa_worker_model->update($actual_wid, array("abnormal_count_1" => $abcount));
						$res0 = $this->Moa_worker_model->get($actual_wid);
						$abcount = $res0->abnormal_count_0;
						if ($in_id == false) 
							echo json_encode(array("status" => FALSE, "msg" => "删除失败，数据库错误"));
						else 
							echo json_encode(array("status" => TRUE, "msg" => "删除成功"));
						return;
					} else {
						echo json_encode(array("status" => FALSE, "msg" => "删除失败，请检查输入"));
						return;
					}
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/**
	 * 查看指定的异常助理记录
	 */
	public function getAbnormalRecord() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			if (isset($_POST['id'])) {
							
						$id = $_POST['id'];
						$returnData = $this->Moa_abnormal_model->get_record_by_id($id);
						if ($returnData == false) 
							echo json_encode(array("status" => FALSE, "msg" => "获取信息失败，数据库错误"));
						else {
							$data['time'] = date("Y-m-d", strtotime($returnData[0]->timestamp));
							$data['wid'] = $returnData[0]->actual_wid;
							$data['problem'] = $returnData[0]->problem;
							$data['dealing'] = $returnData[0]->dealing;
							$data['dealer'] = $returnData[0]->dealer;
							$data['comment'] = $returnData[0]->comment;
							echo json_encode(array("status" => TRUE, "msg" => "获取信息成功", 'data' => $data));
						}
						return;
					} else {
						echo json_encode(array("status" => FALSE, "msg" => "获取信息失败，请检查获取的信息"));
						return;
					}
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}

	/**
	 * 更新指定的异常助理记录
	 */
	public function updateAbnormalRecord() {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
				
			if (isset($_POST['id']) && isset($_POST['time']) && isset($_POST['actual_wid']) &&
					isset($_POST['problem']) && isset($_POST['dealing']) && isset($_POST['dealer']) && isset($_POST['comment'])) {
						$id = $_POST['id'];
						$time = $_POST['time'];
						$actual_wid = $_POST['actual_wid'];
						$problem = $_POST['problem'];
						$dealing = $_POST['dealing'];
						$dealer = $_POST['dealer'];
						$comment = $_POST['comment'];
						
						// 字符串转时间格式
						$timestamp = date('Y-m-d H:i:s', strtotime($time));

						$record = $this->Moa_abnormal_model->get_record_by_id($id);
						$ori_wid = $record[0]->actual_wid;
						$ori_dealing = $record[0]->dealing;
						if ($actual_wid != $ori_wid) {
							$worker_obj_ori = $this->Moa_worker_model->get($ori_wid);
							$worker_obj = $this->Moa_worker_model->get($actual_wid);
							$abnormal_count_0_ori = $worker_obj_ori->abnormal_count_0;
							$abnormal_count_1_ori = $worker_obj_ori->abnormal_count_1;
							$abnormal_count_0 = $worker_obj->abnormal_count_0;
							$abnormal_count_1 = $worker_obj->abnormal_count_1;
							if ($ori_dealing == $dealing) {
								if ($ori_dealing == 0) {
									$abnormal_count_0_ori--;
									$abnormal_count_0++;
								}
								else {
									$abnormal_count_1_ori--;
									$abnormal_count_1++;
								}
							}
							else {
								if ($ori_dealing == 0) {
									$abnormal_count_0_ori--;
									$abnormal_count_1++;
								}
								else {
									$abnormal_count_1_ori--;
									$abnormal_count_0++;
								}
							}
							$this->Moa_worker_model->update($ori_wid, array("abnormal_count_0" => $abnormal_count_0_ori, "abnormal_count_1" => $abnormal_count_1_ori));
							$this->Moa_worker_model->update($actual_wid, array("abnormal_count_0" => $abnormal_count_0, "abnormal_count_1" => $abnormal_count_1));
						}
						else if ($ori_dealing != $dealing) {
							$worker_obj = $this->Moa_worker_model->get($actual_wid);
							$abnormal_count_0 = $worker_obj->abnormal_count_0;
							$abnormal_count_1 = $worker_obj->abnormal_count_1;
							if ($ori_dealing == 0) {
								$abnormal_count_0--;
								$abnormal_count_1++;
							}
							else {
								$abnormal_count_1--;
								$abnormal_count_0++;
							}
							$this->Moa_worker_model->update($actual_wid, array("abnormal_count_0" => $abnormal_count_0, "abnormal_count_1" => $abnormal_count_1));
						}
						$in_id = $this->Moa_abnormal_model->update_record_by_id($id, array(
								'timestamp' => $timestamp,
								'actual_wid' => $actual_wid,
								'problem' => $problem,
								'dealing' => $dealing,
								'dealer' => $dealer,
								'comment' => $comment
							)
						);
						if ($in_id == false) 
							echo json_encode(array("status" => FALSE, "msg" => "更新失败，数据库错误"));
						else 
							echo json_encode(array("status" => TRUE, "msg" => "更新成功"));
						return;
					} else {
						echo json_encode(array("status" => FALSE, "msg" => "更新失败，请检查输入"));
						return;
					}
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}	

    /**
	 * 删除指定的坐班日志
	 */
	public function deleteJournalById($id) {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
			// 执行删除动作
			$this->Moa_leaderreport_model->delete($id);
			// 写日志
			$this->load->model('Moa_log_model');
			$ttparas['dash_wid'] = $_SESSION['worker_id'];
			$ttparas['affect_wid'] = -1;
			$ttparas['description'] = '删除一篇坐班日志（ID：'.$id.'）';
			$ttparas['logtimestamp'] = date('Y-m-d H:i:s');
			$this->Moa_log_model->add($ttparas);
            // 刷新
            redirect('Journal/listJournal');
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
    
	/**
	 * 查看指定的坐班日志
	 */
	public function readJournalById($id) {
		if (isset($_SESSION['user_id'])) {
			// 检查权限: 1-组长 2-负责人助理 3-助理负责人 4-管理员 5-办公室负责人 6-超级管理员
			if ($_SESSION['level'] <= 0) {
				// 提示权限不够
				PublicMethod::permissionDenied();
			}
            if (isset($id) == FALSE) {
                return;
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
			$report_obj = $this->Moa_leaderreport_model->get($id);
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
				$r_worker_obj = $this->Moa_worker_model->get($leader_wid);
				$r_user_obj = $this->Moa_user_model->get($r_worker_obj->uid);
				$data['leader_name'] = $r_user_obj->name;
	
				// 获取优秀助理姓名列表
				$best_list = array();
				if (!is_null($report_obj->bestlist)) {
					$best_wid_list = explode(',', $report_obj->bestlist);
					for ($i = 0; $i < count($best_wid_list); $i++) {
						$best_wid = $best_wid_list[$i];
						$best_worker_obj = $this->Moa_worker_model->get($best_wid);
						$best_user_obj = $this->Moa_user_model->get($best_worker_obj->uid);
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
						$bad_worker_obj = $this->Moa_worker_model->get($bad_wid);
						$bad_user_obj = $this->Moa_user_model->get($bad_worker_obj->uid);
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

	/**
	 * 查看最新坐班日志
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
			$report_obj = $this->Moa_leaderreport_model->get_lasted($state);
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
				$r_worker_obj = $this->Moa_worker_model->get($leader_wid);
				$r_user_obj = $this->Moa_user_model->get($r_worker_obj->uid);
				$data['leader_name'] = $r_user_obj->name;
	
				// 获取优秀助理姓名列表
				$best_list = array();
				if (!is_null($report_obj->bestlist)) {
					$best_wid_list = explode(',', $report_obj->bestlist);
					for ($i = 0; $i < count($best_wid_list); $i++) {
						$best_wid = $best_wid_list[$i];
						$best_worker_obj = $this->Moa_worker_model->get($best_wid);
						$best_user_obj = $this->Moa_user_model->get($best_worker_obj->uid);
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
						$bad_worker_obj = $this->Moa_worker_model->get($bad_wid);
						$bad_user_obj = $this->Moa_user_model->get($bad_worker_obj->uid);
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
			$wid = $this->Moa_worker_model->get_wid_by_uid($uid);
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
                $today = date("Y-m-d H:i:s");
                $term = $this->Moa_school_term_model->get_term($today);
                if(count($term) == 0) {
                    echo json_encode(array("status" => FALSE, "msg" => "没有本学期时间信息，请联系管理员"));
                    return;
                }
				$journal_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $today);
	
				// 1-周一  2-周二  ... 6-周六  7-周日
				$journal_paras['weekday'] = date("w") == 0 ? 7 : date("w");
				
				$journal_paras['timestamp'] = $today;
				
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
				// 添加到数据库
				$lrid = $this->Moa_leaderreport_model->add($journal_paras);
				if ($lrid) {
					// 写日志
					$this->load->model('Moa_log_model');
					$ttparas['dash_wid'] = $_SESSION['worker_id'];
					$ttparas['affect_wid'] = -1;
					$ttparas['description'] = '添加一篇坐班日志（ID：'.$lrid.'）';
					$ttparas['logtimestamp'] = date('Y-m-d H:i:s');
					$this->Moa_log_model->add($ttparas);
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