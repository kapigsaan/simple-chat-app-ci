<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_chat');
	}

	public function index($userId = 1)
	{
		$data['activeUser'] = $userId;
		if ($userId = 1){
			$data['messages'] = $this->m_chat->getConversation($userId,2);	
		}else{
			$data['messages'] = $this->m_chat->getConversation(1,$userId);
		}
		$this->load->view('welcome_message', $data);
	}

	public function changeUser($userId = 1)
	{
		redirect('/welcome/index/'.$userId);

	}

	public function getConversation($userId = 1){
		$data['activeUser'] = $userId;
		if ($userId = 1){
			$data['messages'] = $this->m_chat->getConversation($userId,2);	
		}else{
			$data['messages'] = $this->m_chat->getConversation(1,$userId);
		}
		$theHTMLResponse    = $this->load->view('conversations', $data, true);

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('messages'=> $theHTMLResponse)));

	}

	public function createMessage($userId = 1)
	{
		$data['message'] = $this->input->post('message');
		$date = date('Y-m-d H:i:s');
		$data['created_at'] = $date;
		$data['user'] = $userId;
		$ret = $this->m_chat->createMessage($data);

		echo json_encode('success');
	}
	
}
