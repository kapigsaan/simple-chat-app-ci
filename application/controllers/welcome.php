<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_chat');
	}

	public function index($userId = 1, $id = FALSE)
	{	
		$data['messages'] = $this->m_chat->getAllByUser($userId);
		$data['userId'] = $userId;
		$this->load->view('welcome_message', $data);
	}

	public function changeUser($userId = 1)
	{
		redirect('/welcome/index/'.$userId);

	}

	public function createMessage()
	{
		$data['message'] = $this->input->post('message');
		$date = date('Y-m-d H:i:s');
		$data['created_at'] = $date;

		$ret = $this->m_chat->createMessage($data);

		echo json_encode('success');
	}
	
}
