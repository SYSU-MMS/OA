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
    public function add_dutyout($room_id, $problem_id, $duty, $time)
    {
        if (isset($_SESSION['user_id'])) {
            $wid = $this->Moa_worker_model->get_wid_by_uid($_SESSION['user_id']);
            //$time = date("Y-m-d H:i:s");
            $weekday = date("w") == 0 ? 7 : date("w");
            $shorttime = date("H:i:s");
            //$duty = PublicMethod::get_duty_periods($weekday, $shorttime, $shorttime);
            $weekcount = PublicMethod::cal_week();
            /*$isSuccess = $this->db->query("insert into `moa_dutyout` (`dutyid`,`wid`,`weekcount`,`outtimestamp`," .
                "`roomid`,`problemid`) values(" .
                $this->db->escape($duty) .
                $this->db->escape($wid) .
                $this->db->escape($weekcount) .
                $this->db->escape($time) .
                $this->db->escape($room_id) .
                $this->db->escape($problem_id) .
                ")");*/
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
            return false;
        }
    }

    public function add($room_id, $description, $duty, $time)
    {
        if (isset($_SESSION['user_id'])) {
            $wid = $this->Moa_worker_model->get_wid_by_uid($_SESSION['user_id']);
            $insert_data = array();
            $insert_data['founder_wid'] = $wid;
            $insert_data['roomid'] = $room_id;
            $insert_data['description'] = $description;
            $problem_id = $this->Moa_problem_model->add($insert_data);
            $do_id = $this->add_dutyout($room_id, $problem_id, $duty, $time);
            return $do_id;
        }
    }

    public function get($offset = 0, $limit = 20)
    {

    }

    public function get_all()
    {
        if (isset($_SESSION['user_id'])) {
            $query = $this->db->query("select * from `moa_dutyout` order by `doid` DESC");
            $result = $query->result_array();
            //echo json_encode(array("status" => true, "data" => $result));
            return $result;
        } else {
            //PublicMethod::requireLogin();
        }
    }

    public function update_by_id($doid, $wid, $time)
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
    }


}