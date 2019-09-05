<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Chat_room_members extends CI_Migration {

	public function up()
	{

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'chat_room' => array(
				'type' => 'BIGINT',
			),
			'member' => array(
				'type' => 'BIGINT',
			),
			'is_member_removed' => array(
				'type' => 'BIGINT',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('chat_room_members');

	}

	public function down()
	{
		$this->dbforge->drop_table('chat_room_members');
	}
}

