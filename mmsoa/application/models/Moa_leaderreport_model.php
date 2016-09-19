<?php
class Moa_leaderreport_model extends CI_Model {
	/**
	 * 添加坐班日志
	 * @param paras - 参数列表
	 * @return 这篇坐班日志的lrid
	 */
	public function add($paras) {
		if (isset($paras)) {
			$this->db->insert("MOA_LeaderReport", $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
	
    /**
     * 获取指定的坐班日志
     * @id - 坐班日志id
     * @return 坐班日志基本信息向量
     */
	public function get($id) {
        if (isset($id)) {            
            $this->db->where(array('lrid'=>$id, 'state'=>0));
			$res = $this->db->get('MOA_LeaderReport')->result();
            if (count($res) != 0) {
                return $res[0];
            }
        }
        return FALSE;
	}
    
	/**
	 * 删除一个坐班日志
	 * @param id - 用户id
	 */
	public function delete($id) {
		if(isset($id)) {
			$this->db->where(array('lrid'=>$id));
			$this->db->update('MOA_LeaderReport', array('state'=>1));
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}
    
    /**
     * 获取所有坐班日志基本信息
     * @return 坐班日志基本信息向量
     */
	public function get_baselist() {
		$sb = 'SELECT lrid, wid, weekcount, weekday, timestamp FROM MOA_LeaderReport WHERE state = 0';
		$sqlquery = $this->db->query($sb);
		return $sqlquery->result();
	}
    
	/**
	 * 获取最近的一篇指定状态的坐班日志
	 * @param mystate 日志状态
	 * @param type - 检查类型
	 * @param nums - 最大条目
	 * @return 最近的一篇指定状态的坐班日志记录
	 */
	public function get_lasted($mystate) {
		if (isset($mystate)) {
			$sb = 'SELECT * FROM MOA_LeaderReport WHERE state = "' . $mystate . '" AND timestamp IN (SELECT MAX(timestamp) FROM MOA_LeaderReport)';
			$sqlquery = $this->db->query($sb);
			$dataarr = $sqlquery->result();
			if (count($dataarr) == 0) {
				return false;
			}
			else {
				return $dataarr[0];
			}
		}
		else {
			return false;
		}
	}
	
	
	
}