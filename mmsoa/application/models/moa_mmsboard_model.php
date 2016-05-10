<?php
/**
 * 站内论坛模型类
 * @author Rinka
 */
class moa_mmsboard_model extends CI_Model {
    /**
     * 增加一个帖子
     * @param paras - 参数列表
     * @return 帖子bpid
     */
    public function add($paras) {
        if (isset($paras)) {
            $this->db->insert('MOA_MMSBoard', $paras);
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    /**
     * 用bpid取帖子信息
     * @param bpid - 助理bpid
     */
    public function get($bpid) {
        if (isset($bpid)) {
            $this->db->where(array('bpid'=>$bpid, 'state'=>0));
            $res = $this->db->get('MOA_MMSBoard')->result();
            return $res[0];
        }
        else {
            $this->db->where(array('state'=>0));
            $res = $this->db->get('MOA_MMSBoard')->result();
            return $res;
        }
        return false;   
    }
    
    /**
     * 取指定状态、数目、时间段的帖子
     * @param unknown $time 该时间之前
     * @param unknown $state 帖子状态
     * @param string $nums 最大数目
     * @param number $offset 偏移量
     */
    public function get_by_date($date, $state, $nums = NULL, $offset = 0) {
    	if (isset($date) && isset($state)) {
    		$this->db->where(array('state' => $state, 'bptimestamp <' => $date));
    		$this->db->order_by('bptimestamp', 'DESC');
    		if (!is_null($nums)) {
    			$this->db->limit($nums, $offset);
    		}
    		return $this->db->get('MOA_MMSBoard')->result();
    	}
    	else {
    		return false;
    	}
    }

    /**
     * 删除/恢复一个帖子
     * @param bpid - 帖子bpid
     */
    public function delete($bpid, $isrecovere = false) {
        if(isset($bpid)) {
            $this->db->where(array('bpid'=>$bpid));
            if (!$isrecovere) {
                $this->db->update('MOA_MMSBoard', array('state'=>1));
            }
            else {
                $this->db->update('MOA_MMSBoard', array('state'=>0));
            }
            return $this->db->affected_rows();
        }
        else {
            return false;
        }
    }

    /**
     * 取某uid所有文章
     * @param uid - 用户id
     */
    public function get_by_uid($uid, $getall = false) {
        if (isset($mylevel)) {
            if ($getall == false) {
                $this->db->where(array('uid'=>$uid, 'state'=>0));
            }
            else {
                $this->db->where(array('uid'=>$uid));
            }
            return $this->db->get('MOA_MMSBoard')->result();
        }
        else {
            return false;
        }
    }

    /**
     * 删除某uid所有文章
     * @param uid - 用户id
     */
    public function delete_all_by_uid($uid) {
        if (isset($uid)) {
            $sb = 'UPDATE MOA_MMSBoard SET state = 1 WHERE uid = ' . $uid;
            $sqlquery = $this->db->query($sb);
            return $this->db->affected_rows();
        }
        else {
            return false;
        }
    }
}