<?php
/**
 * Created by PhpStorm.
 * User: alcanderian
 * Date: 27/11/2016
 * Time: 18:20
 */

header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

Class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_school_term_model');
        $this->load->model('Moa_config_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    public function index() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] < 4) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }
            $this->load->view('view_settings');
        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function getTermList() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] < 4) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }

            $objects = $this->Moa_school_term_model->get_term();

            $len = count($objects);

            $ret = array();

            for($i = 0; $i < $len; ++$i) {
                $ret[$i]= array();
                $ret[$i]['termid'] = $objects[$i]->termid;
                $ret[$i]['schoolyear'] = $objects[$i]->schoolyear;
                $ret[$i]['schoolterm'] = $objects[$i]->schoolterm;
                $ret[$i]['termbeginstamp'] = $objects[$i]->termbeginstamp;
                $ret[$i]['termendstamp'] = $objects[$i]->termendstamp;
            }

            $today = date("Y-m-d H:i:s");
            $now_term_object =  $this->Moa_school_term_model->get_term($today);
            $now_term = array();
            $now_term['schoolyear'] = $now_term_object[0]->schoolyear;
            $now_term['schoolterm'] = $now_term_object[0]->schoolterm;

            echo json_encode(array('state'=> true, 'term_list' => $ret, 'now_term' => $now_term));
            return;

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function newTerm() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] < 4) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }

            $schoolyear = $_POST['schoolyear'];
            $schoolterm = $_POST['schoolterm'];
            $termbeginstamp = $_POST['termbeginstamp'];
            $termendstamp = $_POST['termendstamp'];

            if($termbeginstamp >= $termendstamp) {
                echo json_encode(array('state'=> false, 'msg' => '新建学期失败，学期长度必须为正数'));
                return;
            }

            $old_term = $this->Moa_school_term_model->get_term($termbeginstamp);
            if(count($old_term) != 0) {
                echo json_encode(array('state'=> false, 'msg' => '新建学期失败，日期不能有重叠'));
                return;
            }

            $old_term = $this->Moa_school_term_model->get_term($termendstamp);
            if(count($old_term) != 0) {
                echo json_encode(array('state'=> false, 'msg' => '新建学期失败，日期不能有重叠'));
                return;
            }

            $this->Moa_school_term_model->new_term(array(
                'schoolyear' => $schoolyear,
                'schoolterm' => $schoolterm,
                'termbeginstamp' => $termbeginstamp,
                'termendstamp' => $termendstamp
            ));

            $ret = $this->db->insert_id();
            if($ret != NULL) {
                echo json_encode(array('state'=> true, 'msg' => '新建学期成功'));
                return;
            } else {
                echo json_encode(array('state'=> false, 'msg' => '新建学期失败'));
                return;
            }

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function deleteTerm() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] < 4) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }

            $ret = $this->Moa_school_term_model->delete_term($_POST['termid']);

            if($ret !=  NULL) {
                echo json_encode(array('state'=> true, 'msg' => '删除成功'));
                return;
            } else {
                echo json_encode(array('state'=> false, 'msg' => '删除失败，没有该学期信息'));
                return;
            }


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function setConfig() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] < 4) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }

            $ret = $this->Moa_config_model->get_by_name($_POST['name']);
            if($ret == $_POST['value']) {
                echo json_encode(array('state'=> false, 'msg' => '该设置没有改变，无需修改'));
                return;
            }

            $ret = $this->Moa_config_model->update($_POST['name'], $_POST['value']);

            if($ret !=  NULL) {
                echo json_encode(array('state'=> true, 'msg' => '修改成功'));
                return;
            } else {
                echo json_encode(array('state'=> false, 'msg' => '修改失败'));
                return;
            }


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function getConfigByName() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] < 4) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }

            $ret = $this->Moa_config_model->get_by_name($_POST['name']);

            if($ret !=  NULL) {
                echo json_encode(array('state'=> true, 'msg' => $ret));
                return;
            } else {
                echo json_encode(array('state'=> false, 'msg' => '提取配置失败'));
                return;
            }


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    public function getAllConfig() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] < 4) {
                // 提示权限不够
                PublicMethod::permissionDenied();
                return;
            }

            $res = $this->Moa_config_model->get_all();

            if($res !=  NULL) {
                $len = count($res);
                $ret = array();
                for($i = 0; $i < $len; ++$i) {
                    $ret[$res[$i]->variable] = $res[$i]->value;
                }

                echo json_encode(array('state'=> true, 'msg' => $ret));
                return;
            } else {
                echo json_encode(array('state'=> false, 'msg' => '提取配置失败'));
                return;
            }


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }
}