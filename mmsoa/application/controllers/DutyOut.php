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
            if ($_SESSION['level'] != 2 && $_SESSION['level'] != 3 && $_SESSION['level'] != 5 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }
            
            $dutyout_list = $this->Moa_dutyout_model->get_all();

            echo "<script>console.log('$dutyout_list[0]')</script>";


            $d_doid = $dutyout_list['doid'];
            $d_dutyid = $dutyout_list['dutyid'];
            $d_wid = $dutyout_list['wid'];
            $d_week = $dutyout_list['weekcount'];
            $d_outtime = $dutyout_list['outtimestamp'];
            $d_roomid = $dutyout_list['roomid'];
            $d_problemid = $dutyout_list['problemid'];
            $d_problem = $this->Moa_problem_model->get($d_problemid);
            $d_solvewid = $d_problem['solve_wid'];
            $d_description = $d_problem['description'];
            $d_solution = $d_problem['solution'];
            $d_uid = $this->Moa_worker_model->get_uid_by_wid($d_wid);
            $d_user = $this->Moa_user_model->get($d_uid);
            $d_name = $d_user['name'];
            $d_solvename = "";
            if ($d_solvewid != null || $d_solvewid >= 0) {
                $d_solveuid = $this->Moa_worker_model->get_uid_by_wid($d_solvewid);
                $d_solveuser = $this->Moa_user_model->get($d_solveuid);
                $d_solvename = $d_solveuser['name'];
            }


            $data = array();
            $data['d_doid'] = $d_doid;
            $data['d_dutyid'] = $d_dutyid;
            $data['d_wid'] = $d_wid;
            $data['d_week'] = $d_week;
            $data['d_outtime'] = $d_outtime;
            $data['d_roomid'] = $d_roomid;
            $data['d_problemid'] = $d_problemid;
            $data['d_solvewid'] = $d_solvewid;
            $data['d_description'] = $d_description;
            $data['d_solution'] = $d_solution;
            $data['d_name'] = $d_name;
            $data['d_solvename'] = $d_solvename;

            $this->load->view('view_duty_out', $data);

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

}