<?php

/**
 * 假期时间表排班
 * By 高少彬
 */
class Moa_scheduleduty_model extends CI_Model {

    public function addDateList($wid, $hsid, $dateList) {

        // 使用事务封装多个操作
        $this->db->trans_start();

            // 清空之前的数据
            $sql =  ''.
                    'DELETE FROM moa_scheduleduty WHERE '.
                    ' wid = '.$wid.
                    ' AND hsid = '.$hsid.";";

            $query  = $this->db->query($sql);

            // 对每个日期插入一条数据
            forEach($dateList as $date) {

                $sql =  ''.
                        'INSERT INTO moa_scheduleduty (timestamp, wid, hsid) VALUES ('.
                        '"'.$date.'",'.
                        $wid.",".
                        $hsid.
                        ');';
                $query  = $this->db->query($sql);
            }
        $this->db->trans_complete();

        $res    = $this->db->trans_status();

        return $res;
    }

    public function get_by_hsid($hsid) {
        $sql =  ''.
                'SELECT * FROM moa_scheduleduty WHERE hsid = '.
                $hsid.
                ' ORDER BY timestamp ASC;';
        $query  = $this->db->query($sql);
        $res = $query->result();

        return $res;
    }

    public function updatePermitted($dataList, $hsid) {
        $this->db->trans_start();

        for($i = 0; $i < count($dataList); $i++) {
            $wids = $dataList[$i]['wids'];
            $timestamp = $dataList[$i]['timestamp'];

            // 对于每一个$wid, $timestamp, $hsid都查看是否存在，不存在则插入，存在则修改 isPermitted
            for($j = 0; $j < count($wids); $j++) {
                $wid = $wids[$j];
                $sql =  ''.
                        'SELECT * FROM Moa_scheduleduty WHERE wid = '.
                        $wid.
                        ' AND hsid = '.$hsid.
                        ' AND timestamp = "'.$timestamp.'";'
                        ;
                $query  = $this->db->query($sql);
                $res = $query->result();

                // 如果已经存在，则修改isPermitted
                if($res) {
                    $hdid = $res[0]->hdid;
                    $sql =  ''.
                            'UPDATE Moa_scheduleduty set isPermitted = 1 WHERE hdid = '.$hdid.';';
                } else {
                    //否则直接插入数据
                    $sql =  ''.
                            'INSERT INTO moa_scheduleduty (timestamp, wid, hsid, isPermitted) VALUES ('.
                            '"'.$timestamp.'",'.
                            $wid.",".
                            $hsid.
                            ' , 1);';
                }
                $query  = $this->db->query($sql);
            }

        }


        $this->db->trans_complete();

        $res    = $this->db->trans_status();

        return $res;
    }

    public function get_by_wid_and_hsid($wid, $hsid) {
        $sql=   ''.
                ' SELECT * FROM moa_scheduleduty '.
                ' WHERE wid = '.$wid.' '.
                ' AND hsid = '.$hsid.';';
        $query  = $this->db->query($sql);
        return $query->result();
    }

}
