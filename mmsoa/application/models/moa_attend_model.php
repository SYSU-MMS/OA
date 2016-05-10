<?php
class moa_attend_model extends CI_Model {
	/**
	 * 添加值班考勤记录
	 * @param paras - 参数列表
	 * @return 这条考勤记录的attend_id
	 */
	public function add($paras) {
		if (isset($paras)) {
			$this->db->insert("MOA_Attendence", $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取指定周次、星期、类型的考勤记录
	 * @param weekcount - 周次
	 * @param weekday - 星期
	 * @param type - 考勤类型
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_week_type($weekcount, $weekday, $type, $nums = NULL, $offset = 0) {
		if (isset($weekcount) && isset($weekday) && isset($type)) {
			$this->db->where(array('weekcount'=>$weekcount, 'weekday'=>$weekday, 'type'=>$type));
			$this->db->order_by('timestamp', 'ASC');
			$this->db->order_by('wid', 'ASC');
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_attendence')->result();
		}
		else {
			return false;
		}
	}
	
}