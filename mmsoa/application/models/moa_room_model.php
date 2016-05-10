<?php
class moa_room_model extends CI_Model {
	/**
	 * 添加课室
	 * @param paras - 参数列表
	 * @return 课室的的roomid
	 */
	public function add($paras) {
		if (isset($paras)) {
			$this->db->insert("MOA_CheckRoom", $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 获取指定roomid的课室信息
	 * @param roomid - 课室id
	 * @return roomid对应课室的所有信息
	 */
	public function get($roomid) {
		if (isset($roomid)) {
			$this->db->where(array('roomid'=>$roomid));
			$res = $this->db->get('MOA_CheckRoom')->result();
			return $res[0];
		}
		else {
			$res = $this->db->get('MOA_CheckRoom')->result();
			return $res;
		}
		return false;
	}
	
}