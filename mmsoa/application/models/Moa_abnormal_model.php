<?php
class Moa_abnormal_model extends CI_Model {
	/**
	 * 取指定时间段、助理的异常记录
	 * @param start_time - 开始时间
	 * @param end_time - 结束时间
	 * @param actual_wid - 异常助理id
	 * @param dealing - 处理方式
	 * @param dealer - 处理人
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_records($start_time = NULL, $end_time = NULL, $actual_wid = NULL, $dealing = NULL, $dealer = NULL, $nums = NULL, $offset = 0) 
	{
		if (isset($start_time) && isset($end_time)) {
			$this->db->where('timestamp >=', $start_time);
			$this->db->where('timestamp <=', $end_time);
			if (!is_null($actual_wid)) {
				$this->db->where('actual_wid', $actual_wid);
			}
			if (!is_null($dealing)) {
				$this->db->where('dealing', $dealing);
			}
			if (!is_null($dealer)) {
				$this->db->where('dealer', $dealer);
			}
			$this->db->order_by('timestamp', 'ASC');
			$this->db->order_by('actual_wid', 'ASC');
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_Abnormal')->result();
		}
		else {
			return false;
		}
	}

    /**
     * 获取异常助理信息
     * @param id 对应的记录的id
     * @return bool 如失败则false
     */
    public function get_record_by_id($id)
    {
        if (isset($id)) {
            $this->db->where('abnormal_id', $id);
            return $this->db->get('MOA_Abnormal')->result();
        } else {
            return false;
        }
    }
    
	/**
	 * 更新一个异常助理信息
	 * @param id - 记录的id
	 * @param paras - 信息
	 */
	public function update_record_by_id($id, $paras) {
		if(isset($id)) {
			$this->db->where(array('abnormal_id' => $id));
			$this->db->update('MOA_Abnormal', $paras);
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}

    /**
     * 新增异常助理
     * @param $paras array  时间，wid，行为，处理方法，处理人，备注
     * @return bool 记录的id， 如失败则false
     */
    public function add_record($paras)
    {
        if (isset($paras)) {
            $this->db->insert('MOA_Abnormal', $paras);
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    /**
     * 删除异常助理
     * @param id 对应的记录的id
     * @return bool 如失败则false
     */
	public function delete_record_by_id($id) {
		if (isset($id)) {
			$this->db->delete('MOA_Abnormal', array('abnormal_id' => $id));
			return $this->db->affected_rows();
		} else {
			return false;
		}
	}
}
