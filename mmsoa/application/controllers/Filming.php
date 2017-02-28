<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 拍摄登记控制类
 * @author 伟
 */
Class Filming extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_attend_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    /**
     * 进入拍摄登记页面
     */
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            // 检查权限: 0-普通助理  6-超级管理员
            if ($_SESSION['level'] != 0 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }

            $weekdays_in_cn = array("日", "一", "二", "三", "四", "五", "六");
            $data = array();
            $data['d_fid'] = array();
            $data['d_wid'] = array();
            $data['d_uid'] = array();
            $data['d_name'] = array();
            $data['d_fmname'] = array();
            $data['d_aename'] = array();
            $data['d_worktime'] = array();
            $data['d_date'] = array();
            $data['d_weekday_translate'] = array();

            $filming_list = $this->Moa_filming_model->get_all();

            $d_fid = array();
            $d_wid = array();
            $d_uid = array();
            $d_name = array();
            $d_fmname = array();
            $d_aename = array();
            $d_worktime = array();
            $d_date = array();
            $d_weekday_translate = array();

            for ($i = 0; $i < count($filming_list); $i++) {
                $d_fid[$i] = $filming_list[$i]->fid;
                $d_wid[$i] = $filming_list[$i]->wid;
                $d_fmname[$i] = $filming_list[$i]->fmname;
                $d_aename[$i] = $filming_list[$i]->aename;
                $d_worktime[$i] = $filming_list[$i]->worktime;
                $d_date[$i] = $filming_list[$i]->date;
                $d_weekday_translate[$i] = $weekdays_in_cn[date("w", $d_date[$i])];

                $d_uid[$i] = $this->Moa_worker_model->get_uid_by_wid($d_wid[$i]);
                $worker = $this->Moa_user_model->get($d_uid[$i]);
                $d_name[$i] = $worker->name;
            }

            $data['d_fid'] = $d_fid;
            $data['d_wid'] = $d_wid;
            $data['d_uid'] = $d_uid;
            $data['d_name'] = $d_name;
            $data['d_fmname'] = $d_fmname;
            $data['d_aename'] = $d_aename;
            $data['d_worktime'] = $d_worktime;
            $data['d_date'] = $d_date;
            $data['d_weekday_translate'] = $d_weekday_translate;

            $this->load->view('view_filming', $data);
        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }


}