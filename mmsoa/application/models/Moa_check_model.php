<<<<<<< HEAD
<?php
class Moa_check_model extends CI_Model {
	/**
	 * 添加课室检查记录（常检 周检）
	 * @param paras - 参数列表
	 * @return 这条检查记录的checkid
	 */
	public function add_check($paras) {
		if (isset($paras)) {
			$this->db->insert("MOA_Check", $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 添加课室问题（故障）记录
	 * @param paras - 参数列表
	 * @return 这条问题记录的pid
	 */
	public function add_problem($paras) {
		if (isset($paras)) {
			$this->db->insert('MOA_Problem', $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定wid对应的roomid
	 * @param wid - 工号id
	 * @return 对应的常检课室roomid
	 */
	public function get_roomid_by_wid($wid) {
		if (isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			$dataarr = $this->db->get('MOA_CheckRoom')->result();
			if (is_null($dataarr[0])) {
				return false;
			}
			return $dataarr[0]->roomid;
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定课室对应的roomid
	 * @param room - 课室位置
	 * @return 对应课室的roomid
	 */
	public function get_roomid_by_room($room, $nums = NULL, $offset = 0) {
		if (isset($room)) {
			$this->db->where(array('room'=>$room));
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			$dataarr = $this->db->get('MOA_CheckRoom')->result();
			if (is_null($dataarr[0])) {
				return false;
			}
			return $dataarr[0]->roomid;
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定周次、星期、类型的检查记录
	 * @param weekcount - 周次
	 * @param weekday - 星期
	 * @param type - 检查类型
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_week_type($weekcount, $weekday, $type, $nums = NULL, $offset = 0) {
		if (isset($weekcount) && isset($weekday) && isset($type)) {
			$this->db->where(array('weekcount'=>$weekcount, 'weekday'=>$weekday, 'type'=>$type));
			$this->db->order_by('timestamp', 'ASC');
			$this->db->order_by('actual_wid', 'ASC');
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Check')->result();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定周次、类型的检查记录
	 * @param weekcount - 周次
	 * @param type - 检查类型
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_weekcount_type($weekcount, $type, $nums = NULL, $offset = 0) {
		if (isset($weekcount) && isset($type)) {
			$this->db->where(array('weekcount'=>$weekcount, 'type'=>$type));
			$this->db->order_by('timestamp', 'ASC');
			$this->db->order_by('actual_wid', 'ASC');
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Check')->result();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定时间段、助理、课室、类型的检查记录
	 * @param start_time - 开始时间
	 * @param end_time - 结束时间
	 * @param actual_wid - 检查的实际助理id
	 * @param roomid - 课室id
	 * @param type - 检查类型
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_customer($type, $start_time, $end_time, $actual_wid, $roomid, $nums = NULL, $offset = 0) {
		if (isset($type) && isset($start_time) && isset($end_time)) {
			$this->db->where('type', $type);
			$this->db->where('timestamp >=', $start_time);
			$this->db->where('timestamp <=', $end_time);
			if (!is_null($actual_wid)) {
				$this->db->where('actual_wid', $actual_wid);
			}
			if (!is_null($roomid)) {
				$this->db->where('roomid', $roomid);
			}
			$this->db->order_by('timestamp', 'ASC');
			$this->db->order_by('actual_wid', 'ASC');
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Check')->result();
		}
		else {
			return false;
		}
	}
	
}
=======
<?php
class Moa_check_model extends CI_Model {
	/**
	 * 添加课室检查记录（常检 周检）
	 * @param paras - 参数列表
	 * @return 这条检查记录的checkid
	 */
	public function add_check($paras) {
		if (isset($paras)) {
			$this->db->insert("MOA_Check", $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 添加课室问题（故障）记录
	 * @param paras - 参数列表
	 * @return 这条问题记录的pid
	 */
	public function add_problem($paras) {
		if (isset($paras)) {
			$this->db->insert('MOA_Problem', $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定wid对应的roomid
	 * @param wid - 工号id
	 * @return 对应的常检课室roomid
	 */
	public function get_roomid_by_wid($wid) {
		if (isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			$dataarr = $this->db->get('MOA_CheckRoom')->result();
			if (is_null($dataarr[0])) {
				return false;
			}
			return $dataarr[0]->roomid;
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定课室对应的roomid
	 * @param room - 课室位置
	 * @return 对应课室的roomid
	 */
	public function get_roomid_by_room($room, $nums = NULL, $offset = 0) {
		if (isset($room)) {
			$this->db->where(array('room'=>$room));
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			$dataarr = $this->db->get('MOA_CheckRoom')->result();
			if (is_null($dataarr[0])) {
				return false;
			}
			return $dataarr[0]->roomid;
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定周次、星期、类型的检查记录
	 * @param weekcount - 周次
	 * @param weekday - 星期
	 * @param type - 检查类型
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_week_type($weekcount, $weekday, $type, $nums = NULL, $offset = 0) {
		if (isset($weekcount) && isset($weekday) && isset($type)) {
			$this->db->where(array('weekcount'=>$weekcount, 'weekday'=>$weekday, 'type'=>$type));
			$this->db->order_by('timestamp', 'ASC');
			$this->db->order_by('actual_wid', 'ASC');
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Check')->result();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定周次、类型的检查记录
	 * @param weekcount - 周次
	 * @param type - 检查类型
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_weekcount_type($weekcount, $type, $nums = NULL, $offset = 0) {
		if (isset($weekcount) && isset($type)) {
			$this->db->where(array('weekcount'=>$weekcount, 'type'=>$type));
			$this->db->order_by('timestamp', 'ASC');
			$this->db->order_by('actual_wid', 'ASC');
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Check')->result();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定时间段、助理、课室、类型的检查记录
	 * @param start_time - 开始时间
	 * @param end_time - 结束时间
	 * @param actual_wid - 检查的实际助理id
	 * @param roomid - 课室id
	 * @param type - 检查类型
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_customer($type, $start_time, $end_time, $actual_wid, $roomid, $nums = NULL, $offset = 0) {
		if (isset($type) && isset($start_time) && isset($end_time)) {
			$this->db->where('type', $type);
			$this->db->where('timestamp >=', $start_time);
			$this->db->where('timestamp <=', $end_time);
			if (!is_null($actual_wid)) {
				$this->db->where('actual_wid', $actual_wid);
			}
			if (!is_null($roomid)) {
				$this->db->where('roomid', $roomid);
			}
			$this->db->order_by('timestamp', 'ASC');
			$this->db->order_by('actual_wid', 'ASC');
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Check')->result();
		}
		else {
			return false;
		}
	}
	
}
>>>>>>> abnormal
