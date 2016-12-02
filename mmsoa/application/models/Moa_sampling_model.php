<?php
/**
 * 抽查 Alcanderian、Rinkako
 */
class Moa_sampling_model extends CI_Model{
    /*
     * $paras 參數表
     */
    public function add_new_table($paras) {
        $len = count($paras, COUNT_NORMAL);
        $ret = array();
        if (isset($paras)) {
            for($i = 0; $i < $len; ++$i) {
                $this->db->insert('MOA_Sampling', $paras[$i]);
                $ret[$i]  = $this->db->insert_id();
            }
            return $ret;
        }
        else {
            return false;
        }
    }

    /**
     * @param $paras 要刪除的抽查表的創建時間
     * @return bool
     */
    public function delete_table($timestamp) {
        if (isset($timestamp)) {
            $this->db->where(array(
                'timestamp' => $timestamp,
                'on_use' => 1,
            ));
            $this->db->update('MOA_Sampling', array('on_use' => 0));
            return $this->db->affected_rows();
        }
        else {
            return false;
        }
    }

    public function get($sid) {
        if(isset($sid)) {
            $this->db->where(array('sid' => $sid));
            return $this->db->get('MOA_Sampling')->result();
        } else {
            return $this->db->get('MOA_Sampling')->result();
        }
    }

    public function get_table($timestamp) {
        if (isset($timestamp)) {
            $this->db->where(array('on_use' => 1, 'timestamp =' => $timestamp));
            return $this->db->get('MOA_Sampling')->result();
        }
        else {
            return false;
        }
    }

    /**
     * $paras 參數表
     */
    public function update_a_record($paras, $sid) {
        if (isset($paras) && isset($sid)) {
            $this->db->where(array(
                'sid' => $sid,
                'on_use' => 1,
            ));
            $this->db->update('MOA_Sampling', $paras);
            return $this->db->affected_rows() + 1;
        }
        else {
            return false;
        }
    }

    /**
     * 取指定状态、数目、时间段的抽查記錄
     * @param unknown $date 该时间之前
     * @param unknown $onuse 抽查記錄状态
     * @param string $nums 最大数目
     * @param number $offset 偏移量
     */
    public function get_by_date($date, $on_use, $nums = NULL, $offset = 0) {
        if (isset($date) && isset($on_use)) {
            $this->db->where(array('on_use' => $on_use, 'timestamp <' => $date));
            $this->db->order_by('timestamp', 'DESC');
            if (!is_null($nums)) {
                $this->db->limit($nums, $offset);
            }
            return $this->db->get('MOA_Sampling')->result();
        }
        else {
            return false;
        }
    }
    
    /**
     * 以月份为单位获取抽查优秀排行
     * @author Rinkako
     */
    public function get_rank_month() {
        $qStr = 'SELECT wid, uid, checks, perfect FROM moa_worker ORDER BY perfect DESC';
        return $this->db->query($qStr)->result();
    }
    
    /**
     * 获取历史累计抽查优秀排行
     * @author Rinkako
     */
    public function get_rank_all() {
        $qStr = 'SELECT uid, username, totalCheck, totalPerfect FROM moa_user ORDER BY totalPerfect DESC';
        return $this->db->query($qStr)->result();
    }
}

