<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 主页控制类
 * @author 伟
 */
Class Homepage extends CI_Controller
{
    public function __construct()
    {
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
    public function index()
    {
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
    public function addPost()
    {
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
                $board_paras['body'] = htmlspecialchars($_POST['post_content']);
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
    public function addComment()
    {
        if (isset($_SESSION['user_id'])) {
            $uid = $_SESSION['user_id'];
            $user_obj = $this->Moa_user_model->get($uid);
            $name = $user_obj->name;
            $avatar = $user_obj->avatar;
            if (isset($_POST['ruid'])) {
                $ruid = $_POST['ruid'];
            } else {
                $ruid = 0;
            }

            // 添加新评论
            if (isset($_POST['comment_content']) && isset($_POST['post_id'])) {
                // state：0-正常  1-已删除
                $comment_paras['state'] = 0;
                $comment_paras['uid'] = $uid;
                $comment_paras['bpid'] = $_POST['post_id'];
                $timestamp = date('Y-m-d H:i:s');
                $comment_paras['mbctimestamp'] = $timestamp;
                $comment_paras['body'] = htmlspecialchars($_POST['comment_content']);
                $comment_paras['ruid'] = $ruid;
                if ($ruid > 0) {
                    $tmp_comment_user_rpl = $this->Moa_user_model->get($ruid);
                    $ruser = $tmp_comment_user_rpl->name;
                } else {
                    $ruser = "";
                }
                $mbcid = $this->Moa_mbcomment_model->add($comment_paras);
                if ($mbcid == FALSE) {
                    echo json_encode(array("status" => FALSE, "msg" => "评论失败"));
                    return;
                } else {
                    $splited_date = PublicMethod::splitDate($timestamp);
                    echo json_encode(array("status" => TRUE, "msg" => "评论成功", "name" => $name, "avatar" => $avatar,
                        "splited_date" => $splited_date, "mbcid" => $mbcid, "base_url" => base_url(),
                        "site_url" => site_url(), "myid" => $uid, "ruid" => $ruid, "ruser" => $ruser));
                    return;
                }
            }
        }
    }

    /**
     * 取留言与对应的评论
     * @param $offset 取x条以后的数据
     */
    public function getPostComment()
    {
        if (isset($_SESSION['user_id'])) {
            // 获取当前用户的头像，用于评论区
            $current_user = $this->Moa_user_model->get($_SESSION['user_id']);
            $cur_avatar = $current_user->avatar;
            if (isset($_GET['base_date'])) {
                $base_date = $_GET['base_date'];
                $offset = $_GET['offset'];
                // 0表示当前时间
                if ($_GET['base_date'] == '0') {
                    $base_date = date('Y-m-d H:i:s');
                }
                $post_state = 0;
                $post_num = 15;
                // 每次最多取指定时间之前的15条留言
                $post_obj_list = $this->Moa_mmsboard_model->get_by_date($base_date, $post_state, $post_num, $offset);

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
                    $tmp_post_deletable = $tmp_post_uid == $current_user->uid || $current_user->level >= 2;

                    // 前端渲染所用数据
                    $post_list[$i]['myid'] = $tmp_post_uid;
                    $post_list[$i]['bpid'] = $tmp_post_bpid;
                    $post_list[$i]['bptimestamp'] = $tmp_post_bptimestamp;
                    $post_list[$i]['body'] = $tmp_post_body;
                    $post_list[$i]['name'] = $tmp_post_name;
                    $post_list[$i]['avatar'] = $tmp_post_avatar;
                    $post_list[$i]['splited_date'] = PublicMethod::splitDate($tmp_post_bptimestamp);
                    $post_list[$i]['deletable'] = $tmp_post_deletable;

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
                            $tmp_comment_mbcid = $comment_obj_list[$j]->mbcid;
                            $tmp_comment_ruid = $comment_obj_list[$j]->ruid;
                            $tmp_comment_ruser = "";
                            $tmp_comment_deletable = $tmp_comment_user_obj->uid == $current_user->uid || $current_user->level >= 2;

                            if ($tmp_comment_ruid > 0) {
                                $tmp_comment_user_rpl = $this->Moa_user_model->get($tmp_comment_ruid);
                                $tmp_comment_ruser = $tmp_comment_user_rpl->name;
                            }

                            // 前端渲染所用数据
                            $comment_list[$i][$j]['myid'] = $tmp_comment_uid;
                            $comment_list[$i][$j]['body'] = $tmp_comment_body;
                            $comment_list[$i][$j]['name'] = $tmp_comment_name;
                            $comment_list[$i][$j]['avatar'] = $tmp_comment_avatar;
                            $comment_list[$i][$j]['splited_date'] = PublicMethod::splitDate($tmp_comment_mbctimestamp);
                            $comment_list[$i][$j]['mbcid'] = $tmp_comment_mbcid;
                            $comment_list[$i][$j]['ruid'] = $tmp_comment_ruid;
                            $comment_list[$i][$j]['ruser'] = $tmp_comment_ruser;
                            $comment_list[$i][$j]['deletable'] = $tmp_comment_deletable;

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

    /**获取更多评论
     *
     */
    public function getMoreComment($bpid, $offset)
    {
        if (isset($_SESSION['user_id'])) {
            // 获取当前用户的头像，用于评论区
            $current_user = $this->Moa_user_model->get($_SESSION['user_id']);
            $cur_avatar = $current_user->avatar;
            //$bpid=$_POST['bpid'];
            //error_log($bpid,0);
            //$offset=$_POST['offset'];

            $post_obj_list = $this->Moa_mmsboard_model->get($bpid);

            if (empty($post_obj_list)) {
                echo json_encode(array("status" => FALSE, "msg" => "获取留言失败"));
                return;
            }

            $post_list = array();
            $comment_list = array();

            for ($i = 0; $i < count($post_obj_list); $i++) {
                $tmp_post_bpid = $post_obj_list->bpid;
                $tmp_post_uid = $post_obj_list->uid;
                $tmp_post_bptimestamp = $post_obj_list->bptimestamp;
                $tmp_post_body = $post_obj_list->body;
                $tmp_post_user_obj = $this->Moa_user_model->get($tmp_post_uid);
                $tmp_post_name = $tmp_post_user_obj->name;
                $tmp_post_avatar = $tmp_post_user_obj->avatar;
                $tmp_post_deletable = $tmp_post_uid == $current_user->uid || $current_user->level >= 2;

                // 前端渲染所用数据
                $post_list[$i]['myid'] = $tmp_post_uid;
                $post_list[$i]['bpid'] = $tmp_post_bpid;
                $post_list[$i]['bptimestamp'] = $tmp_post_bptimestamp;
                $post_list[$i]['body'] = $tmp_post_body;
                $post_list[$i]['name'] = $tmp_post_name;
                $post_list[$i]['avatar'] = $tmp_post_avatar;
                $post_list[$i]['splited_date'] = PublicMethod::splitDate($tmp_post_bptimestamp);
                $post_list[$i]['deletable'] = $tmp_post_deletable;

                // 取该留言对应的评论
                $comment_state = 0;
                $nums = 10;
                $comment_obj_list = $this->Moa_mbcomment_model->get_by_bpid($tmp_post_bpid, $comment_state, $nums, $offset);

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
                        $tmp_comment_mbcid = $comment_obj_list[$j]->mbcid;
                        $tmp_comment_ruid = $comment_obj_list[$j]->ruid;
                        $tmp_comment_ruser = "";
                        $tmp_comment_deletable = $tmp_comment_uid == $current_user->uid || $current_user->level >= 2;

                        if ($tmp_comment_ruid > 0) {
                            $tmp_comment_user_rpl = $this->Moa_user_model->get($tmp_comment_ruid);
                            $tmp_comment_ruser = $tmp_comment_user_rpl->name;
                        }

                        // 前端渲染所用数据
                        $comment_list[$i][$j]['myid'] = $tmp_comment_uid;
                        $comment_list[$i][$j]['body'] = $tmp_comment_body;
                        $comment_list[$i][$j]['name'] = $tmp_comment_name;
                        $comment_list[$i][$j]['avatar'] = $tmp_comment_avatar;
                        $comment_list[$i][$j]['splited_date'] = PublicMethod::splitDate($tmp_comment_mbctimestamp);
                        $comment_list[$i][$j]['mbcid'] = $tmp_comment_mbcid;
                        $comment_list[$i][$j]['ruid'] = $tmp_comment_ruid;
                        $comment_list[$i][$j]['ruser'] = $tmp_comment_ruser;
                        $comment_list[$i][$j]['deletable'] = $tmp_comment_deletable;

                    }
                }
            }
            echo json_encode(array("status" => TRUE, "msg" => "获取留言与评论成功", "cur_avatar" => $cur_avatar,
                "base_url" => base_url(),
                "site_url" => site_url(), "post_list" => $post_list, "comment_list" => $comment_list));
            return;
            //}
        }
    }

    /**获取所有评论
     *
     */
    public function getAllComment($bpid, $offset)
    {
        if (isset($_SESSION['user_id'])) {
            // 获取当前用户的头像，用于评论区
            $current_user = $this->Moa_user_model->get($_SESSION['user_id']);
            $cur_avatar = $current_user->avatar;
            //$bpid=$_POST['bpid'];
            //error_log($bpid,0);
            //$offset=$_POST['offset'];

            $post_obj_list = $this->Moa_mmsboard_model->get($bpid);

            if (empty($post_obj_list)) {
                echo json_encode(array("status" => FALSE, "msg" => "获取留言失败"));
                return;
            }

            $post_list = array();
            $comment_list = array();

            for ($i = 0; $i < count($post_obj_list); $i++) {
                $tmp_post_bpid = $post_obj_list->bpid;
                $tmp_post_uid = $post_obj_list->uid;
                $tmp_post_bptimestamp = $post_obj_list->bptimestamp;
                $tmp_post_body = $post_obj_list->body;
                $tmp_post_user_obj = $this->Moa_user_model->get($tmp_post_uid);
                $tmp_post_name = $tmp_post_user_obj->name;
                $tmp_post_avatar = $tmp_post_user_obj->avatar;
                $tmp_post_deletable = $tmp_post_uid == $current_user->uid || $current_user->level >= 2;

                // 前端渲染所用数据
                $post_list[$i]['myid'] = $tmp_post_uid;
                $post_list[$i]['bpid'] = $tmp_post_bpid;
                $post_list[$i]['bptimestamp'] = $tmp_post_bptimestamp;
                $post_list[$i]['body'] = $tmp_post_body;
                $post_list[$i]['name'] = $tmp_post_name;
                $post_list[$i]['avatar'] = $tmp_post_avatar;
                $post_list[$i]['splited_date'] = PublicMethod::splitDate($tmp_post_bptimestamp);
                $post_list[$i]['deletable'] = $tmp_post_deletable;

                // 取该留言对应的评论
                $comment_state = 0;
                $nums = 999999999;
                $comment_obj_list = $this->Moa_mbcomment_model->get_by_bpid($tmp_post_bpid, $comment_state, $nums, $offset);

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
                        $tmp_comment_mbcid = $comment_obj_list[$j]->mbcid;
                        $tmp_comment_ruid = $comment_obj_list[$j]->ruid;
                        $tmp_comment_ruser = "";
                        $tmp_comment_deletable = $tmp_comment_uid == $current_user->uid || $current_user->level >= 2;

                        if ($tmp_comment_ruid > 0) {
                            $tmp_comment_user_rpl = $this->Moa_user_model->get($tmp_comment_ruid);
                            $tmp_comment_ruser = $tmp_comment_user_rpl->name;
                        }

                        // 前端渲染所用数据
                        $comment_list[$i][$j]['myid'] = $tmp_comment_uid;
                        $comment_list[$i][$j]['body'] = $tmp_comment_body;
                        $comment_list[$i][$j]['name'] = $tmp_comment_name;
                        $comment_list[$i][$j]['avatar'] = $tmp_comment_avatar;
                        $comment_list[$i][$j]['splited_date'] = PublicMethod::splitDate($tmp_comment_mbctimestamp);
                        $comment_list[$i][$j]['mbcid'] = $tmp_comment_mbcid;
                        $comment_list[$i][$j]['ruid'] = $tmp_comment_ruid;
                        $comment_list[$i][$j]['ruser'] = $tmp_comment_ruser;
                        $comment_list[$i][$j]['deletable'] = $tmp_comment_deletable;

                    }
                }
            }
            echo json_encode(array("status" => TRUE, "msg" => "获取留言与评论成功", "cur_avatar" => $cur_avatar,
                "base_url" => base_url(),
                "site_url" => site_url(), "post_list" => $post_list, "comment_list" => $comment_list));
            return;
            //}
        }
    }

    /**
     * 发布工作通知
     */
    public function addNotice()
    {
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

    /**删除留言
     * @param $bpid
     */
    public function deletePost($bpid)
    {
        $deletingPost = $this->Moa_mmsboard_model->get($bpid);
        $current_uid = $_SESSION['user_id'];
        $current_level = $this->Moa_user_model->get($current_uid)->level;
        if ($deletingPost->uid == $current_uid || $current_level >= 2) {
            $this->Moa_mmsboard_model->delete($bpid);
            echo json_encode(array("status" => TRUE, "msg" => "删除成功"));
        } else {
            echo json_encode(array("status" => FALSE, "msg" => "删除失败"));
        }
    }

    /**删除评论
     * @param $mbcid
     */
    public function deleteComment($mbcid)
    {
        $deletingComment = $this->Moa_mbcomment_model->get($mbcid);
        $current_uid = $_SESSION['user_id'];
        $current_level = $this->Moa_user_model->get($current_uid)->level;
        if ($deletingComment->uid == $current_uid || $current_level >= 2) {
            $this->Moa_mbcomment_model->delete($mbcid);
            echo json_encode(array("status" => TRUE, "msg" => "删除成功"));
        } else {
            json_encode(array("status" => FALSE, "msg" => "删除失败"));
        }
    }

}