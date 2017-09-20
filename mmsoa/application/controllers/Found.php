<?php
/**
 * Created by PhpStorm.
 * User: zhong
 * Date: 2017/9/14
 * Time: 1:56
 */
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');


class Found extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_found_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    public function index()
    {
        if (isset($_SESSION['user_id'])) {

            // 原始数据
            $data = array();
            $data['d_fid'] = array();
            $data['d_state'] = array();
            $data['d_fwid'] = array();
            $data['d_signuptime'] = array();
            $data['d_fdatetime'] = array();
            $data['d_fdescription'] = array();
            $data['d_fplace'] = array();
            $data['d_finder'] = array();
            $data['d_fcontact'] = array();
            $data['d_owid'] = array();
            $data['d_owner'] = array();
            $data['d_odatetime'] = array();
            $data['d_ocontact'] = array();
            $data['d_onumber'] = array();
            // 处理后数据
            $data['d_fworkername'] = array();
            $data['d_oworkername'] = array();
            $data['d_signup_timestamp'] = array();
            $data['d_signup_date'] = array();
            $data['d_signup_time'] = array();
            $data['d_signup_weekday'] = array();
            $data['d_signup_weekday_translate'] = array();
            $data['d_found_timestamp'] = array();
            $data['d_found_date'] = array();
            $data['d_found_time'] = array();
            $data['d_found_weekday'] = array();
            $data['d_found_weekday_translate'] = array();
            $data['d_owned_timestamp'] = array();
            $data['d_owned_date'] = array();
            $data['d_owned_time'] = array();
            $data['d_owned_weekday'] = array();
            $data['d_owned_weekday_translate'] = array();

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
            $obj = $this->Moa_found_model->get_all();
            if ($obj == false){
                NULL;
            }else{
                for ($i = 0; $i < count($obj); $i++){
                    $data['d_fid'][$i] = $obj[$i]->fid;
                    $data['d_state'][$i] = $obj[$i]->state;
                    $data['d_fwid'][$i] = (int)$obj[$i]->fwid;
                    $data['d_signuptime'][$i] = $obj[$i]->signuptime;
                    $data['d_fdatetime'][$i] = $obj[$i]->fdatetime;
                    $data['d_fdescription'][$i] = $obj[$i]->fdescription;
                    $data['d_fplace'][$i] = $obj[$i]->fplace;
                    $data['d_finder'][$i] = $obj[$i]->finder;
                    $data['d_fcontact'][$i] = $obj[$i]->fcontact;
                    $data['d_owid'][$i] = (int)$obj[$i]->owid;
                    $data['d_owner'][$i] = $obj[$i]->owner;
                    $data['d_odatetime'][$i] = $obj[$i]->odatetime;
                    $data['d_ocontact'][$i] = $obj[$i]->ocontact;
                    $data['d_onumber'][$i] = $obj[$i]->onumber;

                    $data['d_fworkername'][$i] = $data['d_fwid'][$i] == 0 ? "" :
                        $this->Moa_user_model->get($this->Moa_worker_model->get_uid_by_wid($data['d_fwid'][$i]))->name;
                    $data['d_oworkername'][$i] = $data['d_owid'][$i] == 0 ? "" :
                        $this->Moa_user_model->get($this->Moa_worker_model->get_uid_by_wid($data['d_owid'][$i]))->name;
                    $data['d_signup_timestamp'][$i] = strtotime($data['d_signuptime'][$i]);
                    $data['d_signup_date'][$i] = date("Y-m-d", $data['d_signup_timestamp'][$i]);
                    $data['d_signup_time'][$i] = date("H:i", $data['d_signup_timestamp'][$i]);
                    $data['d_signup_weekday'][$i] = date("N", $data['d_signup_timestamp'][$i]);
                    $data['d_signup_weekday_translate'][$i] = PublicMethod::translate_weekday($data['d_signup_weekday'][$i]);
                    $data['d_found_timestamp'][$i] = strtotime($data['d_fdatetime'][$i]);
                    $data['d_found_date'][$i] = date("Y-m-d", $data['d_found_timestamp'][$i]);
                    $data['d_found_time'][$i] = date("H:i", $data['d_found_timestamp'][$i]);
                    $data['d_found_weekday'][$i] = date("N", $data['d_found_timestamp'][$i]);
                    $data['d_found_weekday_translate'][$i] = PublicMethod::translate_weekday($data['d_found_weekday'][$i]);
                    $data['d_owned_timestamp'][$i] = strtotime($data['d_odatetime'][$i]);
                    $data['d_owned_date'][$i] = date("Y-m-d", $data['d_owned_timestamp'][$i]);
                    $data['d_owned_time'][$i] = date("H:i", $data['d_owned_timestamp'][$i]);
                    $data['d_owned_weekday'][$i] = date("N", $data['d_owned_timestamp'][$i]);
                    $data['d_owned_weekday_translate'][$i] = PublicMethod::translate_weekday($data['d_owned_weekday'][$i]);
                }
            }

            $this->load->view('view_found', $data);

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
            isset($_POST['fdatetime']) &&
            isset($_POST['fdescription']) &&
            isset($_POST['fplace']) &&
            isset($_POST['finder']) &&
            isset($_POST['fcontact']))
        {
            $fwid = $_SESSION['level'] >= 2 ? $_POST['fwid'] : $_SESSION['worker_id'];
            if (isset($_POST['signuptime'])) $signuptime = $_POST['signuptime'];
            else $signuptime = date("Y-m-d H:i:s");
            $fdatetime = $_POST['fdatetime'];
            $fdescription = $_POST['fdescription'];
            $fplace = $_POST['fplace'];
            $finder = $_POST['finder'];
            $fcontact = $_POST['fcontact'];
            $result = $this->Moa_found_model->sign_up_item($fwid, $signuptime, $fdatetime, $fdescription,
                $fplace, $finder, $fcontact);
            if ($result > 0) {
                echo json_encode(array("status" => true, "msg" => "添加成功！", "fid" => $result));
            } else {
                echo json_encode(array("status" => false, "msg" => "添加失败！"));
            }
        } else {
            echo json_encode(array("status" => false, "msg" => "添加失败！"));
        }
    }

    public function updateByFid()
    {
        if (isset($_SESSION['user_id']) &&
            //isset($_POST['owid']) &&
            isset($_POST['fid']) &&
            isset($_POST['owner']) &&
            isset($_POST['odatetime']) &&
            isset($_POST['ocontact']) &&
            isset($_POST['onumber']))
        {
            $fid = $_POST['fid'];
            $owid = $_SESSION['level'] >= 2 ? $_POST['owid'] : $_SESSION['worker_id'];
            $owner = $_POST['owner'];
            $odatetime = $_POST['odatetime'];
            $ocontact = $_POST['ocontact'];
            $onumber = $_POST['onumber'];
            $result = $this->Moa_found_model->update_by_fid($fid, $owid, $owner, $odatetime, $ocontact, $onumber);
            if ($result > 0) {
                echo json_encode(array("status" => true, "msg" => "已更新！"));
            } else {
                echo json_encode(array("status" => true, "msg" => "更新失败！"));
            }
        } else {
            echo json_encode(array("status" => true, "msg" => "更新失败！"));
        }
    }


    public function deleteByFid()
    {
        $ret = false;
        if (isset($_SESSION['user_id']) &&
            isset($_POST['fid']))
        {
            $res = $this->Moa_found_model->get_by_fid($_POST['fid']);
            if ($_SESSION['worker_id'] == $res->fwid || $_SESSION['level'] >= 2){
                $ret = $this->Moa_found_model->delete_by_fid($_POST['fid']);
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

    public function getByFid()
    {
        if (isset($_SESSION['user_id']) && isset($_POST['fid'])){
            $res = $this->Moa_found_model->get_by_fid($_POST['fid']);
            echo json_encode(array("status" => true, "msg" => "Found got", "data" => (array)$res));
        }
    }




}