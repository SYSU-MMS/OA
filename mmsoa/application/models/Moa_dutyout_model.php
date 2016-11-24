<?php

/**
 * Created by PhpStorm.
 * User: Jerry
 * Date: 2016/11/20
 * Time: 下午10:23
 * 出勤记录
 */
class Moa_dutyout_model extends CI_Model
{
    public function add_dutyout($wid, $room_id, $problem_id, $duty, $time, $weekcount)
    {
        if (isset($_SESSION['user_id']) && isset($wid)) {

            $sql = "insert into moa_dutyout (dutyid, wid, weekcount, outtimestamp, roomid, problemid) values(" .
                $this->db->escape($duty) .
                $this->db->escape($wid) .
                $this->db->escape($weekcount) .
                $this->db->escape($time) .
                $this->db->escape($room_id) .
                $this->db->escape($problem_id) .
                ")";
            //var_dump($sql);
            $query = $this->db->query($sql);

            return $this->db->insert_id();
            //return $sql;

        } else {
            //echo json_encode(array("status" => false));
            return;
        }
    }

    public function add($wid, $pid, $duty)
    {
        if (isset($_SESSION['user_id'])) {
            $weekcount = PublicMethod::cal_week();
            $problem = $this->Moa_problem_model->get($pid);
            $room_id = $problem->roomid;
            $time = date("Y-m-d H:i:s");
            $do_id = $this->add_dutyout($wid, $room_id, $pid, $duty, $time, $weekcount);
            return $do_id;
        }
    }

    /**
     * 插入一条problem
     * @param founder_wid, found_time, roomid, description
     * @author 高少彬
     * @return 插入的id
     */
    public function insert($founder_wid, $found_time, $roomid, $description)
    {

        $sql = 'insert into moa_problem ' .
            '	(founder_wid, found_time, roomid, description) ' .
            'value (' . $founder_wid . ', \'' . $found_time . '\', ' . $roomid . ', \'' . $description . '\');';
        $result = $this->db->query($sql);
        return $this->db->insert_id();

    }

    public function get($offset = 0, $limit = 20)
    {

    }

    public function get_all($para = 0)
    {
        if (isset($_SESSION['user_id'])) {
            if ($para == 0) {
                $query = $this->db->query("select * from moa_dutyout order by `doid` DESC");
                $result = $query->result();
                return $result;
            } else {
                $query = $this->db->query("select * from moa_dutyout where state = 0 order by `doid` DESC");
                $result = $query->result();
                return $result;
            }
        } else {
            //PublicMethod::requireLogin();
        }
    }

    public function get_by_doid($doid)
    {
        if (isset($_SESSION['user_id'])) {
            $sql = "select * from moa_dutyout where doid = " . $this->db->escape($doid);
            $query = $this->db->query($sql);
            $res = $query->result();
            return $res[0];
        }
    }

    /*public function update_by_id($doid, $wid, $time)
    {
        if (isset($_SESSION['user_id'])) {
            //$time = date("Y-m-d H:i:s");
            $sql = "update `moa_dutyout` set " .
                "`finishtimestamp`=" . $this->db->escape($time) .
                "`finishwid`=" . $this->db->escape($wid) .
                "where `doid`=" . $this->db->escape($doid);
            $isSuccess = $this->db->query($sql);
            if ($isSuccess == true) {
                //echo json_encode(array("status" => true));
            } else {
                //echo json_encode(array("status" => false));
            }
        } else {
            return false;
        }
    }*/

    public function delete_by_doid($doid)
    {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] >= 2) {
                $sql = "update moa_dutyout set state = 1 where doid = " . $this->db->escape($doid);
                $query = $this->db->query($sql);
                return $query;
            }
        }
        //return false;
    }


}