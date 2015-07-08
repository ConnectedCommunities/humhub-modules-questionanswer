<?php

/**
 * This is the model class for table "question".
 *
 * The followings are the available columns in table 'question':
 * @property integer $id
 * @property integer $question_id
 * @property string $post_title
 * @property string $post_text
 * @property string $post_type
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Question extends HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'question';
	}

	/**
	 * Set default scope so that
	 * only answers are retrieved 
	 */
    public function defaultScope()
    {
        return array(
            'condition'=>"post_type='question'",
        );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_text, post_type, created_by, updated_by', 'required'),
			array('question_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('post_title, post_type', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, question_id, post_title, post_text, post_type, created_at, created_by, updated_at, updated_by', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        return array(
            'user' => array(static::BELONGS_TO, 'User', 'created_by'),
            'answers' => array(static::HAS_MANY, 'Answer', 'question_id'),
            'votes' => array(static::HAS_MANY, 'QuestionVotes', 'post_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'question_id' => 'Question',
			'post_title' => 'Post Title',
			'post_text' => 'Post Text',
			'post_type' => 'Post Type',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
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
		$criteria->compare('post_title',$this->post_title,true);
		$criteria->compare('post_text',$this->post_text,true);
		$criteria->compare('post_type',$this->post_type,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Question the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/** 
	 * Returns a list of questions with stats
	 */
	public static function overview() 
	{

		// $list= Yii::app()->db->createCommand('select * from post where category=:category')->bindValue('category',$category)->queryAll();
		$sql = "SELECT q.id, q.post_title, q.post_text, q.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes
				FROM question q
				LEFT JOIN question_votes up ON (q.id = up.post_id AND up.vote_on = 'question' AND up.vote_type = 'up')
				LEFT JOIN question_votes down ON (q.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down')
				LEFT JOIN question answers ON (q.id = answers.question_id AND answers.post_type = 'answer')
				WHERE q.post_type = 'question'
				GROUP BY q.id
				ORDER BY score DESC, vote_count DESC";

		return Yii::app()->db->createCommand($sql)->queryAll();

	}

}
