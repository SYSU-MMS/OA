<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');


/**
 * 故障报告类
 * @author 高少彬
 */
class Problem extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_room_model');
        $this->load->model('Moa_problem_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_user_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }
    // 
    // public function test() {
    //   $found_time  = "2016-11-22 2:10:18";
    //   $founder_wid  = 108;
    //   $roomid  = 10105;
    //   $description  = "sdad";
    //   $affected_rows = $this->Moa_problem_model->insert($founder_wid, $found_time, $roomid, $description);
    // }
    public function index() {

        if (isset($_SESSION['user_id'])) {

            // 取所有课室的roomid与room（课室编号）
            $state          = 0;
            $room_obj_list  = $this->Moa_room_model->get_by_state($state);

            for ($i = 0; $i < count($room_obj_list); $i++) {

                $roomid_list[$i]    = $room_obj_list[$i]->roomid;
                $room_list[$i]      = $room_obj_list[$i]->room;
            }

            $data['roomid_list']    = $roomid_list;
            $data['room_list']      = $room_list;

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
            $obj = $this->Moa_problem_model->get_all(); /*获取所有problem的信息*/
            if ($obj == FALSE) {
                $data['problem_list'] = array();
                $this->load->view('view_problem', $data);
                return;
            }

            $data['problem_list'] = $obj;

            $this->load->view('view_problem', $data);


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }

    }

    public function getInformation() {
      // 取所有课室的roomid与room（课室编号）
      $state          = 0;
      $room_obj_list  = $this->Moa_room_model->get_by_state($state);

      for ($i = 0; $i < count($room_obj_list); $i++) {
          $roomid_list[$i]    = $room_obj_list[$i]->roomid;
          $room_list[$i]      = $room_obj_list[$i]->room;
      }

      $data['roomid_list']    = $roomid_list;
      $data['room_list']      = $room_list;

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

      echo json_encode(array("status" => TRUE, "msg" => "获取课室等信息成功", "data" => $data));
      return ;
    }
    public function statistics() {

        if (isset($_SESSION['user_id'])) {
            date_default_timezone_set('PRC');

            // 取所有课室的roomid与room（课室编号）
            $state          = 0;
            $room_obj_list  = $this->Moa_room_model->get_by_state($state);

            for ($i = 0; $i < count($room_obj_list); $i++) {

                $roomid_list[$i]    = $room_obj_list[$i]->roomid;
                $room_list[$i]      = $room_obj_list[$i]->room;
            }

            $data['roomid_list']    = $roomid_list;
            $data['room_list']      = $room_list;

            $obj = $this->Moa_problem_model->get_all_statistics();

            if ($obj == FALSE) {
                //没有收到数据，则把list置为空
                $data['statistics_list'] = array();
                $this->load->view('view_problem_statistics', $data);
                return;
            }

            $data['statistics_list'] = $obj;

            $this->load->view('view_problem_statistics', $data);
            // $this->load->view('view_other_personal_data', $obj);
        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status"=>FALSE, "msg"=>"未登陆"));
        }

    }
    public function getAllProblem() {
        if (isset($_SESSION['user_id'])) {

            //room | pid | founder_wid | founder_name | solve_wid | solve_name | roomid | description | solution| found_time| state | solved_time
            $obj = $this->Moa_problem_model->get_all(); /*获取所有problem的信息*/
            if ($obj == FALSE) {return;}
            // $this->load->view('view_other_personal_data', $obj);
        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status"=>FALSE, "msg"=>"未登陆"));
        }
    }



    public function insertProblem() {
        if (isset($_SESSION['user_id'])) {
          date_default_timezone_set('PRC');

            $founder_wid = date($_POST['founder_wid']);
            $found_time  = $_POST['found_time'];
            $roomid      = $_POST['roomid'];
            $description = $_POST['description'];

            $affected_rows = $this->Moa_problem_model->insert($founder_wid, $found_time, $roomid, $description);
            if($affected_rows > 0)
              echo json_encode(array("status"=>TRUE, "msg"=>"新建故障信息成功"));
            else
              echo json_encode(array("status"=>FALSE, "msg"=>"新建故障信息失败"));

        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status"=>FALSE, "msg"=>"未登陆"));
        }

    }

    public function updateProblem() {
        if (isset($_SESSION['user_id'])) {

            $pid            = $_POST['pid'];
            $solved_time    = $_POST['solved_time'];
            $solve_wid      = $_POST['solve_wid'];
            $solution       = $_POST['solution'];

            $affected_rows = $this->Moa_problem_model->update($pid, $solved_time, $solve_wid, $solution);
            if($affected_rows > 0)
              echo json_encode(array("status"=>TRUE, "msg"=>"更新成功"));
            else
              echo json_encode(array("status"=>FALSE, "msg"=>"更新失败"));
        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status"=>FALSE, "msg"=>"未登陆"));
        }

    }

    public function getStatistics() {
        if (isset($_SESSION['user_id'])) {

            $data = $this->Moa_problem_model->get_all_statistics();

        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status"=>FALSE, "msg"=>"未登陆"));
        }

    }


    public function getStatisticsByTime() {
        if (isset($_SESSION['user_id'])) {

            $start_time  = $_POST['start_time'];
            $end_time    = $_POST['end_time'];

            $data = $this->Moa_problem_model->get_statistics_by_time($start_time, $end_time);
            if($data)
              echo json_encode(array("status" => TRUE, "msg" => "获取统计信息成功", "data" => $data));
            else
              echo json_encode(array("status" => FALSE, "msg" => "该阶段无故障信息"));
            return ;
        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status"=>FALSE, "msg"=>"未登陆"));
        }

    }

    public function deleteProblem() {
        if (isset($_SESSION['user_id'])) {

            $pid = $_POST['pid'];
            $affected_rows = $this->Moa_problem_model->delete_by_id($pid);
            if($affected_rows > 0)
              echo json_encode(array("status"=>TRUE, "msg"=>"删除成功"));
            else
              echo json_encode(array("status"=>FALSE, "msg"=>"删除失败"));
        } else {
            // 未登录的用户请先登录
            echo json_encode(array("status"=>FALSE, "msg"=>"未登陆"));
        }

    }
}
