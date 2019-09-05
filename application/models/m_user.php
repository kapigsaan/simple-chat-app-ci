<?php
class M_User extends CI_Model {
	
	public function insert($data){
		$user = $this->checkIfUserExist($data['google_id']);
		
		if (!$user){
			$this->db->insert('user', $data);
        	return $this->db->insert_id();	
		}else{
			return $user->id;
		}
	}

	public function checkIfUserExist($googleId)
	{
		$sql = '
			SELECT
				*
			FROM user
			WHERE google_id = ?
		';

		$query = $this->db->query($sql, array($googleId));

		return $query->row();

	}

	public function getAllUser()
	{
		$sql = '
			SELECT
				*
			FROM user
		';

		$q = $this->db->query($sql);

		return $q->result();
	}

	public function getAvailableUserInRoom($roomId)
	{
		$sql = '
			SELECT
				*
			FROM user
		';

		$q = $this->db->query($sql);
		$users = $q->result();
		$data = array();
		foreach ($users as $key => $user) {
			$room = $this->getRoom($roomId, $user->id);
			if (!$room)
			{
				$data[$key] = $user;
			}
		}

		return $data;
	}

	public function getRoom($roomId, $userId){
		$sql = '
			SELECT 
				*
			FROM chat_room_members
			WHERE chat_room = ?
			AND member = ?
		';

		$q = $this->db->query($sql, array($roomId, $userId));

		return $q->row();
	}

	public function checkIfUserInRoom($roomId, $userId)
	{
		$sql = '
			SELECT 
				*
			FROM chat_room_members
			WHERE chat_room = ?
			AND member = ?
			AND is_member_removed = ?
		';

		$q = $this->db->query($sql, array($roomId, $userId, 0));

		$result = $q->row();

		return $result?true:false;

	}

	public function addTimeLog($data)
	{

		$this->db->insert('user_time_log', $data);
    	return $this->db->insert_id();
    	
	}

	public function updateTimeLog($data, $id)
	{

		$this->db->where('id', $id);
		$this->db->update('user_time_log', $data);
    	return $this->db->insert_id();
    	
	}

	public function getDailyHour($id)
	{

		$sql = '
			SELECT 
				TIME_TO_SEC(TIMEDIFF(noon_out_log, morning_in_log))/3600 as hours
			FROM user_time_log
			WHERE id = ?
		';
		
		$q = $this->db->query($sql, [$id]);
		$result = $q->row();
		return $result;
    	
	}

	public function getDailyBreak($log_id)
	{
		$sql = '
			SELECT 
				TIME_TO_SEC(TIMEDIFF(noon_in_log, morning_out_log))/3600 as hours
			FROM user_time_log
			WHERE id = ?
		';
		
		$q = $this->db->query($sql, [$log_id]);
		$result = $q->row();

		return $result;
	}

	public function getNightDiffTotalHours($log_id)
	{
		// get ung night diff within 10pm to 6am;
		// kung may natamaan else 0
		return 1;
	}

	public function getUserTimeLogs($userId)
	{

		$sql = '
			SELECT
				tl.*, up.late, up.night_diff,
				up.overtime, up.salary_receive,
				up.salary_rate
			FROM user_time_log tl
			LEFT JOIN user_payroll up
			ON up.time_log_id = tl.id
			WHERE tl.user_id = ?
			ORDER BY morning_in_log DESC
		';

		$q = $this->db->query($sql, [$userId]);

		return $q->result();

	}

	public function getlastLogStatus($userId)
	{

		$sql = '
			SELECT
				*
			FROM user_time_log
			WHERE user_id = ?
			ORDER BY created_at DESC
		';

		$q = $this->db->query($sql, [$userId]);

		return $q->row();

	}

	public function getUser($user_id)
	{
		$query = $this->db
			->where('id', $user_id)
			->get('user');

		return $query->row();
	}

	public function getMonthlySalary($userId)
	{
		$sql = '
			SELECT year(t.morning_in_log) as y, month(t.morning_in_log) as m, sum(up.salary_receive) as payment,
			sum(up.late) as late, sum(up.night_diff) as night_diff, sum(up.overtime) as overtime
			from user_time_log t
			LEFT JOIN user_payroll up
			ON up.time_log_id = t.id
			WHERE t.user_id = ?
			group by year(t.morning_in_log), month(t.morning_in_log)
			ORDER BY morning_in_log DESC
		';

		$q = $this->db->query($sql, [$userId]);

		return $q->result();
	}
}