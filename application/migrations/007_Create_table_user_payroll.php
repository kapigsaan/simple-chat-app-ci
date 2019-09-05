<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_user_payroll extends CI_Migration {

	public function up()
	{

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'BIGINT',
			),
			'time_log_id' => array(
				'type' => 'BIGINT',
			),
			'salary_rate' => array(
				'type' => 'float',
			),
			'late' => array(
				'type' => 'float',
			),
			'night_diff' => array(
				'type' => 'float',
			),
			'overtime' => array(
				'type' => 'float',
			),
			'salary_receive' => array(
				'type' => 'float',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('user_payroll');

	}

	public function down()
	{
		$this->dbforge->drop_table('user_payroll');
	}
}

