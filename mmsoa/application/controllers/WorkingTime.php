<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 工时控制类
 * @author 伟
 */
Class WorkingTime extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    public function index()
    {

    }


    /**
     * 全员（办公室负责人及管理员除外）工时统计
     */
    public function allWorkingTime()
    {
        if (isset($_SESSION['user_id'])) {
            // 检查权限: 2-负责人助理 3-助理负责人 5-办公室负责人 6-超级管理员
            if ($_SESSION['level'] != 2 && $_SESSION['level'] != 3 && $_SESSION['level'] != 5 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }

            // level: 0-普通助理 1-组长 2-负责人助理 3-助理负责人
            $level_arr = array('0', '1', '2', '3');
            // 正常有效记录
            $state = 0;
            $u_obj_list = $this->Moa_user_model->get_by_multiple_level($level_arr, $state);

            $w_wid_list = array();
            $u_name_list = array();
            $u_card_list = array();
            $u_phone_list = array();
            $u_total_contri_list = array();
            $u_total_salary_list = array();
            $w_month_contri_list = array();
            $w_month_salary_list = array();
            $count = 0;

            if ($u_obj_list != FALSE) {
                for ($count = 0; $count < count($u_obj_list); $count++) {
                    $u_name_list[$count] = $u_obj_list[$count]->name;
                    $tmp_uid = $u_obj_list[$count]->uid;
                    $u_card_list[$count] = $u_obj_list[$count]->creditcard;
                    $u_phone_list[$count] = $u_obj_list[$count]->phone;
                    $tmp_total_contri = $u_obj_list[$count]->contribution;
                    $tmp_total_penalty = $u_obj_list[$count]->totalPenalty;
                    // 历史总实际工时 = 历史总工时 - 历史总扣除工时
                    $tmp_total_real_contri = $tmp_total_contri - $tmp_total_penalty;
                    $u_total_contri_list[$count] = $tmp_total_real_contri;
                    $u_total_salary_list[$count] = PublicMethod::cal_salary($tmp_total_real_contri);
                    // 从Worker表获取本月工时
                    $tmp_wid = $this->Moa_worker_model->get_wid_by_uid($tmp_uid);
                    $tmp_worker_obj = $this->Moa_worker_model->get($tmp_wid);
                    $tmp_month_contri = $tmp_worker_obj->worktime;
                    $tmp_month_penalty = $tmp_worker_obj->penalty;
                    // 本月实际工时 = 本月总工时 - 本月总扣除工时
                    $tmp_month_real_contri = $tmp_month_contri - $tmp_month_penalty;
                    $w_month_contri_list[$count] = $tmp_month_real_contri;
                    $w_month_salary_list[$count] = PublicMethod::cal_salary($tmp_month_real_contri);
                    $w_wid_list[$count] = $tmp_wid;
                }
            }

            $data['count'] = $count;
            $data['wid_list'] = $w_wid_list;
            $data['name_list'] = $u_name_list;
            $data['card_list'] = $u_card_list;
            $data['phone_list'] = $u_phone_list;
            $data['total_contri_list'] = $u_total_contri_list;
            $data['total_salary_list'] = $u_total_salary_list;
            $data['month_contri_list'] = $w_month_contri_list;
            $data['month_salary_list'] = $w_month_salary_list;

            $this->load->view('view_all_time', $data);
        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    /**
     * 个人工时详情
     */
    public function perWorkingTime()
    {
        if (isset($_SESSION['user_id'])) {
            // 检查权限: -1-离职人员 0-普通助理 1-组长 2-负责人助理 3-助理负责人  6-超级管理员
            if ($_SESSION['level'] != -1 && $_SESSION['level'] != 0 && $_SESSION['level'] != 1 &&
                $_SESSION['level'] != 2 && $_SESSION['level'] != 3 && $_SESSION['level'] != 6
            ) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }

            // 入职日期
            $indate = '';
            // 在职年数
            $working_age = '';
            // 银行卡号
            $card = '';
            // 本月实际工时
            $month_contri = 0;
            // 本月被扣工时
            $month_penalty = 0;
            // 本月工资
            $month_salary = 0;
            // 历史累计实际工时
            $total_contri = 0;
            // 历史累计被扣工时
            $total_penalty = 0;
            // 历史累计工资
            $total_salary = 0;

            $uid = $_SESSION['user_id'];
            $user_obj = $this->Moa_user_model->get($uid);

            if ($user_obj != FALSE) {
                $indate = $user_obj->indate;
                $working_age = PublicMethod::cal_working_age($indate);
                $card = $user_obj->creditcard;
                // 历史累计
                $tmp_total_contri = $user_obj->contribution;
                $total_penalty = $user_obj->totalPenalty;
                $total_contri = $tmp_total_contri - $total_penalty;
                $total_salary = PublicMethod::cal_salary($total_contri);
                // 本月
                $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
                $worker_obj = $this->Moa_worker_model->get($wid);
                $tmp_month_contri = $worker_obj->worktime;
                $month_penalty = $worker_obj->penalty;
                $month_contri = $tmp_month_contri - $month_penalty;
                $month_salary = PublicMethod::cal_salary($month_contri);
            }

            $data['indate'] = substr($indate, 0, 10);
            $data['working_age'] = $working_age;
            $data['month_contri'] = $month_contri;
            $data['month_penalty'] = $month_penalty;
            $data['month_salary'] = $month_salary;
            $data['total_contri'] = $total_contri;
            $data['total_penalty'] = $total_penalty;
            $data['total_salary'] = $total_salary;
            $data['card'] = PublicMethod::creditcard_format($card);

            $this->load->view('view_per_time', $data);
        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    /**
     * 工时调整:增加或减少(非扣除)
     */
    public function rewardAndReduce()
    {
        if (isset($_SESSION['user_id'])) {
            // 检查权限: 2-负责人助理 3-助理负责人 5-办公室负责人  6-超级管理员
            if ($_SESSION['level'] != 2 && $_SESSION['level'] != 3 &&
                $_SESSION['level'] != 5 && $_SESSION['level'] != 6
            ) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }

            if (isset($_POST['wid']) && isset($_POST['time_num'])) {

                if (!is_numeric($_POST['time_num'])) {
                    echo json_encode(array("status" => FALSE, "msg" => "奖励失败"));
                    return;
                }
                $wid = $_POST['wid'];
                $uid = $this->Moa_worker_model->get($wid)->uid;
                $ajust_contrib = $_POST['time_num'];

                // 更新工时
                $affected_rows = $this->Moa_worker_model->update_worktime($wid, $ajust_contrib);
                // <s>累计工时仅统计已经结算过的,未结算的工时不计入</s>
                $affected_rows_u = $this->Moa_user_model->update_contribution($uid, $ajust_contrib);

                if ($affected_rows == 0 || $affected_rows_u == 0) {
                    if ($ajust_contrib >= 0) {
                        echo json_encode(array("status" => FALSE, "msg" => "增加失败"));
                    } else {
                        echo json_encode(array("status" => FALSE, "msg" => "减少失败"));
                    }
                    return;
                }

                if ($ajust_contrib >= 0) {
                    echo json_encode(array("status" => TRUE, "msg" => "增加成功"));
                } else {
                    echo json_encode(array("status" => TRUE, "msg" => "减少成功"));
                }
                return;
            }

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    /**
     * 工时扣除(惩罚)
     */
    public function penalty()
    {
        if (isset($_SESSION['user_id'])) {
            // 检查权限: 2-负责人助理 3-助理负责人 5-办公室负责人  6-超级管理员
            if ($_SESSION['level'] != 2 && $_SESSION['level'] != 3 &&
                $_SESSION['level'] != 5 && $_SESSION['level'] != 6
            ) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }

            if (isset($_POST['wid']) && isset($_POST['time_num'])) {

                if (!is_numeric($_POST['time_num'])) {
                    echo json_encode(array("status" => FALSE, "msg" => "扣除失败"));
                    return;
                }
                $wid = $_POST['wid'];
                $uid = $this->Moa_worker_model->get($wid)->uid;
                $ajust_contrib = $_POST['time_num'];

                // 更新工时
                $affected_rows = $this->Moa_worker_model->update_penalty($wid, $ajust_contrib);
                // <s>累计工时仅统计已经结算过的,未结算的工时不计入</s>
                $affected_rows_u = $this->Moa_user_model->update_penalty($uid, $ajust_contrib);

                if ($affected_rows == 0 || $affected_rows_u == 0) {

                    echo json_encode(array("status" => FALSE, "msg" => "扣除失败"));

                    return;
                }


                echo json_encode(array("status" => TRUE, "msg" => "扣除成功"));

                return;
            }

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

}