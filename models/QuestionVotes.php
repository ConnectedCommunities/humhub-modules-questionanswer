<?php

namespace humhub\modules\questionanswer\models;

use humhub\modules\user\models\User;
use humhub\modules\karma\models\Karma;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\components\ActiveRecord;

/**
 * This is the model class for table "question_votes".
 *
 * The followings are the available columns in table 'question_votes':
 * @property integer $id
 * @property integer $post_id
 * @property string $vote_on
 * @property string $vote_type
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class QuestionVotes extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'question_votes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return [
            [['post_id', 'created_by'], 'required'],
            [['vote_on', 'vote_type'], 'string', 'max' => 255],
            [['post_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
			'post_id' => 'Post',
			'vote_on' => 'Vote On',
			'vote_type' => 'Vote Type',
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
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('vote_on',$this->vote_on,true);
		$criteria->compare('vote_type',$this->vote_type,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/** 
	 * Add scopes to Answer model
	 */
    public function scopes()
    {
        return array(
            'votes_on_questions'=>array(
                'condition'=>"vote_on='question'",
            )
        );
    }

	/** 
	 * Filters results by post_id
	 * @param $user_id
	 */
	public function post($post_id)
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>"post_id=:post_id", 
	        'params' => array(':post_id' => $post_id)
	    ));

	    return $this;
	}

	/** 
	 * Filters results by user_id
	 * @param $user_id
	 */
	public function user($user_id)
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>"created_by=:user_id", 
	        'params' => array(':user_id' => $user_id)
	    ));

	    return $this;
	}


	/** 
	 * Returns votes a user has cast on a post
	 */
	public function user_vote($post_id, $user_id)
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>"created_by=:user_id AND post_id=:post_id", 
	        'params' => array(':user_id' => $user_id, ':post_id' => $post_id)
	    ));

	    return $this;
	}

	/** 
	 * Returns the score of a post
	 */
	public static function score($post_id) {

		// Calculate the "score" (up votes minus down votes)
		$sql = "SELECT ((SELECT COUNT(*) FROM question_votes WHERE vote_type = 'up' AND post_id=:post_id) - (SELECT COUNT(*) FROM question_votes WHERE vote_type = 'down' AND post_id=:post_id))";
		return Yii::$app->db->createCommand($sql)->bindValue('post_id', $post_id)->queryScalar();

	}


	/** 
	 * Returns the accepted answer for a question
	 * @param $question_id
	 */
	public function findAcceptedAnswer($question_id) {

		$sql = "SELECT * FROM question_votes
				WHERE post_id IN (SELECT id FROM question WHERE question_id = :question_id)
				AND vote_on = 'answer' 
				AND vote_type = 'accepted_answer'";

		return QuestionVotes::model()->findBySql($sql, array(':question_id' => $question_id));

	}

	/**
	 * Cast a vote
	 * @param QuestionVote 
	 * @param int question_id (optional)
	 */
	public static function castVote($questionVotesModel, $question_id) 
	{
		
		$question = Question::model()->findByPk($question_id);
		$questionVotesModel->created_by = Yii::app()->user->id;	
    
        if($questionVotesModel->validate())
        {

        	// Is the author "voting" on the accepted answer?
        	if($question->created_by == $questionVotesModel->created_by && $questionVotesModel->vote_type == "accepted_answer") {

	        	// If the user has previously selected a best answer, drop the old one
	        	$previousAccepted = QuestionVotes::model()->findAcceptedAnswer($question->id);
	        	if($previousAccepted && $previousAccepted->post_id != $question->id) $previousAccepted->delete();

        	} else { // no, just a normal up/down vote then

	        	// If the user has previously voted on this, drop it 
	        	$previousVote = QuestionVotes::model()->find('post_id=:post_id AND created_by=:user_id', array('post_id' => $questionVotesModel->post_id, 'user_id' => Yii::app()->user->id));
	        	if($previousVote) $previousVote->delete();

        	}

            $questionVotesModel->save();
            return true;
        } else {
        	return false;
        }

	}

	/** 
	 * Mark an answer as the best answer
	 * @param QuestionVotes
	 */
	public static function markBestAnswer($questionVotesModel) 
	{

	}
}
