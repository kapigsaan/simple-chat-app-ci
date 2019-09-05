<?php
class M_chat_room extends CI_Model 
{
    public function getAll()
    {
    	$sql = '
    		SELECT 
    			cr.*,u.fullname, u.id as userId
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
    			cr.*,u.fullname, u.id as userId
    		FROM chat_room cr
    		LEFT JOIN user u
    		ON cr.owner = u.id
    		WHERE cr.id = ?
    	';

    	$query = $this->db->query($sql, array($room_id));

    	return $query->row();

    }

    public function checkIfRoomOwner($room_id, $user_id)
    {
        $sql = '
            SELECT 
                cr.*,u.fullname, u.id as userId
            FROM chat_room cr
            LEFT JOIN user u
            ON cr.owner = u.id
            WHERE cr.id = ?
            AND u.id = ?
        ';

        $query = $this->db->query($sql, [$room_id, $user_id]);

        return $query->row();

    }

    public function checkIfRoomMember($room_id, $user_id)
    {
        $sql = '
            SELECT 
                cr.*,u.fullname, u.id as userId
            FROM chat_room_members cr
            LEFT JOIN user u
            ON cr.member = u.id
            WHERE cr.chat_room = ?
            AND u.id = ?
        ';

        $query = $this->db->query($sql, [$room_id, $user_id]);

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
            $sql = 'SELECT c.*,u.fullname,u.id as userId
                 from chat_room_members c
                 LEFT JOIN user u on c.member = u.id
                 where c.chat_room = '.$v->id.'
                 AND c.is_member_removed = 0
            ';
            $data[$v->id]['room'] = $v;
            $data[$v->id]['room-members'] = $this->db->query($sql)->result();
        }
        
        return $data;

    }

    public function kickMember($userId = FALSE, $roomId = FALSE)
    {
        $data['is_member_removed'] = 1;
        $this->db->where('member', $userId);
        $this->db->where('chat_room', $roomId);
        return $this->db->update('chat_room_members', $data);
    }

    public function getRoomWithConversation($roomId)
    {
        $sql = '
            SELECT
                *
            FROM chat_room
            WHERE id = ? 
            ';

        $query = $this->db->query($sql, array($roomId));
        $room = $query->row();
        $data = array();

        $data[$room->id]['room'] = $room;
        $data[$room->id]['room-users'] = $this->getUserConversations($room->id);
        $data[$room->id]['room-users-user-id'] = $this->getUserConversationsIds($room->id);

        return $data;   
    }

    public function getUserConversationsIds($roomId)
    {
        $users = array();
        $userConversation = $this->getUserConversations($roomId);

        foreach ($userConversation as $converse) {
            $users[$converse->member] = $converse->member;
        }

        return $users;
    }

    public function getUserConversations($roomId)
    {
        $sql = '
            SELECT 
                c.*,u.fullname,u.id as userId
            FROM chat_room_members c
            LEFT JOIN user u on c.member = u.id
            WHERE chat_room = ?  
        ';

        $query = $this->db->query($sql, array($roomId));
        
        return $query->result();
    }

    public function checkIfRoomAvailable($status, $room_id, $user_id)
    {
        if ($status == 'public'){
            return true;
        }

        $sql = '
            SELECT 
                cr.*,u.fullname, u.id as userId
            FROM chat_room_members cr
            LEFT JOIN user u
            ON cr.member = u.id
            WHERE cr.chat_room = ?
            AND u.id = ?
            AND cr.is_member_removed = ?
        ';

        $query = $this->db->query($sql, [$room_id, $user_id, 0]);

        return $query->row();

    }

}