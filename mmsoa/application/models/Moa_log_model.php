<?php
/**
 * 日志模型类
 * @author RKK
 */
class Moa_log_model extends CI_Model {
 	/**
	 * 加入一个新记录
	 * @param paras - 参数列表
	 * @return 这个记录的id
	 */
	public function add($paras) {
		if (isset($paras)) {
			$this->db->insert('MOA_Log', $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}

	/**
	 * 取日志信息
	 * @param id - 日志id号
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get($id = NULL, $nums = NULL, $offset = 0) {
		if (isset($id)) {
			$this->db->where(array('logid'=>$id));
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Log')->result();
		}
		else {
			return $this->db->get('MOA_Log')->result();
		}
	}

	/**
	 * 取某wid发起的事件日志
	 * @param wid - 发起人wid
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_dasher($wid, $nums = NULL, $offset = 0) {
		if (isset($wid)) {
			$this->db->where(array('dasher_wid'=>$wid));
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Log')->result();
		}
		else {
			return false;
		}
	}

	/**
	 * 取作用于某wid的事件日志
	 * @param wid - 被作用wid
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_affected($wid, $nums = NULL, $offset = 0) {
		if (isset($wid)) {
			$this->db->where(array('affect_wid'=>$wid));
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Log')->result();
		}
		else {
			return false;
		}
	}
    
	/**
	 * 取某时间段内的事件日志
	 * @param starttime - 开始日期
	 * @param endtime - 结束日期
	 */
	public function update_worktime($starttime, $endtime) {
		if (isset($starttime) and isset($endtime)) {
			$sb = 'SELECT * FROM MOA_Log WHERE logtimestamp BETWEEN ' . $starttime . ' AND ' . $endtime;
			$sqlquery = $this->db->query($sb);
			return $dataarr = $sqlquery->result();
		}
		else {
			return false;
		}
	}
}