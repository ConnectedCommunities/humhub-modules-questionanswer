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

use humhub\components\ActiveRecord;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\questionanswer\widgets\TagSearchResultWidget;
use humhub\modules\search\interfaces\Searchable;

/**
 * This is the model class for table "tag".
 *
 * The followings are the available columns in table 'tag':
 * @property integer $id
 * @property string $tag
 * @property string $description
 */
class Tag extends ActiveRecord implements Searchable
{

	public $autoAddToWall = false;

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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tag', 'string', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array(['id', 'tag', 'description'], 'safe', 'on'=>'search'),
		);
	}


	/**
	 * Returns the Wall Output
	 */
	public function getWallOut()
	{
		return TagSearchResultWidget::widget(array('tag' => $this));
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
	 */
	public function firstOrCreate($tag) 
	{

		$foundTag = Tag::find()->andWhere(['tag' => $tag])->one();
		if($foundTag) { // found tag
			return $foundTag;
		} else {
			$tagModel = new Tag;
			$tagModel->tag = $tag;
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
    public function getUrl($id)
    {
    	return $this->createUrl(['//questionanswer/main/tag', 'id' => $id]);
    }



    /**
     * After Save Addons
     *
     * @return type
     */
    public function afterSave($insert, $changedAttributes)
    {
        return parent::afterSave($insert, $changedAttributes);
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
			'title' => $this->tag,
			'description' => $this->description,
		];

		$this->trigger(self::EVENT_SEARCH_ADD, new \humhub\modules\search\events\SearchAddEvent($attributes));

		return $attributes;
    }

    /**
     * Returns the Search Result Output
     */
    public function getSearchResult()
    {
        return Yii::app()->getController()->widget('application.modules.questionanswer.widgets.TagSearchResultWidget', array('tag' => $this), true);
    }

	public function getQuestionTag()
	{
		return $this->hasOne(QuestionTag::className(), ['tag_id' => 'id']);
	}
}
