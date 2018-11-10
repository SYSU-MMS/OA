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
	public function get($wid = 0) {
		if (isset($wid) && $wid > 0) {
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
     * 取得所有助理信息
     * @return mixed
     */
	public function get_all(){
	    $res=$this->db->get('MOA_Worker')->result();
        return $res;
    }

    /**
     * 获取处于某种状态的助理(包含用户信息)
     * @param state(0正常，1锁定，2删除，3离职？)
     * @author 高少彬
     * @return 某个状态的所有用户
     */
    public function get_by_state($state) {
        $sql = 'SELECT * '.
        'FROM '.
        '    MOA_User natural join MOA_Worker '.
        'WHERE '.
        '    state = '.$state.'; ';
    	$res = $this->db->query($sql);
    	return $res;
    }

    /**
     * 批量清算工时写回数据库（事务）
     * @param $userlist
     * @author 高少彬
     * @return 受影响行数
     */
    public function update_all_worktime($userlist) {
		//设置时区为东八区
        date_default_timezone_set('PRC');
        $now_time = date('Y-m-d H:i:s');

		$this->db->trans_start();
		foreach ($userlist as $one_user) {

			$sql =	'UPDATE '.
				    '    MOA_User '.
				    'SET '.
				    '    contribution = '.$one_user['update_contribution'].', '.
				    '    totalPenalty = '.$one_user['update_totalPenalty'].' '.
				    'WHERE'.
				    '    uid = '.$one_user['uid'].';';
		    $this->db->query($sql);

		    $sql1 =	'UPDATE '.
	    			'    MOA_Worker '.
	    			'SET '.
	    			'    worktime  = '.$one_user['update_worktime'].', '.
	    			'    penalty   = '.$one_user['update_penalty'].','.
            		'    lastmonth = \''.$now_time.'\' '.
	    			'WHERE'.
	    			'    uid = '.$one_user['uid'].';';
    		$this->db->query($sql1);
    	}
		$this->db->trans_complete();
		return $this->db->trans_status();
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
     * 取某組别所有助理
     * @param group - 組别
     */
    public function get_by_group($group) {
        if (isset($group)) {
            $this->db->where(array('group'=>$group));
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
     * 取指定uid对应的worker
     * @param uid - 用户id
     * @return obj|bool
     */
    public function get_by_uid($uid) {
        if (isset($uid)) {
            $this->db->where(array('uid'=>$uid));
            $dataarr = $this->db->get('MOA_Worker')->result();
            if (is_null($dataarr[0])) {
                return false;
            }
            return $dataarr[0];
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
     *  给指定助理修改周检抽查优秀次数
     *  @param wid - 助理id
     *  @param contrib - 修改量
     *  @return 该助理最新的本月周检抽查优秀次数
     */
    public function update_weekly_perfect($wid, $contrib) {
        if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET wperfect = wperfect + ' . $contrib . ' WHERE wid = ' . $wid;
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
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月被抽查次数
	 */
	public function update_check($wid, $contrib = 1) {
		if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET checks = checks + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}
    /**
     * 给指定助理修改本月周检被抽查次数
     * @param wid - 助理id
     * @param contrib - 修改量
     * @return 该助理最新的本月周检被抽查次数
     */
    public function update_weekly_check($wid, $contrib = 1) {
        if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET wchecks = wchecks + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
    }
	/**
	 * 给指定助理修改本月被扣除工时
	 * @param wid - 助理id
	 * @param contrib - 修改量
	 * @return 该助理最新的本月被扣除工时
	 */
	public function update_penalty($wid, $contrib = 1) {
		if (isset($wid) and isset($contrib)) {
			$sb = 'UPDATE MOA_Worker SET penalty = penalty + ' . $contrib . ' WHERE wid = ' . $wid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

    public function get_name_by_wid($wid) {
        $sql =  ''.
                'SELECT name '.
                'FROM moa_user '.
                'WHERE uid = ('.
                '    SELECT uid '.
                '    FROM moa_worker '.
                '    WHERE wid = '.$wid.
                ');';
        $query = $this->db->query($sql);
        return $query->result();
    }

    /**
	 * 获取所有助理某个被处理类型的次数
	 * @return bool 如果失败返回false
	 */
	public function get_abnormal_counts_by_type($type) {
		if (isset($type)) {
			if ($type == 0)
				$this->db->order_by('abnormal_count_0', 'DESC');
			else
				$this->db->order_by('abnormal_count_1', 'DESC');
			return $this->db->get('MOA_Worker')->result();
		}
		else {
			return false;
		}
	}

     /**
	 * 获取该助理的异常次数
	 * @param wid - 助理id
	 * @return bool 如果失败返回false
	 */
	public function get_abnormal_count_by_id($wid) {
		if (isset($wid) && isset($type)) {
			$this->db->where("wid", $wid);
			$result = $this->db->update('MOA_Worker')->result();
			if ($type == 0) {
				return $result;
			}
			else {
				return $result;
			}
		}
		else {
			return false;
		}
	}  
}
