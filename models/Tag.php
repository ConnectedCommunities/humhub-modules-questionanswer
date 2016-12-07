<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
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
 */

namespace humhub\modules\questionanswer\models;

use humhub\modules\content\components\ContentActiveRecord;
use Yii;
use humhub\components\ActiveRecord;
use humhub\modules\search\interfaces\Searchable;

/**
 * This is the model class for table "tag".
 *
 * The followings are the available columns in table 'tag':
 * @property integer $id
 * @property string $tag
 * @property string $description
 */
class Tag extends ContentActiveRecord implements Searchable
{

	/**
	 * @inheritdoc
	 */
	public $autoAddToWall = false;

	/**
	 * @inheritdoc
	 */
	public $wallEntryClass = "humhub\modules\questionanswer\widgets\TagWallEntryWidget";


	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return [
            [['tag'], 'required'],
            [['tag'], 'string', 'max' => 255],
            [['description'], 'safe'],
        ];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tag' => 'Tag',
			'description' => 'Description',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/** 
	 * Find and return the first tag that matches 
	 * If it cannot find a match, create the tag
	 * @param  String  $tag
     * @return Tag|\yii\db\ActiveQuery
	 */
	public static function firstOrCreate($tag, $contentContainer)
	{


		$foundTag = Tag::find()->contentContainer($contentContainer)->where('tag=:tag', array('tag'=>$tag))->one();

		if($foundTag) { // found tag
			return $foundTag;
		} else {
			$tagModel = new Tag;
			$tagModel->tag = $tag;
			\humhub\modules\content\widgets\WallCreateContentForm::create($tagModel, $contentContainer);
			$tagModel->save();
			return $tagModel;
		}

	}


    /**
     * Returns URL to the Question
     *
     * @param array $parameters
     * @return string
     */
    public function getUrl($parameters = array())
    {
    	return $this->createUrl('//questionanswer/main/tag', $parameters);
    }


	/**
	 * Returns an array of informations used by search subsystem.
	 * Function is defined in interface ISearchable
	 *
	 * @return Array
	 */
	public function getSearchAttributes()
	{

		$attributes = [
			'tag' => $this->tag,
			'description' => $this->description
		];

		return $attributes;
	}

	public function getContentName()
	{
		return "Tag";
	}


}
