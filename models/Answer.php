<?php

namespace humhub\modules\questionanswer\models;

use humhub\modules\questionanswer\models\Comment;
use humhub\components\ActiveRecord;
use Yii;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\search\interfaces\Searchable;

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
class Answer extends ActiveRecord implements Searchable
{

    public $autoAddToWall = false;

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
            [['post_text', 'post_type'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['id' => 'parent_id']);
    }


    /**
     * After Save Addons
     *
     * @return type
     */
    public function afterSave()
    {

        /*parent::afterSave();

        if ($this->isNewRecord) {
            $activity = Activity::CreateForContent($this);
            $activity->type = "AnswerCreated";
            $activity->module = "questionanswer";
            $activity->save();
            $activity->fire();
        }

        HSearch::getInstance()->addModel($this);

        return true;*/

    }

    /**
     * Returns the Wall Output
     */
    public function getWallOut()
    {
//        return "Hello World";
         return Yii::app()->getController()->widget('application.modules.questionanswer.widgets.AnswerWallEntryWidget', array('answer' => $this), true);
    }

    /**
     * Returns an array of informations used by search subsystem.
     * Function is defined in interface ISearchable
     *
     * @return Array
     */
    public function getSearchAttributes()
    {
        $attributes = array(

            // Assignments
            'belongsToType' => 'Answer',
            'belongsToId' => $this->id,
            'belongsToGuid' => $this->user->guid,

            // Information about the record
            'model' => 'Answer',
            'pk' => $this->id,
            'title' => '',
            'url' => $this->getUrl(array('id' => $this->id)),

            // Extra indexed fields
            'post_text' => $this->post_text
        );


        return $attributes;
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

		$criteria->compare('post_type', 'answer');

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
            'answers'=>array(
                'condition'=>"post_type='answer'",
            )
        );
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
     * @param array $parameters
     * @return string
     */
    public function getUrl($parameters = array())
    {
    	return Yii::app()->createUrl('//questionanswer/question/view', $parameters);
    }

    /**
     * Returns the Search Result Output
     */
    public function getSearchResult()
    {
        return Yii::app()->getController()->widget('application.modules.questionanswer.widgets.AnswerSearchResultWidget', array('question' => Question::model()->findByPk($this->question_id), 'answer' => $this), true);
    }
}
