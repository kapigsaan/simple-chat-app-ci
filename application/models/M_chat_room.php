<?php
class M_chat_room extends CI_Model 
{
    public function getAll()
    {
    	$sql = '
    		SELECT 
    			*
    		FROM chat_room cr
    		LEFT JOIN user u
    		ON cr.owner = u.id
    	';

    	$query = $this->db->query($sql);

    	return $query->result();
    }

    public function get($room_id)
    {
    	$sql = '
    		SELECT 
    			cr.*,u.username, u.id as userId
    		FROM chat_room cr
    		LEFT JOIN user u
    		ON cr.owner = u.id
    		WHERE cr.id = ?
    	';

    	$query = $this->db->query($sql, array($room_id));

    	return $query->row();

    }

    public function createRoom($data = FALSE){

        $this->db->insert('chat_room', $data);

        return $this->db->insert_id();

    }

    public function addChatRoomMember($data)
    {
        $this->db->insert('chat_room_members', $data);

        return $this->db->insert_id();
    }

    public function getAllRoom()
    {
        $query = $this->db->get('chat_room');

        $rooms = $query->result();
        $data = [];
        foreach ($rooms as $key => $v) {
            $sql = 'SELECT c.*,u.username,u.id as userId
                 from chat_room_members c
                 LEFT JOIN user u on c.member = u.id
                 where chat_room = '.$v->id.'
            ';
            $data[$v->id]['room'] = $v;
            $data[$v->id]['room-members'] = $this->db->query($sql)->result();
        }
        
        return $data;

    }

    public function kickMember($userId = FALSE, $roomId = FALSE)
    {
        $this->db->where('member', $userId);
        $this->db->where('chat_room', $roomId);
        return $this->db->delete('chat_room_members');
    }

}