<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

        $this->load->library('migration');

        if ( ! $this->migration->version(1))
        {
            echo 'Error' . $this->migration->error_string();
        } else {
            echo 'Migrations ran successfully!';
        }

	}
}
