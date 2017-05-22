<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('m_chat');
	}

	public function index()
	{

		$this->load->view('welcome_message');


	}

	public function chat()
	{

		if ($this->input->post()) {
			$data['message'] = $this->input->post('message');
			$date = date('Y-m-d H:i:s');
			$data['created_at'] = $date;

			$ret = $this->m_chat->createMessage($data);

			if ($ret) {
				redirect('welcome/index');
			}

		}



	}
}
