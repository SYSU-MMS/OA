<<<<<<< HEAD
<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 常检录入控制类
 * @author 伟
 */
Class DailyCheck extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_check_model');
        $this->load->model('Moa_attend_model');
        $this->load->model('Moa_school_term_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    /**
     * 常检签到、课室情况登记页面
     * 常检课室列表加载
     */
    public function index() {
        if (isset($_SESSION['user_id'])) {
            // 检查权限: 0-普通助理  6-超级管理员
            if ($_SESSION['level'] != 0 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }

            // 获取常检课室
            $uid = $_SESSION['user_id'];
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            $classrooms[ $wid ] = $this->Moa_worker_model->get($wid)->classroom;
            $classroom_list[ $wid ] = explode(',', $classrooms[ $wid ]);


            // 取所有普通助理的wid与name, level: 0-普通助理  1-组长  2-负责人助理  3-助理负责人  4-管理员  5-办公室负责人
            $level = 0;
            $common_worker = $this->Moa_user_model->get_by_level($level);

            for ($i = 0; $i < count($common_worker); $i++) {
                $uid_list[ $i ] = $common_worker[ $i ]->uid;
                $name_list[ $i ] = $common_worker[ $i ]->name;
                $wid_list[ $i ] = $this->Moa_worker_model->get_wid_by_uid($uid_list[ $i ]);
                $classrooms[ $wid_list[ $i ] ] = $this->Moa_worker_model->get($wid_list[ $i ])->classroom;
                $classroom_list[ $wid_list[ $i ] ] = explode(',', $classrooms[ $wid_list[ $i ] ]);
            }

            $data['wid'] = $wid;
            $data['name_list'] = $name_list;
            $data['wid_list'] = $wid_list;
            $data['classroom_json'] = json_encode($classroom_list);

            $this->load->view('view_daily_check', $data);
        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    /*
     * 早检（录入）
     */
    public function dailyCheckMorning() {
        if (isset($_SESSION['user_id'])) {
            if (isset($_POST['is_replaced']) && isset($_POST['replaced_wid'])) {
                if ($_POST['is_replaced'] && !$_POST['replaced_wid']) {
                    echo json_encode(array("status" => false, "msg" => "请选择原值班助理"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }

            // 获取常检课室
            $uid = $_SESSION['user_id'];
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            // 原助理的wid
            $check_wid = $wid;
            if ($_POST['is_replaced']) {
                $check_wid = $_POST['replaced_wid'];
            }
            $classrooms = $this->Moa_worker_model->get($check_wid)->classroom;
            $classroom_list = explode(',', $classrooms);
            $room_count = count($classroom_list);
            $success_count = 0;
            $time = date('Y-m-d H:i:s');
            $term = $this->Moa_school_term_model->get_term($time);

            if (isset($_POST['cond_morning'])) {
                // 周一为一周的第一天
                $check_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);

                // 1-周一  2-周二  ... 6-周六  7-周日
                $check_paras['weekday'] = date("w") == 0 ? 7 : date("w");

                // type: 0-早检  1-午检  2-晚检  3-周检
                $check_paras['type'] = 0;

                // isChecked: 0-否     1-是，正常     2-是，课室有故障
                $check_paras['isChecked'] = 0;

                $check_paras['actual_wid'] = $wid;
                $check_paras['timestamp'] = $time;

                for ($i = 0; $i < $room_count; $i++) {
                    $check_paras['problemid'] = null;
                    $roomid = $this->Moa_check_model->get_roomid_by_room($classroom_list[ $i ]);
                    $check_paras['roomid'] = $roomid;
                    // 课室情况
                    $prob_description = $_POST['cond_morning'][ $i ];

                    // 课室正常
                    if ($prob_description == "" || $prob_description == "正常") {
                        $check_paras['isChecked'] = 1;
                        // 添加早检记录
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    } // 课室有故障
                    else {
                        $check_paras['isChecked'] = 2;
                        // 添加问题（故障）记录
                        $prob_paras['founder_wid'] = $wid;
                        $prob_paras['roomid'] = $roomid;
                        $prob_paras['description'] = $prob_description;
                        $prob_paras['found_time'] = $time;
                        $prob_paras['solved_time'] = $time;
                        $problemid = $this->Moa_check_model->add_problem($prob_paras);
                        // 添加早检记录
                        $check_paras['problemid'] = $problemid;
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($problemid && $checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    }
                } // for
                // 是否全部成功写入数据库
                if ($success_count == $room_count) {
                    $substitute = $_POST['is_replaced'];
                    // 添加考勤记录
                    $attend_paras['wid'] = $wid;
                    $attend_paras['timestamp'] = $time;
                    // 周次，周一为一周的第一天
                    $attend_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);
                    // 1-周一  2-周二  ... 6-周六  7-周日
                    $attend_paras['weekday'] = date("w") == 0 ? 7 : date("w");
                    // 签到type: 0-值班  1-早检 2-午检 3-晚检 4-周检
                    $type = 1;
                    $attend_paras['type'] = $type;
                    // 是否迟到：0-否 1-是
                    $attend_paras['isLate'] = 0;
                    // 是否代班：0 - 否   1 - 是
                    $attend_paras['isSubstitute'] = $substitute;
                    if ($substitute) {
                        $attend_paras['substituteFor'] = $_POST['replaced_wid'];
                    }

                    $attend_id = $this->Moa_attend_model->add($attend_paras);

                    // 更新工时
                    $contrib = PublicMethod::get_daily_working_hours($type);
                    $affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
                    $affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);

                    if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
                        echo json_encode(array("status" => false, "msg" => "登记失败"));

                        return;
                    }
                    // 成功写入考勤记录以及工时更新
                    echo json_encode(array("status" => true, "msg" => "提交成功"));

                    return;
                } else {
                    echo json_encode(array("status" => false, "msg" => "提交失败"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }
        }
    }

    /*
     * 午检（录入）
     */
    public function dailyCheckNoon() {
        if (isset($_SESSION['user_id'])) {
            if (isset($_POST['is_replaced']) && isset($_POST['replaced_wid'])) {
                if ($_POST['is_replaced'] && !$_POST['replaced_wid']) {
                    echo json_encode(array("status" => false, "msg" => "请选择原值班助理"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }

            // 获取常检课室
            $uid = $_SESSION['user_id'];
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            // 原助理的wid
            $check_wid = $wid;
            if ($_POST['is_replaced']) {
                $check_wid = $_POST['replaced_wid'];
            }

            $classrooms = $this->Moa_worker_model->get($check_wid)->classroom;
            $classroom_list = explode(',', $classrooms);
            $room_count = count($classroom_list);
            $success_count = 0;
            $time = date('Y-m-d H:i:s');
            $term = $this->Moa_school_term_model->get_term($time);

            if (isset($_POST['cond_noon'])) {
                // 周一为一周的第一天
                $check_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);

                // 1-周一  2-周二  ... 6-周六  7-周日
                $check_paras['weekday'] = date("w") == 0 ? 7 : date("w");

                // type: 0-早检  1-午检  2-晚检  3-周检
                $check_paras['type'] = 1;

                // isChecked: 0-否     1-是，正常     2-是，课室有故障
                $check_paras['isChecked'] = 0;

                $check_paras['actual_wid'] = $wid;
                $check_paras['timestamp'] = $time;

                for ($i = 0; $i < $room_count; $i++) {
                    $check_paras['problemid'] = null;
                    $roomid = $this->Moa_check_model->get_roomid_by_room($classroom_list[ $i ]);
                    $check_paras['roomid'] = $roomid;
                    // 课室情况
                    $prob_description = $_POST['cond_noon'][ $i ];

                    // 课室正常
                    if ($prob_description == "" || $prob_description == "正常") {
                        $check_paras['isChecked'] = 1;
                        // 添加午检记录
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    } // 课室有故障
                    else {
                        $check_paras['isChecked'] = 2;
                        // 添加问题（故障）记录
                        $prob_paras['founder_wid'] = $wid;
                        $prob_paras['roomid'] = $roomid;
                        $prob_paras['description'] = $prob_description;
                        $prob_paras['found_time'] = $time;
                        $prob_paras['solved_time'] = $time;
                        $problemid = $this->Moa_check_model->add_problem($prob_paras);
                        // 添加午检记录
                        $check_paras['problemid'] = $problemid;
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($problemid && $checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    }
                } // for
                // 是否全部成功写入数据库
                if ($success_count == $room_count) {
                    $substitute = $_POST['is_replaced'];
                    // 添加考勤记录
                    $attend_paras['wid'] = $wid;
                    $attend_paras['timestamp'] = $time;
                    // 周次，周一为一周的第一天
                    $attend_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);
                    // 1-周一  2-周二  ... 6-周六  7-周日
                    $attend_paras['weekday'] = date("w") == 0 ? 7 : date("w");
                    // 签到type: 0-值班  1-早检 2-午检 3-晚检 4-周检
                    $type = 2;
                    $attend_paras['type'] = $type;
                    // 是否迟到：0-否 1-是
                    $attend_paras['isLate'] = 0;
                    // 是否代班：0 - 否   1 - 是
                    $attend_paras['isSubstitute'] = $substitute;
                    if ($substitute) {
                        $attend_paras['substituteFor'] = $_POST['replaced_wid'];
                    }

                    $attend_id = $this->Moa_attend_model->add($attend_paras);

                    // 更新工时
                    $contrib = PublicMethod::get_daily_working_hours($type);
                    $affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
                    $affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);

                    if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
                        echo json_encode(array("status" => false, "msg" => "登记失败"));

                        return;
                    }
                    // 成功写入考勤记录以及工时更新
                    echo json_encode(array("status" => true, "msg" => "提交成功"));

                    return;
                } else {
                    echo json_encode(array("status" => false, "msg" => "提交失败"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }
        }
    }

    /*
     * 晚检（录入）
     */
    public function dailyCheckEvening() {
        if (isset($_SESSION['user_id'])) {
            if (isset($_POST['is_replaced']) && isset($_POST['replaced_wid'])) {
                if ($_POST['is_replaced'] && !$_POST['replaced_wid']) {
                    echo json_encode(array("status" => false, "msg" => "请选择原值班助理"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }

            // 获取常检课室
            $uid = $_SESSION['user_id'];
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            // 原助理的wid
            $check_wid = $wid;
            if ($_POST['is_replaced']) {
                $check_wid = $_POST['replaced_wid'];
            }

            $classrooms = $this->Moa_worker_model->get($check_wid)->classroom;
            $classroom_list = explode(',', $classrooms);
            $room_count = count($classroom_list);
            $success_count = 0;
            $time = date('Y-m-d H:i:s');
            $term = $this->Moa_school_term_model->get_term($time);

            if (isset($_POST['cond_evening'])) {
                // 周一为一周的第一天
                $check_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);

                // 1-周一  2-周二  ... 6-周六  7-周日
                $check_paras['weekday'] = date("w") == 0 ? 7 : date("w");

                // type: 0-早检  1-午检  2-晚检  3-周检
                $check_paras['type'] = 2;

                // isChecked: 0-否     1-是，正常     2-是，课室有故障
                $check_paras['isChecked'] = 0;

                $check_paras['actual_wid'] = $wid;
                $check_paras['timestamp'] = $time;

                for ($i = 0; $i < $room_count; $i++) {
                    $check_paras['problemid'] = null;
                    $roomid = $this->Moa_check_model->get_roomid_by_room($classroom_list[ $i ]);
                    $check_paras['roomid'] = $roomid;
                    // 课室情况
                    $prob_description = $_POST['cond_evening'][ $i ];

                    // 课室正常
                    if ($prob_description == "" || $prob_description == "正常") {
                        $check_paras['isChecked'] = 1;
                        // 添加晚检记录
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    } // 课室有故障
                    else {
                        $check_paras['isChecked'] = 2;
                        // 添加问题（故障）记录
                        $prob_paras['founder_wid'] = $wid;
                        $prob_paras['roomid'] = $roomid;
                        $prob_paras['description'] = $prob_description;
                        $prob_paras['found_time'] = $time;
                        $prob_paras['solved_time'] = $time;
                        $problemid = $this->Moa_check_model->add_problem($prob_paras);
                        // 添加晚检记录
                        $check_paras['problemid'] = $problemid;
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($problemid && $checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    }
                } // for
                // 是否全部成功写入数据库
                if ($success_count == $room_count) {
                    $substitute = $_POST['is_replaced'];
                    // 添加考勤记录
                    $attend_paras['wid'] = $wid;
                    $attend_paras['timestamp'] = $time;
                    // 周次，周一为一周的第一天
                    $attend_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);
                    // 1-周一  2-周二  ... 6-周六  7-周日
                    $attend_paras['weekday'] = date("w") == 0 ? 7 : date("w");
                    // 签到type: 0-值班  1-早检 2-午检 3-晚检 4-周检
                    $type = 3;
                    $attend_paras['type'] = $type;
                    // 是否迟到：0-否 1-是
                    $attend_paras['isLate'] = 0;
                    // 是否代班：0 - 否   1 - 是
                    $attend_paras['isSubstitute'] = $substitute;
                    if ($substitute) {
                        $attend_paras['substituteFor'] = $_POST['replaced_wid'];
                    }

                    $attend_id = $this->Moa_attend_model->add($attend_paras);

                    // 更新工时
                    $contrib = PublicMethod::get_daily_working_hours($type);
                    $affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
                    $affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);

                    if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
                        echo json_encode(array("status" => false, "msg" => "登记失败"));

                        return;
                    }
                    // 成功写入考勤记录以及工时更新
                    echo json_encode(array("status" => true, "msg" => "提交成功"));

                    return;
                } else {
                    echo json_encode(array("status" => false, "msg" => "提交失败"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }
        }
    }
=======
<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

/**
 * 常检录入控制类
 * @author 伟
 */
Class DailyCheck extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->model('Moa_worker_model');
        $this->load->model('Moa_check_model');
        $this->load->model('Moa_attend_model');
        $this->load->model('Moa_school_term_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    /**
     * 常检签到、课室情况登记页面
     * 常检课室列表加载
     */
    public function index() {
        if (isset($_SESSION['user_id'])) {
            // 检查权限: 0-普通助理  6-超级管理员
            if ($_SESSION['level'] != 0 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }

            // 获取常检课室
            $uid = $_SESSION['user_id'];
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            $classrooms[ $wid ] = $this->Moa_worker_model->get($wid)->classroom;
            $classroom_list[ $wid ] = explode(',', $classrooms[ $wid ]);


            // 取所有普通助理的wid与name, level: 0-普通助理  1-组长  2-负责人助理  3-助理负责人  4-管理员  5-办公室负责人
            $level = 0;
            $common_worker = $this->Moa_user_model->get_by_level($level);

            for ($i = 0; $i < count($common_worker); $i++) {
                $uid_list[ $i ] = $common_worker[ $i ]->uid;
                $name_list[ $i ] = $common_worker[ $i ]->name;
                $wid_list[ $i ] = $this->Moa_worker_model->get_wid_by_uid($uid_list[ $i ]);
                $classrooms[ $wid_list[ $i ] ] = $this->Moa_worker_model->get($wid_list[ $i ])->classroom;
                $classroom_list[ $wid_list[ $i ] ] = explode(',', $classrooms[ $wid_list[ $i ] ]);
            }

            $data['wid'] = $wid;
            $data['name_list'] = $name_list;
            $data['wid_list'] = $wid_list;
            $data['classroom_json'] = json_encode($classroom_list);

            $this->load->view('view_daily_check', $data);
        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

    /*
     * 早检（录入）
     */
    public function dailyCheckMorning() {
        if (isset($_SESSION['user_id'])) {
            if (isset($_POST['is_replaced']) && isset($_POST['replaced_wid'])) {
                if ($_POST['is_replaced'] && !$_POST['replaced_wid']) {
                    echo json_encode(array("status" => false, "msg" => "请选择原值班助理"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }

            // 获取常检课室
            $uid = $_SESSION['user_id'];
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            // 原助理的wid
            $check_wid = $wid;
            if ($_POST['is_replaced']) {
                $check_wid = $_POST['replaced_wid'];
            }
            $classrooms = $this->Moa_worker_model->get($check_wid)->classroom;
            $classroom_list = explode(',', $classrooms);
            $room_count = count($classroom_list);
            $success_count = 0;
            $time = date('Y-m-d H:i:s');
            $term = $this->Moa_school_term_model->get_term($time);

            if (isset($_POST['cond_morning'])) {
                // 周一为一周的第一天
                $check_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);

                // 1-周一  2-周二  ... 6-周六  7-周日
                $check_paras['weekday'] = date("w") == 0 ? 7 : date("w");

                // type: 0-早检  1-午检  2-晚检  3-周检
                $check_paras['type'] = 0;

                // isChecked: 0-否     1-是，正常     2-是，课室有故障
                $check_paras['isChecked'] = 0;

                $check_paras['actual_wid'] = $wid;
                $check_paras['timestamp'] = $time;

                for ($i = 0; $i < $room_count; $i++) {
                    $check_paras['problemid'] = null;
                    $roomid = $this->Moa_check_model->get_roomid_by_room($classroom_list[ $i ]);
                    $check_paras['roomid'] = $roomid;
                    // 课室情况
                    $prob_description = $_POST['cond_morning'][ $i ];

                    // 课室正常
                    if ($prob_description == "" || $prob_description == "正常") {
                        $check_paras['isChecked'] = 1;
                        // 添加早检记录
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    } // 课室有故障
                    else {
                        $check_paras['isChecked'] = 2;
                        // 添加问题（故障）记录
                        $prob_paras['founder_wid'] = $wid;
                        $prob_paras['roomid'] = $roomid;
                        $prob_paras['description'] = $prob_description;
                        $prob_paras['found_time'] = $time;
                        $prob_paras['solved_time'] = $time;
                        $problemid = $this->Moa_check_model->add_problem($prob_paras);
                        // 添加早检记录
                        $check_paras['problemid'] = $problemid;
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($problemid && $checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    }
                } // for
                // 是否全部成功写入数据库
                if ($success_count == $room_count) {
                    $substitute = $_POST['is_replaced'];
                    // 添加考勤记录
                    $attend_paras['wid'] = $wid;
                    $attend_paras['timestamp'] = $time;
                    // 周次，周一为一周的第一天
                    $attend_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);
                    // 1-周一  2-周二  ... 6-周六  7-周日
                    $attend_paras['weekday'] = date("w") == 0 ? 7 : date("w");
                    // 签到type: 0-值班  1-早检 2-午检 3-晚检 4-周检
                    $type = 1;
                    $attend_paras['type'] = $type;
                    // 是否迟到：0-否 1-是
                    $attend_paras['isLate'] = 0;
                    // 是否代班：0 - 否   1 - 是
                    $attend_paras['isSubstitute'] = $substitute;
                    if ($substitute) {
                        $attend_paras['substituteFor'] = $_POST['replaced_wid'];
                    }

                    $attend_id = $this->Moa_attend_model->add($attend_paras);

                    // 更新工时
                    $contrib = PublicMethod::get_daily_working_hours($type);
                    $affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
                    $affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);

                    if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
                        echo json_encode(array("status" => false, "msg" => "登记失败"));

                        return;
                    }
                    // 成功写入考勤记录以及工时更新
                    echo json_encode(array("status" => true, "msg" => "提交成功"));

                    return;
                } else {
                    echo json_encode(array("status" => false, "msg" => "提交失败"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }
        }
    }

    /*
     * 午检（录入）
     */
    public function dailyCheckNoon() {
        if (isset($_SESSION['user_id'])) {
            if (isset($_POST['is_replaced']) && isset($_POST['replaced_wid'])) {
                if ($_POST['is_replaced'] && !$_POST['replaced_wid']) {
                    echo json_encode(array("status" => false, "msg" => "请选择原值班助理"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }

            // 获取常检课室
            $uid = $_SESSION['user_id'];
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            // 原助理的wid
            $check_wid = $wid;
            if ($_POST['is_replaced']) {
                $check_wid = $_POST['replaced_wid'];
            }

            $classrooms = $this->Moa_worker_model->get($check_wid)->classroom;
            $classroom_list = explode(',', $classrooms);
            $room_count = count($classroom_list);
            $success_count = 0;
            $time = date('Y-m-d H:i:s');
            $term = $this->Moa_school_term_model->get_term($time);

            if (isset($_POST['cond_noon'])) {
                // 周一为一周的第一天
                $check_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);

                // 1-周一  2-周二  ... 6-周六  7-周日
                $check_paras['weekday'] = date("w") == 0 ? 7 : date("w");

                // type: 0-早检  1-午检  2-晚检  3-周检
                $check_paras['type'] = 1;

                // isChecked: 0-否     1-是，正常     2-是，课室有故障
                $check_paras['isChecked'] = 0;

                $check_paras['actual_wid'] = $wid;
                $check_paras['timestamp'] = $time;

                for ($i = 0; $i < $room_count; $i++) {
                    $check_paras['problemid'] = null;
                    $roomid = $this->Moa_check_model->get_roomid_by_room($classroom_list[ $i ]);
                    $check_paras['roomid'] = $roomid;
                    // 课室情况
                    $prob_description = $_POST['cond_noon'][ $i ];

                    // 课室正常
                    if ($prob_description == "" || $prob_description == "正常") {
                        $check_paras['isChecked'] = 1;
                        // 添加午检记录
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    } // 课室有故障
                    else {
                        $check_paras['isChecked'] = 2;
                        // 添加问题（故障）记录
                        $prob_paras['founder_wid'] = $wid;
                        $prob_paras['roomid'] = $roomid;
                        $prob_paras['description'] = $prob_description;
                        $prob_paras['found_time'] = $time;
                        $prob_paras['solved_time'] = $time;
                        $problemid = $this->Moa_check_model->add_problem($prob_paras);
                        // 添加午检记录
                        $check_paras['problemid'] = $problemid;
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($problemid && $checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    }
                } // for
                // 是否全部成功写入数据库
                if ($success_count == $room_count) {
                    $substitute = $_POST['is_replaced'];
                    // 添加考勤记录
                    $attend_paras['wid'] = $wid;
                    $attend_paras['timestamp'] = $time;
                    // 周次，周一为一周的第一天
                    $attend_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);
                    // 1-周一  2-周二  ... 6-周六  7-周日
                    $attend_paras['weekday'] = date("w") == 0 ? 7 : date("w");
                    // 签到type: 0-值班  1-早检 2-午检 3-晚检 4-周检
                    $type = 2;
                    $attend_paras['type'] = $type;
                    // 是否迟到：0-否 1-是
                    $attend_paras['isLate'] = 0;
                    // 是否代班：0 - 否   1 - 是
                    $attend_paras['isSubstitute'] = $substitute;
                    if ($substitute) {
                        $attend_paras['substituteFor'] = $_POST['replaced_wid'];
                    }

                    $attend_id = $this->Moa_attend_model->add($attend_paras);

                    // 更新工时
                    $contrib = PublicMethod::get_daily_working_hours($type);
                    $affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
                    $affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);

                    if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
                        echo json_encode(array("status" => false, "msg" => "登记失败"));

                        return;
                    }
                    // 成功写入考勤记录以及工时更新
                    echo json_encode(array("status" => true, "msg" => "提交成功"));

                    return;
                } else {
                    echo json_encode(array("status" => false, "msg" => "提交失败"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }
        }
    }

    /*
     * 晚检（录入）
     */
    public function dailyCheckEvening() {
        if (isset($_SESSION['user_id'])) {
            if (isset($_POST['is_replaced']) && isset($_POST['replaced_wid'])) {
                if ($_POST['is_replaced'] && !$_POST['replaced_wid']) {
                    echo json_encode(array("status" => false, "msg" => "请选择原值班助理"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }

            // 获取常检课室
            $uid = $_SESSION['user_id'];
            $wid = $this->Moa_worker_model->get_wid_by_uid($uid);
            // 原助理的wid
            $check_wid = $wid;
            if ($_POST['is_replaced']) {
                $check_wid = $_POST['replaced_wid'];
            }

            $classrooms = $this->Moa_worker_model->get($check_wid)->classroom;
            $classroom_list = explode(',', $classrooms);
            $room_count = count($classroom_list);
            $success_count = 0;
            $time = date('Y-m-d H:i:s');
            $term = $this->Moa_school_term_model->get_term($time);

            if (isset($_POST['cond_evening'])) {
                // 周一为一周的第一天
                $check_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);

                // 1-周一  2-周二  ... 6-周六  7-周日
                $check_paras['weekday'] = date("w") == 0 ? 7 : date("w");

                // type: 0-早检  1-午检  2-晚检  3-周检
                $check_paras['type'] = 2;

                // isChecked: 0-否     1-是，正常     2-是，课室有故障
                $check_paras['isChecked'] = 0;

                $check_paras['actual_wid'] = $wid;
                $check_paras['timestamp'] = $time;

                for ($i = 0; $i < $room_count; $i++) {
                    $check_paras['problemid'] = null;
                    $roomid = $this->Moa_check_model->get_roomid_by_room($classroom_list[ $i ]);
                    $check_paras['roomid'] = $roomid;
                    // 课室情况
                    $prob_description = $_POST['cond_evening'][ $i ];

                    // 课室正常
                    if ($prob_description == "" || $prob_description == "正常") {
                        $check_paras['isChecked'] = 1;
                        // 添加晚检记录
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    } // 课室有故障
                    else {
                        $check_paras['isChecked'] = 2;
                        // 添加问题（故障）记录
                        $prob_paras['founder_wid'] = $wid;
                        $prob_paras['roomid'] = $roomid;
                        $prob_paras['description'] = $prob_description;
                        $prob_paras['found_time'] = $time;
                        $prob_paras['solved_time'] = $time;
                        $problemid = $this->Moa_check_model->add_problem($prob_paras);
                        // 添加晚检记录
                        $check_paras['problemid'] = $problemid;
                        $checkid = $this->Moa_check_model->add_check($check_paras);
                        if ($problemid && $checkid) {
                            $success_count++;
                            continue;
                        } else {
                            echo json_encode(array("status" => false, "msg" => "提交失败"));

                            return;
                        }
                    }
                } // for
                // 是否全部成功写入数据库
                if ($success_count == $room_count) {
                    $substitute = $_POST['is_replaced'];
                    // 添加考勤记录
                    $attend_paras['wid'] = $wid;
                    $attend_paras['timestamp'] = $time;
                    // 周次，周一为一周的第一天
                    $attend_paras['weekcount'] = PublicMethod::get_week($term[0]->termbeginstamp, $time);
                    // 1-周一  2-周二  ... 6-周六  7-周日
                    $attend_paras['weekday'] = date("w") == 0 ? 7 : date("w");
                    // 签到type: 0-值班  1-早检 2-午检 3-晚检 4-周检
                    $type = 3;
                    $attend_paras['type'] = $type;
                    // 是否迟到：0-否 1-是
                    $attend_paras['isLate'] = 0;
                    // 是否代班：0 - 否   1 - 是
                    $attend_paras['isSubstitute'] = $substitute;
                    if ($substitute) {
                        $attend_paras['substituteFor'] = $_POST['replaced_wid'];
                    }

                    $attend_id = $this->Moa_attend_model->add($attend_paras);

                    // 更新工时
                    $contrib = PublicMethod::get_daily_working_hours($type);
                    $affected_rows = $this->Moa_worker_model->update_worktime($wid, $contrib);
                    $affected_rows_u = $this->Moa_user_model->update_contribution($uid, $contrib);

                    if (!($attend_id) || $affected_rows == 0 || $affected_rows_u == 0) {
                        echo json_encode(array("status" => false, "msg" => "登记失败"));

                        return;
                    }
                    // 成功写入考勤记录以及工时更新
                    echo json_encode(array("status" => true, "msg" => "提交成功"));

                    return;
                } else {
                    echo json_encode(array("status" => false, "msg" => "提交失败"));

                    return;
                }
            } else {
                echo json_encode(array("status" => false, "msg" => "提交失败"));

                return;
            }
        }
    }
>>>>>>> abnormal
}