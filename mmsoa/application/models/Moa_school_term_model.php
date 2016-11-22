<?php
/**
 * Created by PhpStorm.
 * User: alcanderian
 * Date: 20/11/2016
 * Time: 22:36
 */

class Moa_school_term_model extends CI_Model{
    public function get_term($date) {
        $this->db->where(array('termendstamp >' => $date, 'termbeginstamp <' => $date));
        $this->db->limit(1, 0);
        $term = $this->db->get('MOA_Schoolterm')->result();

        return $term;
    }
}