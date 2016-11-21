<?php
/**
 * 抽查 Alcanderian
 */
class Moa_duty_model extends CI_Model{
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
    public function delete_table($paras) {
        if (isset($paras)) {
            $this->db->where(array(
                'timestamp' => $paras['timestamp'],
                'on_use' => 1,
            ));
            $this->db->update('MOA_Sampling', array('on_use' => 0));
            return $this->db->affected_rows();
        }
        else {
            return false;
        }
    }

    /**
     * $paras 參數表
     */
    public function update_a_recode($paras) {
        if (isset($paras)) {
            $this->db->where(array(
                'target_uid' => $paras['target_uid'],
                'timestamp' => $paras['timestamp'],
                'on_use' => 1,
            ));
            $this->db->update('MOA_Sampling', $paras);
            return $this->db->affected_rows();
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
}

