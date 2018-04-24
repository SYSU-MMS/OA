<?php
/**
 * Created by Alcan
 * 值班报名：
 * 功能点有
 * - 创建报名表
 * - 写入报名表
 * - 查看某个人报名的情况
 * - 查看总体报名情况
 */
class Moa_dutyregister_model extends CI_Model
{
    /**
     * 添加一张报名表
     * @param $paras array 报名表的框架，报名开始结束，以及时间段信息
     * @return bool 报名表id， 如失败则false
     */
    public function add_table($paras)
    {
        if (isset($paras)) {
            $this->db->insert('MOA_DutyRegisterBrief', $paras);
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * 假删除
     * @param $drid
     * @return bool
     */
    public function delete_table($drid)
    {
        if (isset($drid)) {
            $this->db->where(array('drid' => $drid));
            $this->db->update('MOA_DutyRegisterBrief', array('onuse' => 0));
            return $this->db->affected_rows() + 1;
        }
        else {
            return false;
        }
    }

    /**
     * 所有报名表的信息
     * @return array
     */
    public function get_tables()
    {
        $this->db->where(array('onuse' => 1));
        $this->db->order_by('drid', 'DESC');
        return $this->db->get('MOA_DutyRegisterBrief')->result();
    }

    /**
     * 某张报名表的信息
     */
    public function get_table($drid)
    {
        if (isset($drid)) {
            $this->db->where(array('drid' => $drid, 'onuse' => 1));
            $ret = $this->db->get('MOA_DutyRegisterBrief')->result();
            if($ret[0] != null)
                return $ret[0];
            return false;
        } else {
            return false;
        }
    }

    /**
     * 某张报名表的信息以及报名情况
     * @param $drid
     * @return array|null
     */
    public function get_table_and_detail($drid)
    {
        $ret = false;
        if (isset($drid)) {
            $this->db->where(array('drid' => $drid));
            $tmp = $this->db->get('MOA_DutyRegisterBrief')->result();
            if ($tmp[0]->onuse == 1) {
                $ret = array();
                $ret[0] = $tmp[0];
                $this->db->where(array('drid' => $drid));
                $this->db->order_by('uid', 'ASC');
                $ret[1] = $this->db->get('MOA_DutyRegisterDetail')->result();
            }
        }
        return $ret;
    }

    /**
     * 某张报名表的信息以及某个用户的报名情况
     * @param $drid
     * @param $uid
     * @return array|null
     */
    public function get_table_and_detail_with_uid($drid, $uid)
    {
        $ret = false;
        if (isset($drid) && isset($uid)) {
            $this->db->where(array('drid' => $drid));
            $tmp = $this->db->get('MOA_DutyRegisterBrief')->result();
            if ($tmp[0]->onuse == 1) {
                $ret = array();
                $ret[0] = $tmp[0];
                $this->db->where(array('drid' => $drid, 'uid' => $uid));
                $this->db->order_by('uid', 'ASC');
                $ret[1] = $this->db->get('MOA_DutyRegisterDetail')->result();
            }

        }
        return $ret;
    }

    public function add_record($paras)
    {
        $ret = false;
        if (isset($paras)) {

            $this->db->insert('MOA_DutyRegisterDetail', $paras);
            $ret = $this->db->insert_id();
        }
        return $ret;
    }

    public function delete_record($drid, $period, $weekday, $uid)
    {
        if (isset($drid) && isset($uid) && isset($period) && isset($weekday))
        {
            $this->db->where(array('drid' => $drid, 'period' => $period, 'weekday' => $weekday, 'uid' => $uid));
            $this->db->delete('MOA_DutyRegisterDetail');
            return ($this->db->affected_rows() == 1);
        } else {
            return false;
        }
    }


    /**
     * 某张报名表中某个时间点的报名者
     * @param $drid
     * @param $period
     * @param $weekday
     * @return array|bool
     */
    public function get_point($drid, $period, $weekday)
    {
        $ret = false;
        if(isset($drid) && isset($period) && isset($weekday)){
            $this->db->where(array('drid' => $drid, 'period' => $period, 'weekday' => $weekday));
            $ret = $this->db->get('MOA_DutyRegisterDetail')->result();
        }
        return $ret;
    }

    /**
     * 添加一堆报名记录
     * @param $paras_arr
     * @return array|bool
     */
    public function add_records($paras_arr)
    {
        if (isset($paras_arr)) {
            $len = count($paras_arr, COUNT_NORMAL);
            $ret = array();
            for($i = 0; $i < $len; ++$i)
            {
                $this->db->insert('MOA_DutyRegisterDetail', $paras_arr[$i]);
                $ret[$i] = $this->db->insert_id();
            }
            return $ret;
        } else {
            return false;
        }
    }

    /**
     * 删除一个用户在某张报名表的报名记录
     * @param $drid int 报名表id
     * @param $uid int 用户uid
     * @return int
     */
    public function delete_records($drid, $uid)
    {
        if (isset($drid) && isset($uid))
        {
            $this->db->where(array('drid' => $drid, 'uid' => $uid));
            $this->db->delete('MOA_DutyRegisterDetail');
            return $this->db->affected_rows() + 1;
        } else {
            return false;
        }
    }
}