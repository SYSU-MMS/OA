<?php

/**
 * 假期时间表排班
 * By 高少彬
 */
class Moa_holidayschedule_model extends CI_Model
{
    public function add($name, $from, $to, $description)
    {
        if (isset($_SESSION['user_id'])) {
            $sql = "".
                   "INSERT INTO moa_holidayschedule (name, dayfrom, dayto, description) values (".
                       "\"".$name."\",".
                       "\"".$from."\",".
                       "\"".$to."\",".
                       "\"".$description."\"".
                   ");";
           $this->db->query($sql);
           return $this->db->insert_id();
        } else {
            return false;
        }
    }

}
