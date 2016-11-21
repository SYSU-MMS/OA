<?php

/**
 * 空余时间表类
 * @author Rinka
 */
class Moa_duty_model extends CI_Model
{
    /**
     * 加入一个新排班记录
     * @param paras - 参数列表
     * @return 这个记录的id
     */
    public function add($paras)
    {
        if (isset($paras)) {
            $this->db->insert('MOA_Duty', $paras);
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * 取全部记录
     */
    public function get_all()
    {
        $this->db->order_by('weekday', 'ASC');
        $this->db->order_by('period', 'ASC');
        return $this->db->get('MOA_Duty')->result();
    }

    /**
     * 获得某个时间段的排班记录
     * @param id - 排班时间段id
     */
    public function get_by_period($period)
    {
        if (isset($period)) {
            $sb = 'SELECT * FROM MOA_Duty WHERE CHARINDEX(\'' . $period . '\', period) > 0';
            $sqlquery = $this->db->query($sb);
            return $sqlquery->result();
        } else {
            return false;
        }
    }

    public function get_by_id($dutyid)
    {
        if (isset($dutyid)) {
            $sql = "select * from `moa_duty` where `dutyid` =" . $this->db->escape($dutyid);
            $query = $this->db->query($sql);
            $ret = $query->result();
            return $ret[0];
        }
    }

    /**
     * 删除排班表记录
     * @param id - 排班时间段id
     */
    public function delete($dutyid)
    {
        if (isset($dutyid)) {
            $sb = 'DELETE FROM MOA_Duty WHERE dutyid = ' . $dutyid;
            $sqlquery = $this->db->query($sb);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    /**
     * 清空排班表
     */
    public function clear()
    {
        $sb = 'DELETE FROM MOA_Duty';
        $sqlquery = $this->db->query($sb);
        return $this->db->affected_rows();
    }

}
