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