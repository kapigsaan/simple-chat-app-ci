<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Insert_user extends CI_Migration {

	public function up()
	{

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
			'fullname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'firstname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'lastname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'google_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
			'gender' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
			),
			'dob' => array(
				'type' => 'VARCHAR',
				'constraint' => 15,
			),
			'profile_image' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'gpluslink' => array(
				'type' => 'TEXT',
				'null' => TRUE,	
			),
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('user');
	}

	public function down()
	{
		$this->dbforge->drop_table('user');
	}
}

