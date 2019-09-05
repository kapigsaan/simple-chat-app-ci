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

    public function getAllRoomMessagesByUsers($roomId, $users)
	{
		$query = $this->db
		     ->select( '*' )
		     ->from( 'message')
		     ->where( 'room_id', $roomId )
		     ->where_in( 'user', $users )
		     ->join('user', 'user.id = message.user', 'left')
		     ->order_by('created_at', 'ASC')
		     ->get();

		$result = $query->result();

		return $result;
	}



    function delete($id){

        $this->db->where('id', $id);
        $this->db->delete('message');

    }
    
}