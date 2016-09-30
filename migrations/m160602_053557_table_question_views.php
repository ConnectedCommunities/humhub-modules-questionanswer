<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.org/licences GNU AGPL v3
 *
 */

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