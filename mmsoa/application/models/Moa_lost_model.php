<?php
/**
 * Created by PhpStorm.
 * User: zhong
 * Date: 2017/9/15
 * Time: 23:40
 */

/**
 * 失物招领类 - 遗失
 */
class Moa_lost_model extends CI_Model {
    public function get_all($para = 1){
        if (isset($_SESSION['user_id'])){
            // 状态：0 - 正常；1 - 已领；2 - 删除
            if ($para == 0) {
                $query = $this->db->query("select * from moa_lost order by `lid` DESC");
                $result = $query->result();
                return $result;
            } else {
                $query = $this->db->query("select * from moa_lost where state != 2 order by `lid` DESC");
                $result = $query->result();
                return $result;
            }
        }
        return false;
    }

    public function get_by_lid($lid = 0){
        if (isset($_SESSION['user_id'])){
            if (!is_numeric($lid)) return 0;
            $query = $this->db->query("select * from moa_lost where lid = " . $this->db->escape($lid));
            $result = $query->result();
            return $result[0];
        }
        return false;
    }

    // 删除功能
    public function delete_by_lid($lid = 0){
        if (isset($_SESSION['user_id'])){
            // lid不合法则退出
            if ($lid <= 0) return false;
            $res = $this->get_by_lid($lid);
            // 非自己创建的记录或管理级别不够则退出
            if ($res->lwid != $_SESSION['worker_id'] && $_SESSION['level'] < 2) return false;
            $query = $this->db->query("update moa_lost set state = 2 where lid = " . $this->db->escape($lid));
            $result = $this->db->affected_rows();
            return $result;
        }
        return false;
    }

    public function update_by_lid($lid = 0){
        if (isset($_SESSION['user_id'])){
            // fid不合法则退出
            if ($lid <= 0) return false;
            $res = $this->get_by_lid($lid);
            // 权限不足则退出
            if ($res->state > 0) return false;

            $sql = "update moa_lost set " .
                "state = 1 where lid = " . $this->db->escape($lid) . ";";

            $query = $this->db->query($sql);
            return $this->db->affected_rows();
        }
        return false;
    }


    // 登记拾获物品信息
    public function sign_up_item($lwid, $signuptime, $ldatetime, $ldescription, $lplace, $loser, $lcontact, $state = 0){
        if (isset($_SESSION['user_id'])){
            $sql = "insert into moa_lost (`lwid`, `signuptime`, `ldatetime`, `ldescription`, `lplace`, `loser`, `lcontact`, `state`)" .
                "values(" .
                $this->db->escape($lwid) . "," .
                $this->db->escape($signuptime) . "," .
                $this->db->escape($ldatetime) . "," .
                $this->db->escape(htmlspecialchars($ldescription)) . "," .
                $this->db->escape(htmlspecialchars($lplace)) . "," .
                $this->db->escape(htmlspecialchars($loser)) . "," .
                $this->db->escape(htmlspecialchars($lcontact)) . "," .
                $this->db->escape($state) . ")";

            $query = $this->db->query($sql);
            return $this->db->insert_id();
        }
        return false;
    }
}