<?php
/**
 * Created by PhpStorm.
 * User: Jerry
 * Date: 2016/11/17
 * Time: 下午3:58
 */
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');

class DutyOut extends CI_Controller {

    public function dutyOut(){
        if (isset($_SESSION['user_id'])) {
            // 检查权限: 2-负责人助理 3-助理负责人 5-办公室负责人 6-超级管理员
            if ($_SESSION['level'] != 2 && $_SESSION['level'] != 3 && $_SESSION['level'] != 5 && $_SESSION['level'] != 6) {
                // 提示权限不够
                PublicMethod::permissionDenied();
            }

            $this->load->view('view_duty_out');

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }

}