<?php
/**
 * 站内论坛评论模型类
 * @author Rinka
 */
class Moa_mbcomment_model extends CI_Model {
    /**
     * 增加一个评论
     * @param paras - 参数列表
     * @return 帖子评论mbcid
     */
    public function add($paras) {
        if (isset($paras)) {
            $this->db->insert('MOA_MBComment', $paras);
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }

    /**
     * 用bmcid取帖子评论信息
     * @param id - 帖子评论mbcid
     */
    public function get($id) {
        if (isset($id)) {
            $this->db->where(array('mbcid'=>$id, 'state'=>0));
            $res = $this->db->get('MOA_MBComment')->result();
            return $res[0];
        }
        else {
            $this->db->where(array('state'=>0));
            $res = $this->db->get('MOA_MBComment')->result();
            return $res;
        }
        return false;   
    }
    
    /**
     * 取指定状态、bpid的所有评论
     * @param unknown $bpid 帖子id
     * @param unknown $state 评论状态
     * @param string $nums 最大数目,默认为10条
     * @param number $offset 偏移量
     * @param string $order 顺序或倒序,'ASC','DESC',默认倒序
     */
    public function get_by_bpid($bpid, $state, $nums = 10, $offset = 0, $order='DESC') {
    	if (isset($bpid) && isset($state)) {
    		$this->db->where(array('bpid' => $bpid, 'state' => $state));
    		$this->db->order_by('mbctimestamp', $order);
    		if (!is_null($nums)) {
    			$this->db->limit($nums, $offset);
    		}
    		return $this->db->get('MOA_MBComment')->result();
    	}
    	else {
    		return false;
    	}
    }

    /**
     * 删除/恢复一个帖子评论
     * @param id - 帖子评论mbcid
     */
    public function delete($id, $isrecovere = false) {
        if(isset($id)) {
            $this->db->where(array('mbcid'=>$id));
            if (!$isrecovere) {
                $this->db->update('MOA_MBComment', array('state'=>1));
            }
            else {
                $this->db->update('MOA_MBComment', array('state'=>0));
            }
            return $this->db->affected_rows();
        }
        else {
            return false;
        }
    }

    /**
     * 取某帖子下所有评论
     * @param bpid - 帖子的bpid
     */
    public function get_by_bpid_all($bpid, $getall = false) {
        if (isset($bpid)) {
            if ($getall == false) {
                $this->db->where(array('bpid'=>$bpid, 'state'=>0));
            }
            else {
                $this->db->where(array('bpid'=>$bpid));
            }
            return $this->db->get('MOA_MBComment')->result();
        }
        else {
            return false;
        }
    }

    /**
     * 删除某帖子的所有评论
     * @param bpid - 帖子的bpid
     */
    public function delete_all_by_bpid($bpid) {
        if (isset($bpid)) {
            $sb = 'UPDATE MOA_MMSBoard SET state = 1 WHERE bpid = ' . $bpid;
            $sqlquery = $this->db->query($sb);
            return $this->db->affected_rows();
        }
        else {
            return false;
        }
    }

    /**
     * 删除某用户的所有评论
     * @param uid - 用户uid
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