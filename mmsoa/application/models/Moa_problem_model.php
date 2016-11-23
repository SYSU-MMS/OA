<?php
class Moa_problem_model extends CI_Model {
	/**
	 * 获取指定pid的problem信息
	 * @param pid - 故障pid
	 * @return pid对应problem的所有信息
	 */
	public function get($pid) {
		if (isset($pid)) {
			$this->db->where(array('pid'=>$pid));
			$res = $this->db->get('MOA_Problem')->result();
			return $res[0];
		}
		else {
			$res = $this->db->get('MOA_Problem')->result();
			return $res;
		}
		return false;
	}

	/**
	 * 获取所有problem信息
	 * @author 高少彬
	 * @return 所有problem信息
	 */
	public function get_all() {

		/*sql逻辑
			Problem表（子查询）：选出未被删除的条目，同时join一个checkroom表获得roomid对应的room
			founder表（子查询）：为了找出founder_wid对应的name, founder_name
			solve表（子查询）：  为了找出solve_wid对应的name, sovle_name
		*/
		$sql = ''.
			'select  '.
			'    room, pid, founder_wid, founder_name, solve_wid, solve_name, roomid, description, solution, found_time, state, solved_time '.
			'from '.
			'        ( '.
			'            select  '.
			'                C.room, P.pid, P.founder_wid, P.solve_wid, P.roomid, P.description, P.solution , P.found_time , P.state, P.solved_time '.
			'            from  '.
			'                moa_checkroom C '.
			'                inner join  '.
			'                moa_problem P '.
			'                on C.roomid = P.roomid '.
			'            where '.
			'                P.state = 0 '.
			'        ) as  '.
			'    Problem '.
			'    inner join '.
			'        (select name as founder_name, uid, wid  from moa_worker natural join moa_user) as  '.
			'    founder '.
			'    on founder.wid = Problem.founder_wid '.
			'    left join '.
			'        (select name as solve_name, uid, wid from moa_worker natural join moa_user) as  '.
			'    solver '.
			'    on solver.wid = Problem.solve_wid '.
			'order by solved_time;';

		return $this->db->query($sql)->result();
	}

	public function get_unsolve(){
        $sql = "select * from moa_problem where solved_time = NULL";
        return $this->db->query($sql)->result();
    }

	// public function test() {
	// 	$sql = 'insert into moa_problem (solve_wid, roomid, founder_wid, description, found_time) value (108, 30286, 108, \'测试111\', \'2016-11-21 11:32:07\');';
	//
	// 	for($i =0; $i < 6000; $i++) {
	// 		$this->db->query($sql);
	// 	}
	// }
	/**
	 * 删除一条
	 * @param pid
	 * @author 高少彬
	 * @return 影响的行数
	 */
	public function delete_by_id($pid) {

		$sql = 'update moa_problem set state = 1 where pid = '.$pid.';';
		$result = $this->db->query($sql);
		return $this->db->affected_rows();

	}

	/**
	 * 更新一条
	 * @param pid, solved_time, solve_wid, solution
	 * @author 高少彬
	 * @return 影响的行数
	 */
	public function update($pid, $solved_time, $solve_wid, $solution) {
		$sql = 'update moa_problem set solved_time = \''.$solved_time.'\', solve_wid = '.$solve_wid.', solution = \''.$solution.'\'  where pid = '.$pid.';';
		$result = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	/**
	 * 插入一条
	 * @param founder_wid, found_time, roomid, description
	 * @author 高少彬
	 * @return 影响的行数
	 */
	public function insert($founder_wid, $found_time, $roomid, $description) {

		$sql = 'insert into moa_problem '.
			   '	(founder_wid, found_time, roomid, description) '.
			   'value ('.$founder_wid.', \''.$found_time.'\', '.$roomid.', \''.$description.'\');';
		$result = $this->db->query($sql);
		return $this->db->affected_rows();

	}

	/**
	 * 查询课室故障统计
	 * @author 高少彬
	 * @return 所有的课室的故障情况, room, times(故障次数)
	 */
	public function get_all_statistics() {

		$sql =  'select '.
					  '  room, '.
					  '  times '.
					  'from  '.
					  '    (select roomid, room from moa_checkroom) as allroom '.
					  '  left join  '.
					  '    (select roomid, count(*) as times from moa_problem where state = 0 group by roomid) as problem '.
					  'on allroom.roomid = problem.roomid '.
					  'order by times DESC; ';
		return $this->db->query($sql)->result();
	}

	/**
	 * 查询课室故障统计
	 * @param  开始时间，结束时间
	 * @author 高少彬
	 * @return 所有的课室的故障情况
	 */
	public function get_statistics_by_time($start_time, $end_time) {

		$sql =  ''.
						'select  '.
						'  room, '.
						'  times '.
						'from  '.
						'    (select roomid, room from moa_checkroom) as allroom '.
						'  natural join  '.
						'    (select  '.
						'        roomid, count(*) as times  '.
						'    from  '.
						'        moa_problem  '.
						'    where   found_time > \''.$start_time.'\' '.
						'        and found_time < \''.$end_time.'\' '.
						'				 and state = 0	'.
						'    group by roomid) as problem '.
						'order by times DESC;';
		return $this->db->query($sql)->result();
	}
	
	public function add($paras){
        if (isset($paras)){
            $this->db->insert('moa_problem',$paras);
            return $this->db->insert_id();
        }
    }

}
