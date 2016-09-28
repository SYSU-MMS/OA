<?php
/**
 * 助理模型类
 * @author Rinka
 */
class Moa_worker_model extends CI_Model {
 	/**
	 * 加入一个新的助理
	 * @param paras - 参数列表
	 * @return 这个助理的wid
	 */
	public function add($paras) {
		if (isset($paras)) {
			$this->db->insert('MOA_Worker', $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}

	/**
	 * 用wid取助理信息
	 * @param wid - 助理wid
	 * @return wid对应worker的所有信息
	 */
	public function get($wid) {
		if (isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			$res = $this->db->get('MOA_Worker')->result();
			return $res[0];
		}
		else {
			$res = $this->db->get('MOA_Worker')->result();
			return $res;
		}
		return false;
	}

	/**
	 * 删除一个助理
	 * @param wid - 助理wid
	 * @return 受影响的行数
	 */
	public function delete($wid) {
		if (isset($wid)) {
			$sb = 'DELETE FROM MOA_Worker WHERE wid = ' . $wid;
			$sqlquery = $this->db->query($sb);
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}

	/**
	 * 更新一个助理信息
	 * @param wid - 助理id
	 * @param paras - 信息
	 */
	public function update($wid, $paras) {
		if(isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			$this->db->update('MOA_Worker', $paras);
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}

    /**
	 * 取某级别所有助理
	 * @param mylevel - 级别
	 */
	public function get_by_level($mylevel) {
		if (isset($mylevel)) {
			$this->db->where(array('level'=>$mylevel));
			return $this->db->get('MOA_Worker')->result();
		}
		else {
			return false;
		}
	}
    
    /**
	 * 取指定wid的用户组别
	 * @param wid - 助理wid
	 * @return 组别编号
	 */
	public function get_groupid($wid) {
		if (isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			$dataarr = $this->db->get('MOA_Worker')->result();
			if (is_null($dataarr[0])) {
				return false;
			}
			return $dataarr[0]->group;
		}
		else {
			return false;
		}
	}
    
    /**
	 * 取指定uid对应的wid
	 * @param uid - 用户id
	 * @return 对应的工号wid
	 */
	public function get_wid_by_uid($uid) {
		if (isset($uid)) {
			$this->db->where(array('uid'=>$uid));
			$dataarr = $this->db->get('MOA_Worker')->result();
			if (is_null($dataarr[0])) {
				return false;
			}
			return $dataarr[0]->wid;
		}
		else {
			return false;
		}
	}
    
    /**
	 * 取指定wid对应的uid
	 * @param wid - 工号wid
	 * @return 用户号uid
	 */
	public function get_uid_by_wid($wid) {
		if (isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			$dataarr = $this->db->get('MOA_Worker')->result();
			if (is_null($dataarr[0])) {
				return false;
			}
			return $dataarr[0]->uid;
		}
		else {
			return false;
		}
	}

	/**
	 * 返回某用户的level
	 * @param wid - 助理wid
	 * @return 助理level值
	 */
	public function get_level($wid) {
		if (isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			$res = $this->db->get('MOA_Worker')->result();
			return $res[0]->level;
		}
		return false;
	}

	/**
	 * 给指定助理修改本月工时
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月工时
	 */
	public function update_worktime($wid, $contrib) {
		if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET worktime = worktime + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定助理修改最后结算工资时间戳
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的最后结算工资时间戳
	 */
	public function update_lastmonth($wid, $contrib) {
		if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET lastmonth = ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定助理修改本月优异助理次数
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月优异次数
	 */
	public function update_best($wid, $contrib = 1) {
		if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET best = best + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定助理修改本月异常助理次数
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月异常次数
	 */
	public function update_bad($wid, $contrib = 1) {
		if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET bad = bad + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定助理修改抽查优秀次数
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月抽查优秀次数
	 */
	public function update_perfect($wid, $contrib = 1) {
		if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET perfect = perfect + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定助理修改本月旷工次数
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月旷工次数
	 */
	public function update_absence($wid, $contrib = 1) {
		if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET absence = absence + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定助理修改本月请假次数 
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月请假次数
	 */
	public function update_leave($uid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET leave = leave + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定助理修改本月被抽查次数 
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月被抽查次数
	 */
	public function update_check($uid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET checks = checks + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定助理修改本月被扣除工时
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月被扣除工时
	 */
	public function update_penalty($wid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET penalty = penalty + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}
}