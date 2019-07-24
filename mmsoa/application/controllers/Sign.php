<?php
/**
 * Created by PhpStorm.
 * User: Alcan
 * 值班报名
 */
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

Class Sign extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_signregister_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    /* ============================== UI ================================ */

    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $this->load->view('view_sign_register_brief');
        } else {
            PublicMethod::requireLogin();
        }
    }

    public function Register($signid)
    {
        if (isset($_SESSION['user_id'])) {
            $this->load->view('view_sign_register_register', array('signid' => $signid));
        } else {
            PublicMethod::requireLogin();
        }
    }
    public function Operate($signid) {
    	if (isset($_SESSION['user_id'])) {
            $this->load->view('view_sign_register_detail', array('signid' => $signid));
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
                isset($_POST['sign_start']) && isset($_POST['sign_end'])
            ))
            {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }

            $title = '新建报名表';
            if(isset($_POST['title']) && $_POST['title'] != '') {
                $title = $_POST['title'];
            }

            $note = "";
            if(isset($_POST['note']))
                $note = $_POST['note'];

            $drid = $this->Moa_signregister_model->add_table(
                array(
                    'title' => $title,
                    'signNum' => 0,
                    'signStart' => $_POST['sign_start'],
                    'signEnd' => $_POST['sign_end'],
                    'note' => $note
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

    public function DeleteSign()
    {
        if (isset($_SESSION['user_id'])) {
            //检查权限
            if ($_SESSION['level'] < 2) {
                PublicMethod::permissionDenied();
                return;
            }
            //检查参数
            if(!isset($_POST['signid']))
            {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }
            $res = $this->Moa_signregister_model->delete_sign($_POST['signid']);
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


    public function GetUserList() {
	    if (isset($_SESSION['user_id'])) {
	    	$name = $_POST['name'];
	    	$signid = $_POST['signid'];
	    	$ret = array();
	    	$arr1 = $this->Moa_user_model->get_by_name($name);
	    	if ($arr1 == false) {
	    		echo json_encode(array("status" => FALSE, "msg" => "没有该用户", "user_list"=>$ret));
	    		return;
	    	}
	    	$len = count($arr1);
	    	for ($t = 0; $t < $len; ++ $t) {
	    		$arr2 = $this->Moa_signregister_model->get_user_state($signid, $arr1[$t]->uid);
	    		$ret[$t] = array();
	    		$ret[$t]['uid'] = $arr1[$t]->uid;
	    		$ret[$t]['username'] = $arr1[$t]->username;
	    		$ret[$t]['name'] = $arr1[$t]->name;
	    		if ($arr2)
    				$ret[$t]['have'] = 1;
    			else $ret[$t]['have'] = 0;
	    	}
	    	echo json_encode(array("status"=> TRUE, "user_list"=>$ret));
	    	return;
	    }else {
            PublicMethod::requireLogin();
        }
	}

    public function GetTables()
    {
        if (isset($_SESSION['user_id'])) {
            $objs = $this->Moa_signregister_model->get_tables();
            $table_list = array();
            $len = count($objs);

            for ($i = 0; $i < $len; ++$i) {
                $table_list[$i]['signid'] = $objs[$i]->signid;
                $table_list[$i]['title'] = $objs[$i]->title;
                $table_list[$i]['createtime'] = $objs[$i]->createTime;
                $table_list[$i]['sign_start']  = $objs[$i]->signStart;
                $table_list[$i]['sign_end']  = $objs[$i]->signEnd;
                $table_list[$i]['sign_num']  = $objs[$i]->signNum;
                $table_list[$i]['is_signed'] = $objs[$i]->isSigned;
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
    public function GetTableWithDetail() {
       if (isset($_SESSION['user_id'])) {
            if(isset($_POST['signid'])) {
                $signid = $_POST['signid'];
                $table_with_detail = $this->Moa_signregister_model->get_table_and_detail($signid);
                if ($table_with_detail == false) {
                    echo json_encode(array("status" => FALSE, "msg" => "没有此签到表信息"));
                    return;
                }

                $table_obj = $table_with_detail[0];
                $user_list = $table_with_detail[1];
                $table = array();

                // ------------- table info -----------------

                $table['signid'] = $table_obj->signid;
                $table['title'] = $table_obj->title;
                $table['createtime'] = $table_obj->createTime;
                $table['sign_num'] = $table_obj->signNum;
                $table['sign_start']  = $table_obj->signStart;
                $table['sign_end']  = $table_obj->signEnd;
                $table['note'] = ($table_obj->note != null ? $table_obj->note : "");

                $ret = array();
                $len_user = count($user_list);
                for($i = 0; $i < $len_user; ++$i){
                    $ret[$i]['uid'] = $user_list[$i]->uid;
                    $ret[$i]['state'] = $user_list[$i]->state;
                    $ret[$i]['signTime'] = $user_list[$i]->signTime;
                    $user = $this->Moa_user_model->get($user_list[$i]->uid);
                    $name = 'XXX';
                    if($user != false)
                        $name = $user->name;
                    $ret[$i]['name'] = $name;
                    $ret[$i]['username'] = $user->username;
                }

                echo json_encode(array("status" => TRUE, "msg" => "获取报名表成功", "table" => $table, "user_list" => $ret));
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
     * 取消
     */
    public function UserUnregister()
    {
        if (isset($_SESSION['user_id'])) {
            if(isset($_POST['signid']) && isset($_POST['uid']) ) {
            	$uid = $_POST['uid'];
                $signid = $_POST['signid'];

                $table_with_detail = $this->Moa_signregister_model->get_table_and_detail_with_uid($signid, $uid);
                $table_obj = $table_with_detail[0];
                $user_detail = count($table_with_detail[1]);
                if ($table_obj == false) {
                    echo json_encode(array("status" => FALSE, "msg" => "没有此报名表信息"));
                    return;
                }

                // ------------- check -----------------
                $intime = PublicMethod::inTimePeriod(
                    date("Y-m-d H:i:s"),
                    $table_obj->signStart,
                    $table_obj->signEnd
                );
                if(!$intime) {
                    echo json_encode(array("status" => FALSE, "msg" => "已错过报名时间"));
                    return;
                }
                $flag = 0;
                $date = date("Y-m-d H:i:s");
                $update_res = $this->Moa_signregister_model->update_sign($signid, $uid, $flag, $date);
                if (!$update_res) {
                    echo json_encode(array("status" => FALSE, "msg" => "签到错误"));
                }
                echo json_encode(array("status" => TRUE, "msg" => "取消成功"));
                return;
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }
        } else {
            PublicMethod::requireLogin();
        }
    }
    public function UserRegister() {
        if (isset($_SESSION['user_id'])) {
            if(isset($_POST['signid']) && isset($_POST['uid']) ) {        	
            	$uid = $_POST['uid'];
                $signid = $_POST['signid'];
             
                $table_with_detail = $this->Moa_signregister_model->get_table_and_detail_with_uid($signid, $uid);        
                if ($table_with_detail == false) {
                    echo json_encode(array("status" => FALSE, "msg" => "没有此报名表信息"));
                    return;
                }   
                $table_obj = $table_with_detail[0];
                $user_detail = count($table_with_detail[1]);

                

                // ------------- check -----------------
                $intime = PublicMethod::inTimePeriod(
                    date("Y-m-d H:i:s"),
                    $table_obj->signStart,
                    $table_obj->signEnd
                );
                if(!$intime) {
                    echo json_encode(array("status" => FALSE, "msg" => "已错过签到时间"));
                    return;
                }
                $flag = 1;
                $date = date("Y-m-d H:i:s");
                $update_res = $this->Moa_signregister_model->update_sign($signid, $uid, $flag, $date);
                if (!$update_res) {
                    echo json_encode(array("status" => FALSE, "msg" => "签到错误"));
                }
                else echo json_encode(array("status" => TRUE, "msg" => "签到成功"));
                return;
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "提交的参数不完整"));
                return;
            }
        } else {
            PublicMethod::requireLogin();
        }
    }
    public function DelSigner() {
        if (isset($_SESSION['user_id'])) {
        	$uid = $_POST['uid'];
            $signid = $_POST['signid'];
            $ret = $this->Moa_signregister_model->del_signer($signid, $uid);
            if($ret) {
            	echo json_encode(array("status" => TRUE, "msg" => "成功从签到表中删除"));
            }
            else {
            	echo json_encode(array("status" => FALSE, "msg" => "删除错误"));
            }
        } else {
            PublicMethod::requireLogin();
        }
    }
    public function AddSigner() {
        if (isset($_SESSION['user_id'])) {
        	$uid = $_POST['uid'];
            $signid = $_POST['signid'];
            $ret = $this->Moa_signregister_model->add_signer($signid, $uid);
			if($ret) {
            	echo json_encode(array("status" => TRUE, "msg" => "成功从签到表中添加"));
            }
            else {
            	echo json_encode(array("status" => FALSE, "msg" => "重复添加！"));
            }
        } else {
            PublicMethod::requireLogin();
        }
    }

}
