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
                $query = $this->db->query("select * from moa_found where state != 2 order by `fid` DESC");
                $result = $query->result();
                return $result;
            }
        }
        return false;
    }

    public function get_by_fid($fid = 0){
        if (isset($_SESSION['user_id'])){
            if (!is_numeric($fid)) return 0;
            $query = $this->db->query("select * from moa_found where fid = " . $this->db->escape($fid));
            $result = $query->result();
            return $result[0];
        }
        return false;
    }

    // 删除功能
    public function delete_by_fid($fid = 0){
        if (isset($_SESSION['user_id'])){
            // fid不合法则退出
            if ($fid <= 0) return false;
            $res = $this->get_by_fid($fid);
            // 非自己创建的记录或管理级别不够则退出
            if ($res->fwid != $_SESSION['worker_id'] && $_SESSION['level'] < 2) return false;
            $query = $this->db->query("update moa_found set state = 2 where fid = " . $this->db->escape($fid));
            $result = $this->db->affected_rows();
            return $result;
        }
        return false;
    }

    // 登记领取人信息
    public function update_by_fid($fid = 0, $owid, $owner, $odatetime, $ocontact, $onumber){
    if (isset($_SESSION['user_id'])){
        // fid不合法则退出
        if ($fid <= 0) return false;
        $res = $this->get_by_fid($fid);
        // 权限不足则退出
        if ($res->state > 0 && //$res->fwid != $_SESSION['worker_id'] &&
            $res->owid != $_SESSION['worker_id'] && $_SESSION['level'] < 2) return false;

        $sql = "update moa_found set " .
            "owid = " . $this->db->escape($owid) . ", " .
            "owner = " . $this->db->escape(htmlspecialchars($owner)) . ", " .
            "odatetime = " . $this->db->escape($odatetime) . ", " .
            "ocontact = " . $this->db->escape(htmlspecialchars($ocontact)) . ", " .
            "onumber = " . $this->db->escape(htmlspecialchars($onumber)) . ", " .
            "state = 1 where fid = " . $this->db->escape($fid) . ";";

        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }
    return false;
}

    // 登记拾获物品信息
    public function sign_up_item($fwid, $signuptime, $fdatetime, $fdescription, $fplace, $finder, $fcontact, $state = 0){
        if (isset($_SESSION['user_id'])){
            $sql = "insert into moa_found (`fwid`, `signuptime`, `fdatetime`, `fdescription`, `fplace`, `finder`, `fcontact`, `state`)" .
                "values(" .
                $this->db->escape($fwid) . "," .
                $this->db->escape($signuptime) . "," .
                $this->db->escape($fdatetime) . "," .
                $this->db->escape(htmlspecialchars($fdescription)) . "," .
                $this->db->escape(htmlspecialchars($fplace)) . "," .
                $this->db->escape(htmlspecialchars($finder)) . "," .
                $this->db->escape(htmlspecialchars($fcontact)) . "," .
                $this->db->escape($state) . ")";

            $query = $this->db->query($sql);
            return $this->db->insert_id();
        }
        return false;
    }

}