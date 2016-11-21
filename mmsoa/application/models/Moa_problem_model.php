<?php
class Moa_problem_model extends CI_Model {
	/**
	 * 获取指定pid的problem信息
	 * @param pid - 故障pid
	 * @return pid对应problem的所有信息
	 */
	public function get($pid) {
		if (isset($pid)) {
			$this->db->where(array('pid'=>$pid));
			$res = $this->db->get('MOA_Problem')->result();
			return $res[0];
		}
		else {
			$res = $this->db->get('MOA_Problem')->result();
			return $res;
		}
		return false;
	}

	public function add($paras){
        if (isset($paras)){
            $this->db->insert('moa_problem',$paras);
            return $this->db->insert_id();
        }
    }
	
}