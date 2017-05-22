<?php
class M_chat extends CI_Model {

	public function __construct()
	{

		$this->load->database('');

	}

	public function getAll()
	{
		$query = $this->db->get('message');

		return $query->result();
	}

	public function getAllByUser($userId)
	{
		$sql = '
			SELECT 
				*
			FROM message
			WHERE user = ?
		';

		$query = $this->db->query($sql, array($userId));

		return $query->result();
	}

	public function getConversation($firstUserId, $secondUserId)
	{
		$sql = '
			SELECT 
				*
			FROM message
			WHERE user IN (?, ?)
			ORDER BY created_at ASC
		';

		$query = $this->db->query($sql, array($firstUserId, $secondUserId));

		return $query->result();
	}

	/*
	/ @param $message - chat
	/
	*/
	public function createMessage($message = FALSE){

		$this->db->insert('message', $message);

        return $this->db->insert_id();

	}

	function update($id, $message){

        $this->db->where('id', $id);
        $this->db->update('message', $message);

    }


    function delete($id){

        $this->db->where('id', $id);
        $this->db->delete('message');

    }
    
}