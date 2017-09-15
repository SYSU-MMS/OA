<?php
/**
 * Created by PhpStorm.
 * User: zhong
 * Date: 2017/9/14
 * Time: 2:00
 */

/**
 * 失物招领类 - 拾获
 */
class Moa_found_model extends CI_Model{

    public function get_all($para = 1){
        if (isset($_SESSION['user_id'])){
            // 状态：0 - 正常；1 - 已领；2 - 删除
            if ($para == 0) {
                $query = $this->db->query("select * from moa_found order by `fid` DESC");
                $result = $query->result();
                return $result;
            } else {
                $query = $this->db->query("select * from moa_found where state != 1 order by `fid` DESC");
                $result = $query->result();
                return $result;
            }
        }
    }

    public function get_by_fid($fid = 0){
        if (isset($_SESSION['user_id'])){
            if (!is_numeric($fid)) return 0;
            $query = $this->db->query("select * from moa_found where fid = " . $this->db->escape($fid));
            $result = $query->result();
            return $result;
        }
    }

    // 删除功能
    public function delete_by_fid($fid = 0){

    }

    // 登记领取人信息
    public function  get_back($fid = 0, $owid, $owner, $odatetime, $ocontact, $onumber){

    }

    // 登记拾获物品信息
    public function sign_up_item($fwid, $signuptime, $fdatetime, $fdescription, $fplace, $finder, $fcontact){

    }

}