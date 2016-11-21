<?php
/**
 * Created by PhpStorm.
 * User: alcanderian
 * Date: 20/11/2016
 * Time: 22:36
 */

class Moa_school_term_model extends CI_Model{
    public function get_this_term() {
        $now_date = date("Y-m-d H:i:s");

        $this->db->where(array('termendstamp <' => $now_date, 'termbeginstamp >' => $now_date));
        $this->db->limit(1, 0);
        $term = $this->db->get('moa_schoolterm')->result();

        return $term;
    }
}