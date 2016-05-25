<?php
/**
 * 工作通知模型类
 * @author wico
 */
class moa_notice_model extends CI_Model {
    /**
     * 增加一则通知
     * @param paras - 参数列表
     * @return 通知nid
     */
    public function add($paras) {
        if (isset($paras)) {
            $this->db->insert('MOA_Notice', $paras);
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }
    
    /**
     * 取指定状态、数目、时间段的通知
     * @param unknown $date 该时间之前
     * @param unknown $state 帖子状态
     * @param string $nums 最大数目
     * @param number $offset 偏移量
     */
    public function get_by_date($date, $state, $nums = NULL, $offset = 0) {
    	if (isset($date) && isset($state)) {
    		$this->db->where(array('state' => $state, 'timestamp <' => $date));
    		$this->db->order_by('timestamp', 'DESC');
    		if (!is_null($nums)) {
    			$this->db->limit($nums, $offset);
    		}
    		return $this->db->get('MOA_Notice')->result();
    	}
    	else {
    		return false;
    	}
    }
    
    
}