<?php
/**
 * 用户模型类
 * @author Rinka
 */
class Moa_user_model extends CI_Model {
 	/**
	 * 加入一个新的用户
	 * @param paras - 参数列表
	 * @return 这个用户的uid
	 */
	public function add($paras) {
		if (isset($paras)) {
			$this->db->insert('MOA_User', $paras);
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}

	/**
	 * 用id取用户信息
	 * @param id - 用户id
	 */
	public function get($id) {
	    if ($id<=0) return false;
		if (isset($id)) {
			$this->db->where(array('uid'=>$id));
			$res = $this->db->get('MOA_User')->result();
			return $res[0];
		}
		else {
			$res = $this->db->get('MOA_User')->result();
			return $res;
		}
		return false;
	}

	/**
	 * 删除/恢复一个用户
	 * @param id - 用户id
	 */
	public function delete($id, $isrecover = false) {
		if(isset($id)) {
			$this->db->where(array('uid'=>$id));
			if (!$isrecover) {
				$this->db->update('MOA_User', array('state'=>2));
			}
			else {
				$this->db->update('MOA_User', array('state'=>0));
			}
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}

	/**
	 * 更新一个用户信息
	 * @param id - 用户id
	 * @param paras - 信息
	 */
	public function update($id, $paras) {
		if(isset($id)) {
			$this->db->where(array('uid'=>$id));
			$this->db->update('MOA_User', $paras);
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}

    /**
	 * 取某级别所有用户
	 * @param mylevel - 级别
	 */
	public function get_by_level($mylevel) {
		if (isset($mylevel)) {
			$this->db->where(array('level'=>$mylevel));
			return $this->db->get('MOA_User')->result();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取某状态所有用户
	 * @param mystate - 状态
	 */
	public function get_by_state($mystate) {
		if (isset($mystate)) {
			$this->db->where(array('state'=>$mystate));
			return $this->db->get('MOA_User')->result();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取某级别某状态所有用户
	 * @param mylevel - 级别
	 * @param mystate - 状态
	 */
	public function get_by_level_state($mylevel, $mystate) {
		if (isset($mylevel) && isset($mystate)) {
			$this->db->where(array('level'=>$mylevel, 'state'=>$mystate));
			return $this->db->get('MOA_User')->result();
		}
		else {
			return false;
		}
	}
	
	/**
	 * 取多个级别某状态所有用户
	 * @param level_arr - 级别
	 * @param state - 状态
	 */
	public function get_by_multiple_level($level_arr, $state) {
		if (isset($level_arr) && isset($state)) {
			$this->db->group_start();
			for ($i = 0; $i < count($level_arr); $i++) {
				$this->db->or_where('level', $level_arr[$i]);
			}
			$this->db->group_end();
			$this->db->where('state', $state);
			$this->db->order_by('level', 'DESC');
			$this->db->order_by('indate', 'ASC');
			return $this->db->get('MOA_User')->result();
		}
		else {
			return false;
		}
	}

    /**
	 * 取指定用户名的有效记录
	 * @param username - 用户名称
	 * @param nums - 最大条目
	 * @param offset - 偏移量
	 */
	public function get_by_username($username, $nums = NULL, $offset = 0) {
		if (isset($username)) {
			$this->db->where(array('username'=>$username, 'state'=>0));
			if (!is_null($nums)) {
				$this->db->limit($nums, $offset);
			}
			return $this->db->get('MOA_User')->result();
		}
		else {
			return false;
		}
	}

	/**
	 * 返回某用户的level 
	 * @param uid - 用户id
	 * @return 用户level值
	 */
	public function get_level($uid) {
		if (isset($uid)) {
			$this->db->where(array('uid'=>$uid));
			$res = $this->db->get('MOA_User')->result();
			return $res[0]->level;
		}
		return false;
	}

	/**
	 * 给指定用户修改总工时 
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该用户最新的总工时
	 */
	public function update_contribution($uid, $contrib) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET contribution = contribution + ' . $contrib . ' WHERE uid = ' . $uid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定用户修改总优异助理次数 
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该用户最新的总优异次数
	 */
	public function update_best($uid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET totalBest = totalBest + ' . $contrib . ' WHERE uid = ' . $uid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定用户修改异常助理次数 
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该用户最新的总异常次数
	 */
	public function update_bad($uid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET totalBad = totalBad + ' . $contrib . ' WHERE uid = ' . $uid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

    /**
     * 给指定用户修改罚时
     * @param $uid - 用户id
     * @param int $contrib - 修改量
     */
	public function update_penalty($uid, $contrib = 1) {
        if (isset($uid) and isset($contrib)) {
            $sb = 'UPDATE MOA_User SET totalPenalty = totalPenalty + ' . $contrib . ' WHERE uid = ' . $uid;
            $affected_lines = $this->db->query($sb);
            return $affected_lines;
        }
        else {
            return false;
        }
    }

	/**
	 * 给指定用户修改抽查优秀次数 
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该用户最新的总抽查优秀次数
	 */
	public function update_perfect($uid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET totalPerfect = totalPerfect + ' . $contrib . ' WHERE uid = ' . $uid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定用户修改总旷工次数 
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该用户最新的总旷工次数
	 */
	public function update_absence($uid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET totalAbsence = totalAbsence + ' . $contrib . ' WHERE uid = ' . $uid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

	/**
	 * 给指定用户修改总请假次数 
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该用户最新的总请假次数
	 */
	public function update_leave($uid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET totalLeave = totalLeave + ' . $contrib . ' WHERE uid = ' . $uid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}

    /**
	 * 给指定用户修改总被抽查次数 
	 * @param uid - 用户id
	 * @param contrib - 修改量
	 * @return 该用户最新的总被抽查次数
	 */
	public function update_check($uid, $contrib = 1) {
		if (isset($uid) and isset($contrib)) {
			$sb = 'UPDATE MOA_User SET totalCheck = totalCheck + ' . $contrib . ' WHERE uid = ' . $uid;
			$affected_lines = $this->db->query($sb);
			return $affected_lines;
		}
		else {
			return false;
		}
	}
	
	
	/**
	 * 登录验证
	 * @param username - 用户名
	 * @param password - 哈希后的密码
	 * @return 登录成功与否
	 */
	public function login_check($username, $password) {
		if (isset($username) and isset($password)) {
			$sb = 'SELECT username, password FROM MOA_User WHERE (state = 0 OR state = 3) AND username = "' . $username . '" AND password = "' . $password . '"';
			$sqlquery = $this->db->query($sb);
			$dataarr = $sqlquery->result();
			if (count($dataarr) == 0) {
				return false;
			}
			else {
				return true;
			}
		}
	}
	
	/**
	 * 获取用户id
	 * @param username - 用户名
	 * @param password - 哈希后的密码
	 * @return 用户id
	 */
	public function get_uid($username, $password) {
		if (isset($username) and isset($password)) {
			$sb = 'SELECT uid FROM MOA_User WHERE username = "' . $username . '" AND password = "' . $password . '"';
			$sqlquery = $this->db->query($sb);
			$dataarr = $sqlquery->result();
			return $dataarr[0]->uid;
		}
		else {
			return false;
		}
	}

	/**
	 * 获取名人堂中所有记录
	 * @return 记录数组
	 */
	public function get_stars() {
		$sb = 'SELECT * FROM MOA_Star';
		$sqlquery = $this->db->query($sb);
		return $sqlquery->result();
	}
    
    /**
	 * 获取名人堂中指定wid的记录
     * @param wid - 工号id
	 * @return 记录数组
	 */
	public function get_star_by_wid($wid) {
		if (isset($wid)) {
			$this->db->where(array('wid'=>$wid));
			$res = $this->db->get('MOA_Star')->result();
            if (is_null($res) == TRUE || count($res) == 0) {
                return FALSE;
            }
			return $res[0];
		}
		return FALSE;
	}
    
    /**
	 * 获取名人堂中一条记录
	 * @param id - 名人id
	 */
	public function get_star($starid) {
		if (isset($id)) {
			$this->db->where(array('starid'=>$starid));
			$res = $this->db->get('MOA_Star')->result();
			return $res[0];
		}
		return FALSE;
	}
    
 	/**
	 * 加入一个名人
	 * @param paras - 参数列表
	 * @return 这个名人的starid
	 */
	public function add_star($paras) {
		if (isset($paras)) {
			$this->db->insert('MOA_Star', $paras);
			return $this->db->insert_id();
		}
		else {
			return FALSE;
		}
	}
    
    /**
	 * 删除一个名人
	 * @param id - 名人starid
	 */
	public function delete_star($id) {
		if(isset($id)) {
			$this->db->where(array('starid'=>$id));
            $this->db->delete('MOA_Star');
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}

	/**
	 * 更新一个用户信息
	 * @param id - 名人starid
	 * @param paras - 信息
	 */
	public function update_star($id, $paras) {
		if(isset($id)) {
			$this->db->where(array('starid'=>$id));
			$this->db->update('MOA_Star', $paras);
			return $this->db->affected_rows();
		}
		else {
			return false;
		}
	}
    
}