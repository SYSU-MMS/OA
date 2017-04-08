<?php

/**
 * Class Moa_config_model
 * 系統設置
 */
class Moa_config_model extends CI_Model
{
    public function update($var_name, $value) {
        if (isset($var_name) && isset($value)) {
            $this->db->where(array(
                'variable' => $var_name,
            ));
            $this->db->update('MOA_Config', array('value' => $value));
            return !(!$this->db->affected_rows());
        }
        else {
            return false;
        }
    }

    /**
     * @param $var_name
     * directly return value string;
     */
    public function get_by_name($var_name) {
        if (isset($var_name)) {
            $this->db->where(array(
                'variable' => $var_name,
            ));
            $res = $this->db->get('MOA_Config')->result();
            return $res[0]->value;
        }
        else {
            return false;
        }

    }

    public function get_all() {
        $res = $this->db->get('MOA_Config')->result();
        return $res;
    }
}

?>