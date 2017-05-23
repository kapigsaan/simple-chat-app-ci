<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Chat_room extends CI_Migration {

	public function up()
	{

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'owner' => array(
				'type' => 'BIGINT',
			),
			'name' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'status' => array(
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
		$this->dbforge->create_table('chat_room');

	}

	public function down()
	{
		$this->dbforge->drop_table('chat_room');
	}
}

