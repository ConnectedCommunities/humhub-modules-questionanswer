<?php

namespace humhub\modules\questionanswer\models;

use humhub\modules\user\models\User;
use humhub\modules\karma\models\Karma;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\components\ActiveRecord;

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
        return array(
            array(['question_id', 'tag_id'], 'required'),
            array(['question_id', 'tag_id'], 'integer'),
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
			'question' => array(static::BELONGS_TO, 'Question', 'question_id'),
			'tag' => array(static::BELONGS_TO, 'Tag', 'tag_id'),
		);
	}

    public function getQuestion()
    {
        return $this->hasOne('Question', ['question_id']);
    }

    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
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
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('tag_id',$this->tag_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QuestionTag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
