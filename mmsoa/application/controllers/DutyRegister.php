<?php
/**
 * Created by PhpStorm.
 * User: Alcan
 * 值班报名
 */
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

Class DutyRegister extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_dutyregister_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    /* ============================== UI ================================ */

    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $this->load->view('view_duty_register_brief');
        } else {
            PublicMethod::requireLogin();
        }
    }

    public function Detail($drid)
    {
        if (isset($_SESSION['user_id'])) {
            $this->load->view('view_duty_register_detail', array('drid' => $drid));
        } else {
            PublicMethod::requireLogin();
        }
    }

    public function Register($drid)
    {
        if (isset($_SESSION['user_id'])) {
            $this->load->view('view_duty_register_register', array('drid' => $drid));
        } else {
            PublicMethod::requireLogin();
        }
    }

    /* ============================== API ================================ */

    public function AddTable()
    {
        if (isset($_SESSION['user_id'])) {
            //检查权限
            if ($_SESSION['level'] < 2) {
                PublicMethod::permissionDenied();
                return;
            }
            //检查参数
            if(!(
                isset($_POST['register_start']) && isset($_POST['register_stop']) &&
                isset($_POST['duty_start']) && isset($_POST['duty_end']) &&
                isset($_POST['reg_max'])
            ))
            {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }

            $title = '新建报名表';
            if(isset($_POST['title']) && $_POST['title'] != '') {
                $title = $_POST['title'];
            }

            $drid = $this->Moa_dutyregister_model->add_table(
                array(
                    'title' => $title,
                    'regmax' => $_POST['reg_max'],
                    'regstarttimestamp' => $_POST['register_start'],
                    'regendtimestamp' => $_POST['register_stop'],
                    'dutystartpoint' => $_POST['duty_start'],
                    'dutyendpoint' => $_POST['duty_end']
                    )
            );

            if($drid) {
                echo json_encode(array("status" => TRUE, "msg" => "添加成功"));
                return;
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "添加失败"));
                return;
            }
        } else {
            PublicMethod::requireLogin();
        }
    }

    public function DeleteTable()
    {
        if (isset($_SESSION['user_id'])) {
            //检查权限
            if ($_SESSION['level'] < 2) {
                PublicMethod::permissionDenied();
                return;
            }
            //检查参数
            if(!isset($_POST['drid']))
            {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }
            $res = $this->Moa_dutyregister_model->delete_table($_POST['drid']);
            if($res) {
                echo json_encode(array("status" => TRUE, "msg" => "删除成功"));
                return;
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "删除失败"));
                return;
            }
        } else {
            PublicMethod::requireLogin();
        }
    }

    /**
     * 查看报名表列表
     */
    public function GetTables()
    {
        if (isset($_SESSION['user_id'])) {
            $objs = $this->Moa_dutyregister_model->get_tables();
            $table_list = array();
            $len = count($objs);

            for ($i = 0; $i < $len; ++$i) {
                $table_list[$i]['drid'] = $objs[$i]->drid;
                $table_list[$i]['title'] = $objs[$i]->title;
                $table_list[$i]['createtime'] = $objs[$i]->createtime;
                $table_list[$i]['regstarttimestamp']  = $objs[$i]->regstarttimestamp;
                $table_list[$i]['regendtimestamp']  = $objs[$i]->regendtimestamp;
                $table_list[$i]['regmax']  = $objs[$i]->regmax;
            }
            echo json_encode(array("status" => TRUE, "msg" => "获取报名表列表成功", "table_list" => $table_list));
            return;
        } else {
            PublicMethod::requireLogin();
        }
    }

    /**
     * 查看报名情况
     */
    public function GetTableWithDetail()
    {
        if (isset($_SESSION['user_id'])) {
            if(isset($_POST['drid'])) {
                $drid = $_POST['drid'];
                $table_with_detail = $this->Moa_dutyregister_model->get_table_and_detail($drid);
                if ($table_with_detail == false)
                {
                    echo json_encode(array("status" => FALSE, "msg" => "没有此报名表信息"));
                    return;
                }

                $table_obj = $table_with_detail[0];
                $table = array();

                // ------------- table info -----------------
                $start_point = explode(',', $table_obj->dutystartpoint);
                $end_point = explode(',', $table_obj->dutyendpoint);

                $table['drid'] = $table_obj->drid;
                $table['title'] = $table_obj->title;
                $table['createtime'] = $table_obj->createtime;
                $table['regmax'] = $table_obj->regmax;
                $table['regstarttimestamp']  = $table_obj->regstarttimestamp;
                $table['regendtimestamp']  = $table_obj->regendtimestamp;
                $table['inregtime'] = PublicMethod::inTimePeriod(
                    date("Y-m-d"),
                    $table_obj->regstarttimestamp,
                    $table_obj->regendtimestamp
                );
                $table['dutyperiod'] = array();

                $len_period = count($start_point);
                for($i = 0; $i < $len_period; ++$i){
                    $table['dutyperiod'][$i] = $start_point[$i] . '-' . $end_point[$i];
                }

                // --------------- register detail ----------------
                $detail_obj_list = $table_with_detail[1];
                $detail_list = array();
                $len_detail = count($detail_obj_list);

                //一个星期7天，初始化字典
                for($i = 0; $i < $len_period; ++$i)
                {
                    $period = strval($i);
                    for($j = 0; $j < 7; ++$j)
                    {
                        $weekday = strval($j);
                        $detail_list[$period . ',' . $weekday] = array();
                    }
                }

                //放入用户名和对应的组
                for($i = 0; $i < $len_detail; ++$i)
                {
                    $period = strval($detail_obj_list[$i]->period);
                    $weekday = strval($detail_obj_list[$i]->weekday);
                    $user = $this->Moa_user_model->get($detail_obj_list[$i]->uid);

                    $name = 'XXX';
                    if($user != false)
                        $name = $user->name;

                    $detail_list[$period . ',' . $weekday][] = $name;
                }

                echo json_encode(array("status" => TRUE, "msg" => "获取报名表成功", "table" => $table,
                    'detail_list' => $detail_list));
                return;
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }
        } else {
            PublicMethod::requireLogin();
        }
    }

    /**
     * 查看个人报名情况
     */
    public function GetDetailOfUser()
    {
        if (isset($_SESSION['user_id'])) {
            if(isset($_POST['drid'])) {
                $drid = $_POST['drid'];
                $uid = $_SESSION['user_id'];
                $table_with_detail = $this->Moa_dutyregister_model->get_table_and_detail_with_uid($drid, $uid);
                if ($table_with_detail == false)
                {
                    echo json_encode(array("status" => FALSE, "msg" => "没有此报名表信息"));
                    return;
                }

                $table_obj = $table_with_detail[0];
                $reg_max = $table_obj->regmax;
                $intime = PublicMethod::inTimePeriod(
                    date("Y-m-d"),
                    $table_obj->regstarttimestamp,
                    $table_obj->regendtimestamp
                );
                $table = array();

                // ------------- table info -----------------
                $start_point = explode(',', $table_obj->dutystartpoint);
                $end_point = explode(',', $table_obj->dutyendpoint);

                $table['drid'] = $table_obj->drid;
                $table['title'] = $table_obj->title;
                $table['createtime'] = $table_obj->createtime;
                $table['regmax'] = $reg_max;
                $table['regstarttimestamp']  = $table_obj->regstarttimestamp;
                $table['regendtimestamp']  = $table_obj->regendtimestamp;
                $table['inregtime'] = $intime;
                $table['dutyperiod'] = array();

                $len_period = count($start_point);
                for($i = 0; $i < $len_period; ++$i){
                    $table['dutyperiod'][$i] = $start_point[$i] . '-' . $end_point[$i];
                }

                // --------------- user register detail ----------------
                $detail_obj_list = $table_with_detail[1];
                $detail_list = array();
                $len_detail = count($detail_obj_list);

                //一个星期7天，构造字典
                for($i = 0; $i < $len_period; ++$i)
                {
                    $period = strval($i);
                    for($j = 0; $j < 7; ++$j)
                    {
                        $weekday = strval($j);
                        $detail_list[$period . ',' . $weekday] = 0; //          0 - 不可报名，也没有报名
                    }
                }

                //勾上已经报名的地方
                for($i = 0; $i < $len_detail; ++$i)
                {
                    $period = strval($detail_obj_list[$i]->period);
                    $weekday = strval($detail_obj_list[$i]->weekday);
                    if($intime) {
                        $detail_list[$period . ',' . $weekday] = 1; //          1 - 已经报了名, 可以取消
                    }
                    else
                    {
                        $detail_list[$period . ',' . $weekday] = 2; //          2 - 已经报了名，不可取消
                    }
                }

                //勾上还可以报名的地方
                if($intime)
                {
                    for ($i = 0; $i < $len_period; ++$i)
                    {
                        $period = strval($i);
                        for ($j = 0; $j < 7; ++$j)
                        {
                            $weekday = strval($j);
                            $reg_result = $this->Moa_dutyregister_model->get_point($drid, $period, $weekday);
                            if(
                                ($reg_result == false || count($reg_result) < $reg_max) &&
                                $detail_list[$period . ',' . $weekday] == 0
                            )
                            {
                                $detail_list[$period . ',' . $weekday] = 3; //  3 - 还可以报名
                            }

                        }
                    }
                }


                echo json_encode(array("status" => TRUE, "msg" => "获取个人报名信息成功", "table" => $table,
                    'detail_list' => $detail_list));
                return;
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }
        } else {
            PublicMethod::requireLogin();
        }
    }

    /**
     * 报名
     */
    public function UserRegister()
    {
        if (isset($_SESSION['user_id'])) {
            if(isset($_POST['drid']) && isset($_POST['point'])) {
                $uid = $_SESSION['user_id'];
                $drid = $_POST['drid'];

                $table_obj = $this->Moa_dutyregister_model->get_table($drid);
                if ($table_obj == false)
                {
                    echo json_encode(array("status" => FALSE, "msg" => "没有此报名表信息"));
                    return;
                }

                // ------------- check -----------------
                $intime = PublicMethod::inTimePeriod(
                    date("Y-m-d"),
                    $table_obj->regstarttimestamp,
                    $table_obj->regendtimestamp
                );
                if(!$intime)
                {
                    echo json_encode(array("status" => FALSE, "msg" => "已错过报名时间"));
                    return;
                }

                $point = explode(',', $_POST['point']);
                $period = $point[0];
                $weekday = $point[1];
                $reg_result = $this->Moa_dutyregister_model->get_point($drid, $period, $weekday);
                if (count($reg_result) >= $table_obj->regmax)
                {
                    echo json_encode(array("status" => FALSE, "msg" => "该时间段名额已满"));
                    return;
                }

                // ------------ add new record -------------
                $res = $this->Moa_dutyregister_model->add_record(
                    array(
                        'drid' => $drid,
                        'period' => $period,
                        'weekday' => $weekday,
                        'uid' => $uid
                    )
                );

                //--------- return ---------------
                if($res)
                {
                    echo json_encode(array("status" => TRUE, "msg" => "报名成功"));
                }
                else
                {
                    echo json_encode(array("status" => FALSE, "msg" => "报名失败"));
                }
                return;
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }
        } else {
            PublicMethod::requireLogin();
        }
    }

    /**
     * 取消报名
     */
    public function UserUnregister()
    {
        if (isset($_SESSION['user_id'])) {
            if(isset($_POST['drid']) && isset($_POST['point'])) {
                $uid = $_SESSION['user_id'];
                $drid = $_POST['drid'];
                $point = explode(',', $_POST['point']);
                $period = $point[0];
                $weekday = $point[1];

                $table_obj = $this->Moa_dutyregister_model->get_table($drid);
                if ($table_obj == false)
                {
                    echo json_encode(array("status" => FALSE, "msg" => "没有此报名表信息"));
                    return;
                }

                // ------------- check -----------------
                $intime = PublicMethod::inTimePeriod(
                    date("Y-m-d"),
                    $table_obj->regstarttimestamp,
                    $table_obj->regendtimestamp
                );
                if(!$intime)
                {
                    echo json_encode(array("status" => FALSE, "msg" => "已错过报名时间"));
                    return;
                }

                // ------------ delete record -------------
                $res = $this->Moa_dutyregister_model->delete_record($drid, $period, $weekday, $uid);

                //--------- return ---------------
                if($res)
                {
                    echo json_encode(array("status" => TRUE, "msg" => "取消报名成功"));
                }
                else
                {
                    echo json_encode(array("status" => FALSE, "msg" => "取消报名失败"));
                }
                return;
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }
        } else {
            PublicMethod::requireLogin();
        }
    }
}