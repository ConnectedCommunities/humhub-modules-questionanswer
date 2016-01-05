<?php


namespace humhub\modules\questionanswer\models;

use humhub\components\ActiveRecord;
use humhub\modules\content\components\ContentContainerActiveRecord;
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
//class Question extends HActiveRecordContentContainer implements ISearchable
class Question extends ContentActiveRecord implements Searchable
{

	use ReportContentTrait;

    /**
     * @inheritdoc
     */
	public $autoAddToWall = false;

    /**
     * @inheritdoc
     */
    public $wallEntryClass = "humhub\modules\questionanswer\widgets\QuestionWallEntryWidget";

    /**
     * @inheritdoc
     */
	public static function tableName()
	{
		return 'question';
	}

    /**
     * @inheritdoc
     */
	public function rules()
	{

        return [
            [['post_title', 'post_text', 'post_type'], 'required'],
            [['post_title', 'post_type'], 'string', 'max' => 255],
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
			'answers' => array(static::HAS_MANY, 'Answer', 'question_id'),
			'votes' => array(static::HAS_MANY, 'QuestionVotes', 'post_id'),
			'comments' => array(static::HAS_MANY, 'Comment', 'parent_id'),
			'tags'=>array(self::HAS_MANY, 'QuestionTag', 'question_id'),
		);
	}

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getAnswers()
    {
//        return $this->hasMany(Answer)
    }

	public function getTags()
	{
		return $this->hasMany(QuestionTag::class, ['question_id' => 'id']);
	}



	/**
	 * Returns the Wall Output
	 */
	public function getWallOut($params = [])
	{
		return Yii::app()->getController()->widget('application.modules.questionanswer.widgets.QuestionWallEntryWidget', array('question' => $this), true);
//		return "Hello World";
	}

	/**
	 * Returns an array of informations used by search subsystem.
	 * Function is defined in interface ISearchable
	 *
	 * @return Array
	 */
	public function getSearchAttributes()
	{

		// THIS WORKS PERFECTLY IF YOU ADD THE QUESTION MODEL TO THE QUERY
		// See: Line 84, /protected/controllers/SearchController.php


		$attributes = array(

			// Assignments
			'belongsToType' => 'Question',
			'belongsToId' => $this->id,
			'belongsToGuid' => $this->user->guid,

			// Information about the record
			'model' => 'Question',
			'pk' => $this->id,
			'title' => $this->post_title,
			'url' => $this->getUrl(array('id' => $this->id)),

			// Extra indexed fields
			'post_text' => $this->post_text
		);


		return $attributes;
	}


	/**
	 * Returns a title/text which identifies this IContent.
	 *
	 * e.g. Post: foo bar 123...
	 *
	 * @return String
	 */
	public function getContentTitle()
	{
		return Helpers::truncateText($this->post_title, 60);
	}


	/**
	 * Set default scope so that
	 * only questions are retrieved
	 */
	public function defaultScope()
	{
		return array(
			'alias' => $this->tableName(),
			'condition'=>"question.post_type='question'",
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
	 * Filters results by tag_id
	 * @param $tag_id
	 */
	public function tag($tag_id)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>"tag_id=:tag_id",
			'params' => array(':tag_id' => $tag_id)
		));

		return $this;
	}

	/**
	 * Returns URL to the Question
	 *
	 * @param array $parameters
	 * @return string
	 */
	public function getUrl($parameters = array())
	{
		return Url::toRoute(['question/view', $parameters]);
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

	/**
	 * Get stats on a question
	 * @param int $question_id
	 */
	public static function stats($question_id)
	{

		$sql = "SELECT q.id, q.post_title, q.post_text, q.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes
				FROM question q
				LEFT JOIN question_votes up ON (q.id = up.post_id AND up.vote_on = 'question' AND up.vote_type = 'up')
				LEFT JOIN question_votes down ON (q.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down')
				LEFT JOIN question answers ON (q.id = answers.question_id AND answers.post_type = 'answer')
				WHERE q.post_type = 'question'
				AND q.id = :question_id
				GROUP BY q.id
				ORDER BY score DESC, vote_count DESC";

		return Yii::$app->db->createCommand($sql)->bindValue('question_id', $question_id)->queryOne();


	}

	/**
	 * Returns a list of questions with stats for a tag
	 * @parma int $tag_id
	 */
	public static function tag_overview($tag_id)
	{

		// $list= Yii::app()->db->createCommand('select * from post where category=:category')->bindValue('category',$category)->queryAll();
		$sql = "SELECT q.id, q.post_title, q.post_text, q.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes
				FROM question_tag qt, question q
				LEFT JOIN question_votes up ON (q.id = up.post_id AND up.vote_on = 'question' AND up.vote_type = 'up')
				LEFT JOIN question_votes down ON (q.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down')
				LEFT JOIN question answers ON (q.id = answers.question_id AND answers.post_type = 'answer')
				WHERE q.post_type = 'question'
                AND qt.question_id = q.id 
                AND qt.tag_id = :tag_id
				GROUP BY q.id
				ORDER BY score DESC, vote_count DESC, q.created_at DESC";

		return Yii::$app->db->createCommand($sql)->bindValue('tag_id', $tag_id)->queryAll();

	}


	/**
	 * Returns a series of related questions
	 */
	public static function related($question_id) {

		$sql = "SELECT q.id, q.post_title, COUNT(*) FROM question q, question_tag qt
				WHERE q.ID = qt.question_id
				AND qt.tag_id IN (
					SELECT tag_id FROM question_tag WHERE question_id = :question_id
				) AND qt.question_id != :question_id
				GROUP BY qt.question_id
				ORDER BY COUNT(*) DESC
				LIMIT 0, 5";

		return Yii::$app->db->createCommand($sql)->bindValue('question_id', $question_id)->queryAll();

	}


	/**
	 * Returns a list of questions tailored to the user
	 */
	public function pickedForUser($user_id)
	{

		$criteria->select = "question.id, question.post_title, question.post_text, question.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes";

		$criteria->join = "LEFT JOIN question_votes up ON (question.id = up.post_id AND up.vote_on = 'question' AND up.vote_type = 'up')
							LEFT JOIN question_votes down ON (question.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down')
							LEFT JOIN question answers ON (question.id = answers.question_id AND answers.post_type = 'answer')";

		$criteria->group = "question.id";
		$criteria->having = "answers = 0";
		$criteria->order = "score DESC, vote_count DESC, question.created_at DESC";


		$sql = "SELECT *, COUNT(*) as tag_count
				FROM question q LEFT JOIN question_tag qt ON (q.id = qt.question_id)
				WHERE qt.tag_id IN (
					SELECT qt.tag_id
					FROM tag t, question_tag qt LEFT JOIN question q ON (qt.question_id = q.id)
					WHERE qt.tag_id = t.id
					AND t.tag != \"\"
					AND q.created_by = 4
					GROUP BY qt.tag_id
					ORDER BY COUNT(qt.tag_id) DESC, created_at DESC
				)
				GROUP BY q.id
				ORDER BY tag_count DESC";

		return Yii::app()->db->createCommand($sql)->bindValue('user_id', $user_id)->queryAll();

	}

	/**
	 * Returns the Search Result Output
	 */
	public function getSearchResult()
	{
		return Yii::app()->getController()->widget('application.modules.questionanswer.widgets.QuestionSearchResultWidget', array('question' => $this), true);
	}

	public function canWrite() {
		return true;
	}
}
