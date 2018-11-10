<?php

/**
 * 假期时间表排班
 * By 高少彬
 */
class Moa_holidayschedule_model extends CI_Model
{
    public function add($name, $from, $to, $description) {
        $sql = "".
               "INSERT INTO moa_holidayschedule (name, dayfrom, dayto, description) values (".
                   "\"".$name."\",".
                   "\"".$from."\",".
                   "\"".$to."\",".
                   "\"".$description."\"".
               ");";
       $this->db->query($sql);
       return $this->db->insert_id();
    }

    public function all() {
       $sql =  "".
               "SELECT * FROM moa_holidayschedule;";
       $query = $this->db->query($sql);
       $res = $query->result();
       return $res;
    }

    // 取最后一条有效的报名表记录
    public function latest() {
        $sql = "".
               "SELECT * FROM moa_holidayschedule WHERE isValid = 1 ORDER BY hsid DESC LIMIT 1;";
        $query = $this->db->query($sql);
        $res = $query->result();
        return $res;
    }

}
