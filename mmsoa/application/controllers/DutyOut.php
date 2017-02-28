<?php
/**
 * Created by PhpStorm.
 * User: Jerry
 * Date: 2016/11/17
 * Time: 下午3:58
 * By 钟凌山
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

            //取课室列表
            $state = 0;
            $room_obj_list = $this->Moa_room_model->get_by_state($state);

            for ($i = 0; $i < count($room_obj_list); $i++) {

                $roomid_list[$i] = $room_obj_list[$i]->roomid;
                $room_list[$i] = $room_obj_list[$i]->room;
            }

            $data['roomid_list'] = $roomid_list;
            $data['room_list'] = $room_list;

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


            //room | pid | founder_wid | founder_name | solve_wid | solve_name | roomid | description | solution| found_time| state | solved_time
            $obj = $this->Moa_problem_model->get_unsolve(); /*获取所有未解决的problem的信息*/
            if ($obj == FALSE) {
                $data['problem_list'] = array();
                $data['problemid_list'] = array();
            } else {
                //$data['problem_list'] = $obj->description;
                //$data['problemid_list'] = $obj->pid;
                for ($i = 0; $i < count($obj); $i++) {
                    $data['problem_list'][$i] = $obj[$i]->description;
                    $data['problemid_list'][$i] = $obj[$i]->pid;
                }
            }

            for ($i = 0; $i < count($dutyout_list); $i++) {
                //取出勤id
                $d_doid = $dutyout_list[$i]->doid;
                //值班时段id
                $d_dutyid = $dutyout_list[$i]->dutyid;
                $d_duty = $this->Moa_duty_model->get_by_id($d_dutyid);
                //var_dump($d_duty);
                //星期
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

            //echo "<script>console.log(" . json_encode($data) . ")</script>";

            $this->load->view('view_duty_out', $data);

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function add()
    {
        if (isset($_SESSION['user_id']) && isset($_POST['wid'])) {
            $wid = $_POST['wid'];
            $dutyid = $_POST['dutyid'];
            $pid = $_POST['problemid'];
            $result = $this->Moa_dutyout_model->add($wid, $pid, $dutyid);
            //echo "<script>console.log($result);alert();</script>";
            if ($result > 0) {
                echo json_encode(array("status" => true, "msg" => "添加成功！", "doid" => $result));
            } else {
                echo json_encode(array("status" => false, "msg" => "添加失败！"));
            }
        } else {
            echo json_encode(array("status" => false, "msg" => "添加失败！"));
        }
    }

    public function update()
    {
        if (isset($_SESSION['user_id']) && isset($_POST['doid']) && isset($_POST['wid']) && isset($_POST['solve_time'])) {
            $doid = $_POST['doid'];
            $pid = $this->Moa_dutyout_model->get_by_doid($doid)->pid;
            $wid = $_POST['wid'];
            $solve_time = $_POST['solve_time'];
            $solution = $_POST['solution'];
            $result = $this->Moa_problem_model->update($pid, $solve_time, $wid, $solution);
            if (result > 0) {
                echo json_encode(array("status" => true, "msg" => "已解决！"));
            } else {
                echo json_encode(array("status" => true, "msg" => "更新失败！"));
            }
        } else {
            echo json_encode(array("status" => true, "msg" => "更新失败！"));
        }
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

    public function getInformation()
    {
        // 取所有课室的roomid与room（课室编号）
        $state = 0;
        $room_obj_list = $this->Moa_room_model->get_by_state($state);

        for ($i = 0; $i < count($room_obj_list); $i++) {
            $roomid_list[$i] = $room_obj_list[$i]->roomid;
            $room_list[$i] = $room_obj_list[$i]->room;
        }

        $data['roomid_list'] = $roomid_list;
        $data['room_list'] = $room_list;

        $common_worker = $this->Moa_user_model->get(0);

        for ($i = 0; $i < count($common_worker); $i++) {
            $uid_list[$i] = $common_worker[$i]->uid;
            $name_list[$i] = $common_worker[$i]->name;
            $wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
        }

        $data['name_list'] = $name_list;
        $data['wid_list'] = $wid_list;

        $obj = $this->Moa_problem_model->get_unsolve(); /*获取所有未解决的problem的信息*/
        if ($obj == FALSE) {
            $data['problem_list'] = array();
            $data['problemid_list'] = array();
        } else {
            for ($i = 0; $i < count($obj); $i++) {
                $data['problem_list'][$i] = $obj[$i]->description;
                $data['problemid_list'][$i] = $obj[$i]->pid;
            }
        }

        //获取所有值班时段信息
        $duty = $this->Moa_duty_model->get_all();
        for ($i = 0; $i < count($duty); $i++) {
            $dutyid_list[$i] = $duty[$i]->dutyid;
            $weekday_list[$i] = PublicMethod::translate_weekday($duty[$i]->weekday);
            $period_list[$i] = PublicMethod::get_duty_duration($duty[$i]->period);
        }
        $data['dutyid_list'] = $dutyid_list;
        $data['weekday_list'] = $weekday_list;
        $data['period_list'] = $period_list;

        echo json_encode(array("status" => TRUE, "msg" => "获取课室等信息成功", "data" => $data));
        return;
    }

    //插入新problem
    public function insertProblem()
    {
        if (isset($_SESSION['user_id'])) {
            date_default_timezone_set('PRC');

            $founder_wid = date($_POST['founder_wid']);
            $found_time = $_POST['found_time'];
            $roomid = $_POST['roomid'];
            $description = $_POST['description'];

            $insert_id = $this->Moa_dutyout_model->insert($founder_wid, $found_time, $roomid, $description);
            if ($insert_id > 0)
                echo json_encode(array("status" => TRUE, "msg" => "新建故障信息成功", "insert_id" => $insert_id));
            else
                echo json_encode(array("status" => FALSE, "msg" => "新建故障信息失败"));

        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status" => FALSE, "msg" => "未登陆"));
        }

    }

    //更新Problem状态
    public function updateProblem()
    {
        if (isset($_SESSION['user_id'])) {

            $pid = $_POST['pid'];
            $solved_time = $_POST['solved_time'];
            $solve_wid = $_POST['solve_wid'];
            $solution = $_POST['solution'];

            $affected_rows = $this->Moa_problem_model->update($pid, $solved_time, $solve_wid, $solution);
            if ($affected_rows > 0)
                echo json_encode(array("status" => TRUE, "msg" => "更新成功"));
            else
                echo json_encode(array("status" => FALSE, "msg" => "更新失败"));
        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status" => FALSE, "msg" => "未登陆"));
        }

    }

    public function getDutyIdByPeriod()
    {
        if (isset($_SESSION['user_id'])) {
            $weekday = $_POST['weekday'];
            $period = $_POST['period'];
            $result = $this->Moa_duty_model->get_by_day_and_period($weekday, $period);
            echo json_encode(array('status' => true, 'dutyid' => $result->dutyid));
        } else {
            echo json_encode(array('status' => false));
        }
    }

}