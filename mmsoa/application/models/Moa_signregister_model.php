<?php


class Moa_signregister_model extends CI_Model
{

    public function add_table($paras)
    {
        if (isset($paras)) {
            $this->db->insert('moa_signBrief', $paras);
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function get_tables()
    {
        $this->db->order_by('signid', 'DESC');
        return $this->db->get('moa_signBrief')->result();
    }


    public function get_table($drid)
    {
        if (isset($drid)) {
            $this->db->where(array('signid' => $drid));
            $ret = $this->db->get('moa_signBrief')->result();
            if($ret[0] != null)
                return $ret[0];
            return false;
        } else {
            return false;
        }
    }


    public function get_table_and_detail($signid)
    {
        $ret = false;
        if (isset($signid)) {
            $this->db->where(array('signid' => $signid));
            $tmp = $this->db->get('moa_signBrief')->result();
            $ret = array();
            $ret[0] = $tmp[0];
            $this->db->where(array('signid' => $signid));
            $this->db->order_by('uid', 'ASC');
            $ret[1] = $this->db->get('moa_signDetail')->result();
        }
        return $ret;
    }

    /**
     * 某张报名表的信息以及某个用户的报名情况
     * @param $drid
     * @param $uid
     * @return array|null
     */
    public function get_table_and_detail_with_uid($signid, $uid)
    {
        $ret = false;
        if (isset($signid) && isset($uid) ) {
            $this->db->where(array('signid' => $signid));
            $tmp = $this->db->get('moa_signBrief')->result();
            $ret = array();
            $ret[0] = $tmp[0];
            $this->db->where(array('signid' => $signid, 'uid' => $uid));
            $this->db->order_by('uid', 'ASC');
            $ret[1] = $this->db->get('moa_signDetail')->result();
        }
        return $ret;
    }

    public function get_user_state($signid, $uid) {
        $ret = false;
        if (isset($signid) && isset($uid) ) {
            $this->db->where(array('signid' => $signid, 'uid' => $uid));
            $ret = $this->db->get('moa_signDetail')->result();
            if (!$ret) {
                return $ret;
            }
            return $ret[0];
        }
    }

    public function delete_sign($signid) {
        $res = false;
        $this->db->where('signid', $signid);
        $res = $this->db->delete('moa_signDetail');
        $this->db->where('signid', $signid);
        $res = $this->db->delete('moa_signBrief');   
        return $res;   
    }

    public function update_sign($signid, $uid, $flag, $date = NULL) {
        $uflag;
        if ($flag == 1) $uflag = 0;
        else $uflag = 1;
        $this->db->set('state', $flag);
        $this->db->set('signTime', $date);
        $this->db->where(array('signid' => $signid, 'uid' => $uid, 'state' => $uflag));
        $this->db->update('moa_signDetail');
        $ret = ($this->db->affected_rows() == 1);
        if ($ret) {
            $this->db->where('signid', $signid);
            $tem = $this->db->get('moa_signBrief')->result();
            $num = $tem[0]->isSigned;
            if ($flag == 1)    
                $num += 1;
            else $num -= 1;
            $this->db->set('isSigned', $num);
            $this->db->where('signid', $signid);
            $this->db->update('moa_signBrief');
        }

        return $ret;
    }

    public function add_signer($signid, $uid) {
        $ret = false;
        $this->db->where(array('signid' => $signid, 'uid' => $uid));
        $ret = $this->db->get('moa_signDetail')->result();
        if ($ret != false) {
            return false;
        }
        $data = array(
            'signid' => $signid,
            'uid' => $uid,
            'state' => 0
        );
        $ret = $this->db->insert('moa_signDetail', $data);
        if ($ret) {
            $this->db->where('signid', $signid);
            $tem = $this->db->get('moa_signBrief')->result();
            $num = $tem[0]->signNum;
            $num += 1;
            $this->db->set('signNum', $num);
            $this->db->where('signid', $signid);
            $this->db->update('moa_signBrief');
        }
        return $ret;
    }

    public function del_signer($signid, $uid) {
        $ret = false;
        $this->update_sign($signid, $uid, 0, NULL);
        $this->db->where(array('signid' => $signid, 'uid' => $uid));
        $ret = $this->db->delete('moa_signDetail');
        if ($ret == 1) {
            $this->db->where('signid', $signid);
            $tem = $this->db->get('moa_signBrief')->result();
            $num = $tem[0]->signNum;
            $num -= 1;
            $this->db->set('signNum', $num);
            $this->db->where('signid', $signid);
            $this->db->update('moa_signBrief');
        }
        return ($ret == 1);
    }
}
