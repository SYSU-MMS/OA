<?php
/**
 * 空余时间表类
 * @author Rinka
 */
class Moa_nschedule_model extends CI_Model {
 	/**
	 * 加入一个新空余时间记录
	 * @param paras - 参数列表
	 * @return 这个记录的id
	 */
	public function add($paras) {
		if (isset($paras)) {
			$this->db->insert('MOA_nschedule', $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}

	/**
	 * 获取指定wid的空余时间记录
	 * @param wid - 助理wid
	 */
	public function get($wid) {
		if (isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			return $this->db->get('MOA_nschedule')->result();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 获取所有空余时间记录
	 */
	public function get_all() {
		return $this->db->get('MOA_nschedule')->result();
	}

	/**
	 * 获得某个时间段的空余记录
	 * @param id - 空余时间段id
	 */
	public function get_by_period($period) {
		if (isset($period)) {
			$sb = 'SELECT * FROM MOA_nschedule WHERE CHARINDEX(\'' . $period . '\', period) > 0';
			$sqlquery = $this->db->query($sb);
			return $sqlquery->result();
		}
		else {
			return false;
		}
	}
    
	/**
	 * 删除空余时间表记录
	 * @param id - 空余时间段id
	 */
	public function delete($nsid) {
		if (isset($nsid)) {
			$sb = 'DELETE FROM MOA_nschedule WHERE nsid = ' . $nsid;
			$sqlquery = $this->db->query($sb);
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}

	/**
	 * 清空空余时间表
	 */
	public function clean() {
		$sb = 'DELETE FROM MOA_nschedule';
		$sqlquery = $this->db->query($sb);
		return $this->db->affected_rows();
	}
}
