<?php
class Moa_room_model extends CI_Model {
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

	/**
	 * 获取指定状态的课室信息
	 * @param state - 课室state
	 * @return roomid对应课室的所有信息
	 */
	public function get_by_state($state) {
		if (isset($state)) {
			$this->db->where(array('state'=>$state));
			$this->db->order_by('room', 'ASC');
			return $this->db->get('MOA_CheckRoom')->result();
		}
		else {
			return false;
		}
	}

	/**
	 * 获取所有可选的课室信息
	 * @return 包含roomid,room, state的课室信息
	 */
	public function get_all() {
		$sql = 'select roomid, room, state from MOA_CheckRoom;';
		return $this->db->query($sql)->result();
	}
}
