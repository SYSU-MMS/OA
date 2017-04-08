<?php

/**
 * Created by PhpStorm.
 * User: Jerry
 * Date: 2017/2/28
 * Time: 15:06
 * 拍摄记录
 * By 钟凌山
 */
class Moa_filming_model extends CI_Model
{
    public function add($wid, $date, $fmname, $aename, $worktime)
    {
        if (isset($_SESSION['user_id']) && isset($wid) && is_numeric($worktime) && $worktime >= 0) {
            $sql = "insert into `moa_filming` (`wid`, `date`, `fmname`, `aename`, `worktime`) values(" .
                $this->db->escape($wid) . "," .
                $this->db->escape($date) . "," .
                $this->db->escape($fmname) . "," .
                $this->db->escape($aename) . "," .
                $this->db->escape($worktime) .
                ")";
            $this->db->query($sql);
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function get_all($para = 0)
    {
        if (isset($_SESSION['user_id'])) {
            if ($para != 0) {
                $query = $this->db->query("select * from moa_filming order by `fid` DESC");
                $result = $query->result();
                return $result;
            } else {
                $query = $this->db->query("select * from moa_filming where state = 0 order by `fid` DESC");
                $result = $query->result();
                return $result;
            }
        } else {
            //PublicMethod::requireLogin();
        }
    }

    public function get_by_fid($fid)
    {
        if (isset($_SESSION['user_id'])) {
            $sql = "select * from moa_filming where fid = " . $this->db->escape($fid);
            $query = $this->db->query($sql);
            $res = $query->result();
            return $res[0];
        }
    }

    public function delete_by_fid($fid)
    {
        if (isset($_SESSION['user_id'])) {
            //if ($_SESSION['level'] >= 2) {
            $sql = "update moa_filming set state = 1 where fid = " . $this->db->escape($fid);
            $query = $this->db->query($sql);
            return $query;
            //}
        }
        //return false;
    }
}