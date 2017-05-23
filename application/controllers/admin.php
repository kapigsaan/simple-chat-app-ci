<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_chat_room');
	}

	public function home()
	{
		$data['conversations'] = $this->m_chat_room->getAll();
		
		$this->load->view('adminhome', $data);

	}

	public function viewConversation($conversation_id)
	{
		$data['conversation'] = $this->m_chat_room->getRoomWithConversation($conversation_id);
		
		$this->load->view('admin_show_conversation', $data);
	}
}
