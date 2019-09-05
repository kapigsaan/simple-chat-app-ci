<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
	}

	public function index($id = 7)
	{

        $this->load->library('migration');

        if ( ! $this->migration->version($id))
        {
            echo 'Error' . $this->migration->error_string();
        } else {
            echo 'Migrations ran successfully!';
        }

	}
}
