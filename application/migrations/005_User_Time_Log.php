<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_User_Time_Log extends CI_Migration {

	public function up()
	{

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'BIGINT',
			),
			'morning_in_log' => array(
				'type' => 'DATETIME',
			),
			'morning_out_log' => array(
				'type' => 'DATETIME',
			),
			'noon_in_log' => array(
				'type' => 'DATETIME',
			),
			'noon_out_log' => array(
				'type' => 'DATETIME',
			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'check_log' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('user_time_log');

	}

	public function down()
	{
		$this->dbforge->drop_table('user_time_log');
	}
}

