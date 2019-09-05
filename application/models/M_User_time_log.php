<?php
class M_User_time_log extends CI_Model {
	public function update_user_logs($data)
	{

		$this->db->update_batch('user_time_log', $data, 'id');

		return true;
	}

	public function get($log_id)
	{
		$this->db->where('id', $log_id);

		$q  = $this->db->get('user_time_log');

		return $q->row();
	}
}