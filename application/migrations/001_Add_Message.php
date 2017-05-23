<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Message extends CI_Migration {

	public function up()
	{

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user' => array(
				'type' => 'BIGINT',
			),
			'room_id' => array(
				'type' => 'BIGINT',
			),
			'message' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('message');

	}

	public function down()
	{
		$this->dbforge->drop_table('message');
	}
}

