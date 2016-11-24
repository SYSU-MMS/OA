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

            $insert_data = array();
            $insert_data['dutyid'] = $duty;
            $insert_data['wid'] = $wid;
            $insert_data['weekcount'] = $weekcount;
            $insert_data['outtimestamp'] = strtotime($time);
            $insert_data['roomid'] = $room_id;
            $insert_data['problemid'] = $problem_id;
            $this->db->insert('moa_dutyout', $insert_data);

            return $this->db->insert_id();

        } else {
            //echo json_encode(array("status" => false));
            return;
        }
    }

    public function add($wid, $room_id, $pid, $duty, $time)
    {
        if (isset($_SESSION['user_id'])) {
            //$wid = $this->Moa_worker_model->get_wid_by_uid($_SESSION['user_id']);
            $weekcount = PublicMethod::cal_week();
            $do_id = $this->add_dutyout($wid, $room_id, $pid, $duty, $time, $weekcount);
            return $do_id;
        }
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
        return false;
    }


}