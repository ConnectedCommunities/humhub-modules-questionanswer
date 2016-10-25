<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

use yii\db\Migration;


class m160426_121009_create_question_and_answer extends Migration
{
	public function up()
	{
		if(!\Yii::$app->db->schema->getTableSchema("question")) {
			$this->createTable('question', array(
				'id' => 'pk',
				'question_id' => 'int(11) DEFAULT NULL', // id of original question, null if an answer
				'parent_id' => 'int(11) DEFAULT NULL', // id of parent (could be a question, answer or even a comment)
				'post_title' => 'varchar(255) DEFAULT NULL', // null if an answer
				'post_text' => 'TEXT NOT NULL',
				'post_type' => 'enum(\'question\',\'answer\', \'comment\') NOT NULL',
				'created_at' => 'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP',
				'created_by' => 'int(11) NOT NULL',
				'updated_at' => 'TIMESTAMP',
				'updated_by' => 'int(11)',
			), '');
		}

		if(!\Yii::$app->db->schema->getTableSchema("question_votes")) {
			$this->createTable('question_votes', array(
				'id' => 'pk',
				'post_id' => 'int(11) NOT NULL',
				'vote_on' => 'varchar(255)', // question, answer
				'vote_type' => 'varchar(255)', // up, down,
				'created_at' => 'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP',
				'created_by' => 'int(11) NOT NULL',
				'updated_at' => 'TIMESTAMP',
				'updated_by' => 'int(11)',
			), '');
		}

		if(!\Yii::$app->db->schema->getTableSchema("tag")) {
			$this->createTable('tag', array(
				'id' => 'pk',
				'tag' => 'varchar(255)',
				'description' => 'TEXT',
			), '');
		}

		if(!\Yii::$app->db->schema->getTableSchema("question_tag")) {
			$this->createTable('question_tag', array(
				'id' => 'pk',
				'question_id' => 'int(11) NOT NULL',
				'tag_id' => 'int(11) NOT NULL',
			), '');
		}
	}

	public function down()
	{
		$this->dropTable("question");
		$this->dropTable("question_votes");
		$this->dropTable("tag");
		$this->dropTable("question_tag");
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