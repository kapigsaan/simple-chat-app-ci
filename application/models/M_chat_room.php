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
    			*
    		FROM chat_room cr
    		LEFT JOIN user u
    		ON cr.owner = u.id
    		WHERE cr.id = ?
    	';

    	$query = $this->db->query($sql, array($room_id));

    	return $query->result();

    }
}