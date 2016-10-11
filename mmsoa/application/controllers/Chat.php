<?php
header("Content-type: text/html; charset=utf-8");

require_once('PublicMethod.php');


/**
 * 私信系统类
 * @author 高少彬
 */
class chat extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Moa_user_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    public function index()
    {
        $this->load->view('view_chat_view');
    }

    public function getUserList() {
        if (isset($_SESSION['user_id'])) {
            $uid = $_SESSION['user_id'];
            //0代表正常
            $userlist = $this->Moa_user_model->get_by_state(0);
            $user = $this->Moa_user_model->get($uid);
            if(count($userlist) != 0) {
                echo json_encode(array("status" => TRUE, "msg" => "获取所有用户列表成功", "data" => $userlist, "user" => $user, "uid" => $uid));
                return;
            }

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
            return;
        }
    }

    public function getNowUser() {
        if (isset($_SESSION['user_id'])) {
            $uid = $_SESSION['user_id'];
            echo json_encode(array("status" => TRUE, "msg" => "获取session用户成功", "uid" => $uid));
            return;

        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
            return;
        }
    }
}
