<?php
/**
 * Created by PhpStorm.
 * User: zhong
 * Date: 2017/9/14
 * Time: 1:56
 */
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');


class Lost extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_lost_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    public function index()
    {
        if (isset($_SESSION['user_id'])) {

            // 原始数据
            $data = array();
            $data['d_lid'] = array();
            $data['d_state'] = array();
            $data['d_lwid'] = array();
            $data['d_signuptime'] = array();
            $data['d_ldatetime'] = array();
            $data['d_ldescription'] = array();
            $data['d_lplace'] = array();
            $data['d_loser'] = array();
            $data['d_lcontact'] = array();
            // 处理后数据
            $data['d_lworkername'] = array();
            $data['d_signup_timestamp'] = array();
            $data['d_signup_date'] = array();
            $data['d_signup_time'] = array();
            $data['d_signup_weekday'] = array();
            $data['d_signup_weekday_translate'] = array();
            $data['d_lost_timestamp'] = array();
            $data['d_lost_date'] = array();
            $data['d_lost_time'] = array();
            $data['d_lost_weekday'] = array();
            $data['d_lost_weekday_translate'] = array();

            // 取所有助理的wid与name
            $common_worker = $this->Moa_user_model->get();
            $uid_list = array();
            $wid_list = array();
            $name_list = array();

            for ($i = 0; $i < count($common_worker); $i++) {
                $uid_list[$i] = $common_worker[$i]->uid;
                $name_list[$i] = $common_worker[$i]->name;
                $wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
            }

            $data['name_list'] = $name_list;
            $data['wid_list'] = $wid_list;

            // 获取所有拾获物品登记信息
            $obj = $this->Moa_lost_model->get_all();
            if ($obj == false){
                NULL;
            }else{
                for ($i = 0; $i < count($obj); $i++){
                    $data['d_lid'][$i] = $obj[$i]->lid;
                    $data['d_state'][$i] = $obj[$i]->state;
                    $data['d_lwid'][$i] = (int)$obj[$i]->lwid;
                    $data['d_signuptime'][$i] = $obj[$i]->signuptime;
                    $data['d_ldatetime'][$i] = $obj[$i]->ldatetime;
                    $data['d_ldescription'][$i] = $obj[$i]->ldescription;
                    $data['d_lplace'][$i] = $obj[$i]->lplace;
                    $data['d_loser'][$i] = $obj[$i]->loser;
                    $data['d_lcontact'][$i] = $obj[$i]->lcontact;

                    $data['d_lworkername'][$i] = $data['d_lwid'][$i] == 0 ? "" :
                        $this->Moa_user_model->get($this->Moa_worker_model->get_uid_by_wid($data['d_lwid'][$i]))->name;
                    $data['d_signup_timestamp'][$i] = strtotime($data['d_signuptime'][$i]);
                    $data['d_signup_date'][$i] = date("Y-m-d", $data['d_signup_timestamp'][$i]);
                    $data['d_signup_time'][$i] = date("H:i", $data['d_signup_timestamp'][$i]);
                    $data['d_signup_weekday'][$i] = date("N", $data['d_signup_timestamp'][$i]);
                    $data['d_signup_weekday_translate'][$i] = PublicMethod::translate_weekday($data['d_signup_weekday'][$i]);
                    $data['d_lost_timestamp'][$i] = strtotime($data['d_ldatetime'][$i]);
                    $data['d_lost_date'][$i] = date("Y-m-d", $data['d_lost_timestamp'][$i]);
                    $data['d_lost_time'][$i] = date("H:i", $data['d_lost_timestamp'][$i]);
                    $data['d_lost_weekday'][$i] = date("N", $data['d_lost_timestamp'][$i]);
                    $data['d_lost_weekday_translate'][$i] = PublicMethod::translate_weekday($data['d_lost_weekday'][$i]);
                }
            }

            $this->load->view('view_lost', $data);

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function signUpItem()
    {
        date_default_timezone_set('Asia/Shanghai');
        if (isset($_SESSION['user_id']) &&
            //isset($_POST['fwid']) &&
            //isset($_POST['signuptime']) &&
            isset($_POST['ldatetime']) &&
            isset($_POST['ldescription']) &&
            isset($_POST['lplace']) &&
            isset($_POST['loser']) &&
            isset($_POST['lcontact']))
        {
            $lwid = $_SESSION['level'] >= 2 ? $_POST['lwid'] : $_SESSION['worker_id'];
            if (isset($_POST['signuptime'])) $signuptime = $_POST['signuptime'];
            else $signuptime = date("Y-m-d H:i:s");
            $ldatetime = $_POST['ldatetime'];
            $ldescription = $_POST['ldescription'];
            $lplace = $_POST['lplace'];
            $loser = $_POST['loser'];
            $lcontact = $_POST['lcontact'];
            $result = $this->Moa_lost_model->sign_up_item($lwid, $signuptime, $ldatetime, $ldescription,
                $lplace, $loser, $lcontact);
            if ($result > 0) {
                echo json_encode(array("status" => true, "msg" => "添加成功！", "fid" => $result));
            } else {
                echo json_encode(array("status" => false, "msg" => "添加失败！"));
            }
        } else {
            echo json_encode(array("status" => false, "msg" => "添加失败！"));
        }
    }

    public function updateByLid()
    {
        if (isset($_SESSION['user_id']) &&
            //isset($_POST['owid']) &&
            isset($_POST['lid']))
        {
            $result = $this->Moa_lost_model->update_by_lid($_POST['lid']);
            if ($result > 0) {
                echo json_encode(array("status" => true, "msg" => "已更新！"));
            } else {
                echo json_encode(array("status" => true, "msg" => "更新失败！"));
            }
        } else {
            echo json_encode(array("status" => true, "msg" => "更新失败！"));
        }
    }


    public function deleteByLid()
    {
        $ret = false;
        if (isset($_SESSION['user_id']) &&
            isset($_POST['lid']))
        {
            $res = $this->Moa_lost_model->get_by_lid($_POST['lid']);
            if ($_SESSION['worker_id'] == $res->lwid || $_SESSION['level'] >= 2){
                $ret = $this->Moa_lost_model->delete_by_lid($_POST['lid']);
            }
        }
        if ($ret == false){
            echo json_encode(array("status" => false, "msg" => ""));
        }else{
            echo json_encode(array("status" => true, "msg" => ""));
        }
    }

    public function getInformation()
    {
        if (isset($_SESSION['user_id'])) {
            $common_worker = $this->Moa_user_model->get(0);
            $uid_list = array();
            $name_list = array();
            $wid_list = array();
            for ($i = 0; $i < count($common_worker); $i++) {
                $uid_list[$i] = $common_worker[$i]->uid;
                $name_list[$i] = $common_worker[$i]->name;
                $wid_list[$i] = $this->Moa_worker_model->get_wid_by_uid($uid_list[$i]);
            }

            $data['name_list'] = $name_list;
            $data['wid_list'] = $wid_list;
            $data['user_level'] = $_SESSION['level'];

            echo json_encode(array("status" => TRUE, "msg" => "获取助理信息成功", "data" => $data));
            return;
        }
    }

    public function getByLid()
    {
        if (isset($_SESSION['user_id']) && isset($_POST['lid'])){
            $res = $this->Moa_lost_model->get_by_lid($_POST['lid']);
            echo json_encode(array("status" => true, "msg" => "Lost got", "data" => (array)$res));
        }
    }




}