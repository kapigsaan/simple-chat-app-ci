<?php
class M_user extends CI_Model {

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
}