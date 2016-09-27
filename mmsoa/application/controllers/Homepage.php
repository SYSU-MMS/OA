<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 主页控制类
 * @author 伟
 */
Class Homepage extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Moa_user_model');
		$this->load->model('Moa_mmsboard_model');
		$this->load->model('Moa_mbcomment_model');
		$this->load->model('Moa_notice_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	/**
	 * 进入主页
	 */
	public function index() {
		if (isset($_SESSION['user_id'])) {
			$this->load->view('view_homepage');
		} else {
			// 未登录的用户请先登录
			PublicMethod::requireLogin();
		}
	}
	
	/*
	 * 添加、获取留言
	 */
	public function addPost() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$user_obj = $this->Moa_user_model->get($uid);
			$name = $user_obj->name;
			$avatar = $user_obj->avatar;
			// 添加新留言
			if (isset($_POST['post_content'])) {
				// state：0-正常  1-已删除
				$board_paras['state'] = 0;
				$board_paras['uid'] = $uid;
				$timestamp = date('Y-m-d H:i:s');
				$board_paras['bptimestamp'] = $timestamp;
				$board_paras['body'] = $_POST['post_content'];
				$bpid = $this->Moa_mmsboard_model->add($board_paras);
				if ($bpid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "留言失败"));
					return;
				} else {
					$splited_date = PublicMethod::splitDate($timestamp);
					echo json_encode(array("status" => TRUE, "msg" => "留言成功", "name" => $name, "avatar" => $avatar, 
							"splited_date" => $splited_date, "bpid" => $bpid, "base_url" => base_url(),
                            "site_url" => site_url(), "myid" => $uid));
					return;
				}
			}
		}
	}
	
	/**
	 * 添加新评论
	 */
	public function addComment() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$user_obj = $this->Moa_user_model->get($uid);
			$name = $user_obj->name;
			$avatar = $user_obj->avatar;
				
			// 添加新评论
			if (isset($_POST['comment_content']) && isset($_POST['post_id'])) {
				// state：0-正常  1-已删除
				$comment_paras['state'] = 0;
				$comment_paras['uid'] = $uid;
				$comment_paras['bpid'] = $_POST['post_id'];
				$timestamp = date('Y-m-d H:i:s');
				$comment_paras['mbctimestamp'] = $timestamp;
				$comment_paras['body'] = $_POST['comment_content'];
				$mbcid = $this->Moa_mbcomment_model->add($comment_paras);
				if ($mbcid == FALSE) {
					echo json_encode(array("status" => FALSE, "msg" => "评论失败"));
					return;
				} else {
					$splited_date = PublicMethod::splitDate($timestamp);
					echo json_encode(array("status" => TRUE, "msg" => "评论成功", "name" => $name, "avatar" => $avatar, 
							"splited_date" => $splited_date, "mbcid" => $mbcid, "base_url" => base_url(),
                            "site_url" => site_url(), "myid" => $uid));
					return;
				}
			}
		}
	}
	
	/**
	 * 取留言与对应的评论
	 */
	public function getPostComment() {
		if (isset($_SESSION['user_id'])) {
			// 获取当前用户的头像，用于评论区
			$cur_avatar = $this->Moa_user_model->get($_SESSION['user_id'])->avatar;
			if (isset($_GET['base_date'])) {
				$base_date = $_GET['base_date'];
				// 0表示当前时间
				if ($_GET['base_date'] == '0') {
					$base_date = date('Y-m-d H:i:s');
				}
				$post_state = 0;
				$post_num = 15;
				// 每次最多取指定时间之前的15条留言
				$post_obj_list = $this->Moa_mmsboard_model->get_by_date($base_date, $post_state, $post_num);
				
				if (empty($post_obj_list)) {
					echo json_encode(array("status" => FALSE, "msg" => "获取留言失败"));
					return;
				}
				
				$post_list = array();
				$comment_list = array();
				
				for ($i = 0; $i < count($post_obj_list); $i++) {
					$tmp_post_bpid = $post_obj_list[$i]->bpid;
					$tmp_post_uid = $post_obj_list[$i]->uid;
					$tmp_post_bptimestamp = $post_obj_list[$i]->bptimestamp;
					$tmp_post_body = $post_obj_list[$i]->body;
					$tmp_post_user_obj = $this->Moa_user_model->get($tmp_post_uid);
					$tmp_post_name = $tmp_post_user_obj->name;
					$tmp_post_avatar = $tmp_post_user_obj->avatar;
					
					// 前端渲染所用数据
                    $post_list[$i]['myid'] = $tmp_post_uid;
					$post_list[$i]['bpid'] = $tmp_post_bpid;
					$post_list[$i]['bptimestamp'] = $tmp_post_bptimestamp;
					$post_list[$i]['body'] = $tmp_post_body;
					$post_list[$i]['name'] = $tmp_post_name;
					$post_list[$i]['avatar'] = $tmp_post_avatar;
					$post_list[$i]['splited_date'] = PublicMethod::splitDate($tmp_post_bptimestamp);
					
					// 取该留言对应的所有评论
					$comment_state = 0;
					$comment_obj_list = $this->Moa_mbcomment_model->get_by_bpid($tmp_post_bpid, $comment_state);
					
					//评论为空
					if (empty($comment_obj_list)) {
						$comment_list[$i] = NULL;
					} else {
						for ($j = 0; $j < count($comment_obj_list); $j++) {
							$tmp_comment_uid = $comment_obj_list[$j]->uid;
							$tmp_comment_mbctimestamp = $comment_obj_list[$j]->mbctimestamp;
							$tmp_comment_body = $comment_obj_list[$j]->body;
							$tmp_comment_user_obj = $this->Moa_user_model->get($tmp_comment_uid);
							$tmp_comment_name = $tmp_comment_user_obj->name;
							$tmp_comment_avatar = $tmp_comment_user_obj->avatar;
						
							// 前端渲染所用数据
                            $comment_list[$i][$j]['myid'] = $tmp_comment_uid;
							$comment_list[$i][$j]['body'] = $tmp_comment_body;
							$comment_list[$i][$j]['name'] = $tmp_comment_name;
							$comment_list[$i][$j]['avatar'] = $tmp_comment_avatar;
							$comment_list[$i][$j]['splited_date'] = PublicMethod::splitDate($tmp_comment_mbctimestamp);
						
						}
					}
				}
				echo json_encode(array("status" => TRUE, "msg" => "获取留言与评论成功", "cur_avatar" => $cur_avatar,
                        "base_url" => base_url(),
						"site_url" => site_url(), "post_list" => $post_list, "comment_list" => $comment_list));
				return;
			}
		}
	}
	
	/**
	 * 发布工作通知
	 */
	public function addNotice() {
		if (isset($_SESSION['user_id'])) {
			$uid = $_SESSION['user_id'];
			$user_obj = $this->Moa_user_model->get($uid);
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
				$nid = $this->Moa_notice_model->add($notice_paras);
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