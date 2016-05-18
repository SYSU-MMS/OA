<?php
/**
 * 工作通知模型类
 * @author wico
 */
class moa_notice_model extends CI_Model {
    /**
     * 增加一则通知
     * @param paras - 参数列表
     * @return 通知nid
     */
    public function add($paras) {
        if (isset($paras)) {
            $this->db->insert('MOA_Notice', $paras);
            return $this->db->insert_id();
        }
        else {
            return false;
        }
    }
}