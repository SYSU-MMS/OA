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

            //todo

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

            //todo


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

            //todo


        } else {
            // 未登录的用户请先登录
            PublicMethod::requireLogin();
        }
    }
}