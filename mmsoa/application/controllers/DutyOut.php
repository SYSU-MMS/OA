<?php
/**
 * Created by PhpStorm.
 * User: Jerry
 * Date: 2016/11/17
 * Time: 下午3:58
 */
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

class DutyOut extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_problem_model');
        $this->load->model('Moa_room_model');
        $this->load->model('Moa_duty_model');
        $this->load->model('Moa_dutyout_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            // 检查权限: 2-负责人助理 3-助理负责人 5-办公室负责人 6-超级管理员
            //if ($_SESSION['level'] != 2 && $_SESSION['level'] != 3 && $_SESSION['level'] != 5 && $_SESSION['level'] != 6) {
            // 提示权限不够
            //    PublicMethod::permissionDenied();
            //}

            $dutyout_list = $this->Moa_dutyout_model->get_all(1);

            //echo $dutyout_list;
            //var_dump($dutyout_list);

            $data = array();
            $data['d_doid'] = array();
            $data['d_dutyid'] = array();
            $data['d_weekday'] = array();
            $data['d_weekdaytranslate'] = array();
            $data['d_periodtime'] = array();
            $data['d_wid'] = array();
            $data['d_uid'] = array();
            //$data['d_level'] = array();
            $data['d_week'] = array();
            $data['d_outtime'] = array();
            $data['d_roomid'] = array();
            $data['d_room'] = array();
            $data['d_problemid'] = array();
            $data['d_solvewid'] = array();
            $data['d_description'] = array();
            $data['d_solution'] = array();
            $data['d_name'] = array();
            $data['d_solvename'] = array();
            $data['d_solvetime'] = array();

            for ($i = 0; $i < count($dutyout_list); $i++) {
                $d_doid = $dutyout_list[$i]->doid;

                $d_dutyid = $dutyout_list[$i]->dutyid;
                $d_duty = $this->Moa_duty_model->get_by_id($d_dutyid);
                //var_dump($d_duty);
                $d_weekday = $d_duty->weekday;
                $d_weekdaytranslate = PublicMethod::translate_weekday($d_weekday);
                $d_period = $d_duty->period;
                $d_periodtime = PublicMethod::get_duty_duration($d_period);

                $d_wid = $dutyout_list[$i]->wid;
                $d_week = $dutyout_list[$i]->weekcount;
                $d_outtime = $dutyout_list[$i]->outtimestamp;

                $d_roomid = $dutyout_list[$i]->roomid;
                $d_room = $this->Moa_room_model->get($d_roomid)->room;

                $d_problemid = $dutyout_list[$i]->problemid;
                $d_problem = $this->Moa_problem_model->get($d_problemid);
                $d_solvewid = $d_problem->solve_wid;
                $d_description = $d_problem->description;
                $d_solution = $d_problem->solution;
                $d_solvetime = $d_problem->solved_time;

                $d_uid = $this->Moa_worker_model->get_uid_by_wid($d_wid);
                $d_user = $this->Moa_user_model->get($d_uid);
                $d_name = $d_user->name;
                //$d_level = $this->Moa_user_model->get($_SESSION['user_id'])->level;
                $d_solvename = "";

                if ($d_solvewid != null && $d_solvewid != false) {
                    $d_solveuid = $this->Moa_worker_model->get_uid_by_wid($d_solvewid);
                    $d_solveuser = $this->Moa_user_model->get($d_solveuid);
                    $d_solvename = $d_solveuser->name;
                    //var_dump($d_solveuid);
                    //var_dump($d_solveuser);
                } else {
                    $d_solvewid = false;
                    $d_solvename = false;
                    $d_solvetime = false;
                    //$d_description = false;
                    $d_solution = false;
                }


                //$data = array();
                $data['d_doid'][$i] = $d_doid;
                $data['d_dutyid'][$i] = $d_dutyid;
                $data['d_weekday'][$i] = $d_weekday;
                $data['d_weekdaytranslate'][$i] = $d_weekdaytranslate;
                $data['d_periodtime'][$i] = $d_periodtime;
                $data['d_wid'][$i] = $d_wid;
                $data['d_uid'][$i] = $d_uid;
                //$data['d_level'][$i] = $d_level;
                $data['d_week'][$i] = $d_week;
                $data['d_outtime'][$i] = $d_outtime;
                $data['d_roomid'][$i] = $d_roomid;
                $data['d_room'][$i] = $d_room;
                $data['d_problemid'][$i] = $d_problemid;
                $data['d_solvewid'][$i] = $d_solvewid;
                $data['d_description'][$i] = $d_description;
                $data['d_solution'][$i] = $d_solution;
                $data['d_name'][$i] = $d_name;
                $data['d_solvename'][$i] = $d_solvename;
                $data['d_solvetime'][$i] = $d_solvetime;
            }

            echo "<script>console.log(" . json_encode($data) . ")</script>";

            $this->load->view('view_duty_out', $data);

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function add($paras)
    {

    }

    public function update($doid, $paras)
    {

    }

    public function delete_dutyout()
    {
        if (isset($_POST['doid'])) {
            $doid = $_POST['doid'];
            $deleting_record = $this->Moa_dutyout_model->get_by_doid($doid);
            $deleting_record_uid = $this->Moa_worker_model->get_uid_by_wid($deleting_record->wid);
            $current_uid = $_SESSION['user_id'];
            $current_level = $this->Moa_user_model->get($current_uid)->level;
            if ($deleting_record_uid == $current_uid || $current_level >= 2) {
                $state = $this->Moa_dutyout_model->delete_by_doid($doid);
                if ($state == true) {
                    echo json_encode(array("status" => true, "msg" => "已删除！"));
                } else {
                    echo json_encode(array("status" => false, "msg" => "删除失败！"));
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "删除失败！"));
            }
        }
    }

}