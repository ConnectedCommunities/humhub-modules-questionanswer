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

use humhub\modules\content\interfaces\ContentOwner;
use humhub\modules\questionanswer\models\Comment;
use humhub\components\ActiveRecord;
use humhub\modules\questionanswer\notifications\NewAnswer;
use humhub\modules\questionanswer\notifications\NewReply;
use humhub\modules\user\models\User;
use Yii;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\search\interfaces\Searchable;
use yii\helpers\Url;

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
class Answer extends ContentActiveRecord implements Searchable
{

	/**
	 * @inheritdoc
	 */
	public $autoAddToWall = false;

	/**
	 * @inheritdoc
	 */
	public $wallEntryClass = "humhub\modules\questionanswer\widgets\AnswerWallEntryWidget";

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return [
            [['post_text', 'post_type'], 'required'],
            [['post_type'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['question_id', 'created_by', 'updated_by'], 'integer'],
        ];
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
	 * @return array relational rules.
	 */
	public function relations()
	{
        return array(
            'user' => array(static::BELONGS_TO, 'User', 'created_by'),
            'comments' => array(static::HAS_MANY, 'Comment', 'parent_id'),
        );
	}

	public function getQuestion()
	{
		return $this->hasOne(Question::class, ['id' => 'question_id']);
	}

	public function getUser()
	{
		return $this->hasOne(User::class, ['id' => 'created_by']);
	}


	public function getComments()
	{
		return $this->hasMany(Comment::class, ['parent_id' => 'id']);
	}

	/** 
	 * Add scopes to Answer model
	 */
	public static function find()
	{
		return parent::find()->andWhere(['post_type' => 'answer']);
	}



	/** 
	 * Filters results by the question_id
	 * @param $question_id
	 */
	public function question($question_id)
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>"question_id=:question_id", 
	        'params' => array(':question_id' => $question_id)
	    ));

	    return $this;
	}

	/** 
	 * Returns a list of questions with stats
	 */
	public static function overview($question_id) 
	{

		$sql = "SELECT q.id, q.question_id, q.post_title, q.post_text, q.post_type, q.created_by, q.created_at, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes, best.vote_type as answer_status
				FROM question q
				LEFT JOIN question_votes up ON (q.id = up.post_id AND up.vote_on = 'answer' AND up.vote_type = 'up')
				LEFT JOIN question_votes down ON (q.id = down.post_id AND down.vote_on = 'answer' AND down.vote_type = 'down')
				LEFT JOIN question_votes best ON (q.id = best.post_id AND best.vote_on = 'answer' AND best.vote_type = 'accepted_answer') 
                WHERE q.post_type = 'answer'
				AND q.question_id = :parent_id
				GROUP BY q.id
				ORDER BY score DESC, vote_count DESC";

		return Yii::$app->db->createCommand($sql)->bindValue('parent_id', $question_id)->queryAll();

	}


    /**
     * Returns URL to the Question
     *
     * @return string
     */
    public function getUrl()
    {
        $params = [
            '/questionanswer/question/view',
            'id' => $this->question_id,
            '#' => 'post-' . $this->id
        ];

        if(get_class($this->question->space) == \humhub\modules\space\models\Space::class) {
            $params['sguid'] = $this->question->space->guid;
        }

		return Url::toRoute($params);
    }

	/**
	 * @inheritdoc
	 */
	public function getContentName()
	{
		return "Answer";
	}

	/**
	 * @inheritdoc
	 */

	public function getContentDescription()
	{
		return $this->post_text;
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
			'post_text' => $this->post_text,
		];

		return $attributes;
	}

    /**
     * After Save, notify user
     */
    public function afterSave($insert, $changedAttributes)
    {
        if($insert) {
            NewAnswer::instance()->from($this->user)->about($this)->send($this->question->user);
        }
        return parent::afterSave($insert, $changedAttributes);
    }




}
