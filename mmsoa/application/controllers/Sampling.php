<?php
/**
 * User: alcanderian
 */

Class Notify extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_sampling_model');
        $this->load->model('Moa_school_term_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    /**
     * 进入管理页面
     */
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $this->load->view('view_sampling');
        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function newTable() {
        if (isset($_SESSION['user_id'])) {
            // 检查权限
            if ($_SESSION['level'] != 1 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }
            $today = date("Y-m-d H:i:s");
            $week = 0;
            if(isset($_POST['week'])) {
                $week = $_POST['week'];
            } else {
                $term = $this->Moa_school_term_model->get_this_term();
                $week = PublicMethod::get_week($term['termbeginstamp'], $today);
            }

            $group_a = $this->Moa_worker_model->get_by_group_and_level(1, 0);
            $group_b = $this->Moa_worker_model->get_by_group_and_level(2, 0);

            $table_list = array();
            if(isset($group_a) && isset($group_b)) {

                $len_a = count($group_a, COUNT_NORMAL);
                $len_b = count($group_a, COUNT_NORMAL);

                for($i = 0; $i < $len_a; ++$i) {
                    $table_list[$i] = array(
                        'state' => 0, 'timestamp' => $today,
                        'target_uid' => $group_a[$i]['uid'],
                        'on_use' => 1);
                }
                for($i = 0; $i < $len_b; ++$i) {
                    $table_list[$i + $len_a] = array(
                        'state' => 0, 'timestamp' => $today,
                        'target_uid' => $group_a[$i + $len_a]['uid'],
                        'on_use' => 1);
                }

                $res = $this->Moa_sampling_model->add_new_table($table_list);

                if($res === false) {
                    return json_encode(array("status" => FALSE, "msg" => "创建表单失败"));
                } else {
                    return json_encode(array("status" => TRUE, "msg" => "创建表单成功"));
                }


            } else {
                return json_encode(array("status" => FALSE, "msg" => "获取用户列表失败"));
            }

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
            return;
        }
    }

    /**
     * 獲取抽查表的列表
     */
    public function getTableList() {
        if (isset($_SESSION['user_id'])) {
            // 检查权限
            if ($_SESSION['level'] != 1 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
            return;
        }
    }

    /**
     * 獲取一個抽查表
     */
    public function getTable() {
        if (isset($_SESSION['user_id'])) {
            // 检查权限
            if ($_SESSION['level'] != 1 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
            return;
        }
    }

    /**
     * 偽刪除一個抽查表
     */
    public function deleteTable() {
        if (isset($_SESSION['user_id'])) {
            // 检查权限
            if ($_SESSION['level'] != 1 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
            return;
        }
    }

    /**
     * 更新一條抽查記錄
     */
    public function upDateRecord() {
        if (isset($_SESSION['user_id'])) {
            // 检查权限
            if ($_SESSION['level'] != 1) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
            return;
        }
    }
}