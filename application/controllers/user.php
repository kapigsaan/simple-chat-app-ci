<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->model('m_chat_room');
	}
	
	public function addUserToRoom($userId, $roomId)
	{
		$data['chat_room'] = $roomId;
		$data['member'] = $userId;
		$data['is_member_removed'] = false;
		$date = date('Y-m-d H:i:s');
		$data['created_at'] = $date;
		$data['updated_at'] = $date;
		
		$this->m_chat_room->addChatRoomMember($data);

		redirect('welcome/index/'.$roomId);
	}
}
