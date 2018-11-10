<<<<<<< HEAD
<?php
class Moa_attend_model extends CI_Model {

	/**
	 * 取出所有代班记录
	 * @return 返回所有记录
	 */
	public function get_by_isSubstitute() {
		$sql =  ''.
						'SELECT '.
						'  attend_id , wid , timestamp, type, substituteFor, applyid '.
						'FROM '.
						'  MOA_Attendence '.
						'WHERE '.
						'  isSubstitute = 1; ';
		return $this->db->query($sql)->result();
	}

	/**
	 * 根据代班人，时间段取出所有代班记录
	 * @return 返回所有记录
	 */
	public function get_by_time_and_wid($startTime, $endTime, $actual_wid) {
		if($actual_wid == NULL) {
			$sql =  ''.
							'SELECT '.
							'  attend_id , wid , timestamp, type, substituteFor, applyid '.
							'FROM '.
							'  MOA_Attendence '.
							'WHERE '.
							'  isSubstitute = 1 '.
							'AND timestamp <= \''.$endTime.'\' '.
							'AND timestamp >= \''.$startTime.'\' ;';
		}


		else {
			$sql =  ''.
							'SELECT '.
							'  attend_id , wid , timestamp, type, substituteFor, applyid '.
							'FROM '.
							'  MOA_Attendence '.
							'WHERE '.
							'  isSubstitute = 1 '.
							'AND wid = '.$actual_wid.' '.
							// 'AND (wid = '.$actual_wid.' OR substituteFor = '.$actual_wid.' )'.
							'AND timestamp <= \''.$endTime.'\' '.
							'AND timestamp >= \''.$startTime.'\' ;';
		}

		return $this->db->query($sql)->result();
	}

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
=======
<?php
class Moa_attend_model extends CI_Model {

	/**
	 * 取出所有代班记录
	 * @return 返回所有记录
	 */
	public function get_by_isSubstitute() {
		$sql =  ''.
						'SELECT '.
						'  attend_id , wid , timestamp, type, substituteFor, applyid '.
						'FROM '.
						'  MOA_Attendence '.
						'WHERE '.
						'  isSubstitute = 1; ';
		return $this->db->query($sql)->result();
	}

	/**
	 * 根据代班人，时间段取出所有代班记录
	 * @return 返回所有记录
	 */
	public function get_by_time_and_wid($startTime, $endTime, $actual_wid) {
		if($actual_wid == NULL) {
			$sql =  ''.
							'SELECT '.
							'  attend_id , wid , timestamp, type, substituteFor, applyid '.
							'FROM '.
							'  MOA_Attendence '.
							'WHERE '.
							'  isSubstitute = 1 '.
							'AND timestamp <= \''.$endTime.'\' '.
							'AND timestamp >= \''.$startTime.'\' ;';
		}


		else {
			$sql =  ''.
							'SELECT '.
							'  attend_id , wid , timestamp, type, substituteFor, applyid '.
							'FROM '.
							'  MOA_Attendence '.
							'WHERE '.
							'  isSubstitute = 1 '.
							'AND wid = '.$actual_wid.' '.
							// 'AND (wid = '.$actual_wid.' OR substituteFor = '.$actual_wid.' )'.
							'AND timestamp <= \''.$endTime.'\' '.
							'AND timestamp >= \''.$startTime.'\' ;';
		}

		return $this->db->query($sql)->result();
	}

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
>>>>>>> abnormal
