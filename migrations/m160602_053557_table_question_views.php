<?php

use yii\db\Migration;

class m160602_053557_table_question_views extends Migration
{
	public function up()
	{
		if(!\Yii::$app->db->schema->getTableSchema("question_views")) {
			$this->createTable('question_views', array(
				'id' => 'pk',
				'question_id' => 'int(11) DEFAULT NULL', // id of original question, null if an answer
				'created_at' => 'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP',
				'created_by' => 'int(11) NOT NULL',
				'updated_at' => 'TIMESTAMP',
				'updated_by' => 'int(11)',
			), '');
		}
	}

	public function down()
	{
		echo "m160602_053557_table_question_views does not support migration down.\n";
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