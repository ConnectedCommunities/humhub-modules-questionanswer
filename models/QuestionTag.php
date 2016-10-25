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

namespace humhub\modules\questionanswer\models;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "question_tag".
 *
 * The followings are the available columns in table 'question_tag':
 * @property integer $id
 * @property integer $question_id
 * @property integer $tag_id
 */
class QuestionTag extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'question_tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(['question_id', 'tag_id'], 'required'),
			array(['question_id', 'tag_id'], 'integer'),
			array(['question_id', 'tag_id'], 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
//			'question' => array(static::BELONGS_TO, 'Question', 'question_id'),
//			'tag' => array(static::BELONGS_TO, 'Tag', 'tag_id'),
		);
	}

	public function getTag()
	{
		return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
	}

	public function getQuestion()
	{
		return $this->hasOne(Question::className(), ['id' => 'question_id']);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'question_id' => 'Question',
			'tag_id' => 'Tag',
		);
	}
}
