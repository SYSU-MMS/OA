<?php
/**
 * Created by PhpStorm.
 * User: alcanderian
 * Date: 20/11/2016
 * Time: 22:36
 */

class Moa_school_term_model extends CI_Model{
    public function get_term($date = NULL) {
        if($date != NULL) {
            $this->db->where(array('termendstamp >' => $date, 'termbeginstamp <' => $date));
            $this->db->limit(1, 0);
            $term = $this->db->get('MOA_Schoolterm')->result();

            return $term;
        } else {
            $term = $this->db->get('MOA_Schoolterm')->result();
            return $term;
        }
    }

    /**
     * @param $para array('YYYY-YYYY', '春季學期/秋季學期'，'begintimestamp', 'endtimestamp')
     */
    public function new_term($para) {
        if(isset($para)) {
            $this->db->insert('MOA_Schoolterm', $para);
            $ret = $this->db->insert_id();
            return $ret;
        } else return false;
    }

    public function delete_term($termid) {
        if(isset($termid)) {
            $this->db->where(array('termid' => $termid));
            $this->db->delete('MOA_Schoolterm');
            $ret = $this->db->affected_rows();
            return $ret;
        } else return false;
    }
}