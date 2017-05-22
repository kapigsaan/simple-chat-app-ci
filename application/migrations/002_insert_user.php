<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Insert_user extends CI_Migration {

	public function up()
	{

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'image' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			)
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('user');

		$data = array(
            array('id' => '1',
            'username' => 'user1',
            'password' => 'password'),
            array('id' => '2',
            'username' => 'user2',
            'password' => 'password'),
         );

         $this->db->insert_batch('user', $data);

	}

	public function down()
	{
		$this->dbforge->drop_table('user');
	}
}

