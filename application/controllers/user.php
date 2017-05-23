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
		
		$this->m_chat_room->addChatRoomMember($data);

		redirect('welcome/index/'.$roomId);
	}
}
