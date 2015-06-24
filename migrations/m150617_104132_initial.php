<?php

class m150617_104132_initial extends EDbMigration
{
	public function up()
	{
        $this->createTable('question', array(
            'id' => 'pk',
            'question_id' => 'int(11) DEFAULT NULL', // id of original question, null if an answer
            'parent_id' => 'int(11) DEFAULT NULL', // id of parent (could be a question, answer or even a comment)
            'post_title' => 'varchar(255) DEFAULT NULL', // null if an answer
            'post_text' => 'TEXT NOT NULL',
            'post_type' =>  'enum(\'question\',\'answer\', \'comment\') NOT NULL', 
            'created_at' => 'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP',
            'created_by' => 'int(11) NOT NULL',
            'updated_at' => 'TIMESTAMP',
            'updated_by' => 'int(11)',
        ), '');

		$this->createTable('question_votes', array(
            'id' => 'pk',
            'user_id' => 'int(11) NOT NULL',
            'post_id' => 'int(11) NOT NULL',
            'created_at' => 'datetime NOT NULL',
            'created_by' => 'int(11) NOT NULL',
            'updated_at' => 'datetime NOT NULL',
            'updated_by' => 'int(11) NOT NULL',
        ), '');

	}

	public function down()
	{
		echo "m150617_104132_initial does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}