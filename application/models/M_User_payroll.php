<?php
class M_User_payroll extends CI_Model 
{
	public function recompute($log_id, $data)
	{
		$payroll = $this->get($log_id);

		if($payroll)
		{
			$this->update($payroll->id, $data);
		}else{
			$this->insert($data);
		}
	}	

	public function insert($data)
	{
		$this->db->insert('user_payroll', $data);

		return $this->db->insert_id;
	}

	public function update($payroll_id, $data)
	{
		$this->db->where('id', $payroll_id);

		$this->db->update('user_payroll', $data);

		return true;
	}

	public function get($log_id)
	{
		$this->db->where('time_log_id', $log_id);
		$q = $this->db->get('user_payroll');

		return $q->row();
	}
}