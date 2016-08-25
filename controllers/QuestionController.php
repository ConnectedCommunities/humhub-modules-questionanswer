<?php

namespace humhub\modules\questionanswer\controllers;
use humhub\modules\content\components\ContentAddonController;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\content\controllers\ContentController;
use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\QuestionTag;
use humhub\modules\questionanswer\models\Tag;
use Yii;

use humhub\models\Setting;
use humhub\components\Controller;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use humhub\modules\content\models\Content;

class QuestionController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'acl' => [
				'class' => \humhub\components\behaviors\AccessControl::className(),
			]
		];
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => ('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = Question::find()->joinWith(['tags'])->andWhere(['question.id'=> $id])->one();
		if(empty($model->user)) {
			$this->redirect(Yii::$app->request->referrer);
		}

		Question::setViewQuestion($id);
		return $this->render('view',array(
    		'author' => $model->user->id,
    		'question' => $model,
    		'answers' => Answer::overview($model->id),
    		'related' => Question::related($model->id),
			'model'=> $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $question = new Question();
        if(isset($_POST['Question'])) {

			$this->forcePostRequest();

			$question->load(Yii::$app->request->post());
			$question->post_type = "question";
			if($question->validate()) {
				$question->save();

				\humhub\modules\file\models\File::attachPrecreated($question, Yii::$app->request->post('fileList'));
			} else {
				echo json_encode(
					[
						'flag' => true,
						'errors' => $this->implodeAssocArray($question->getErrors()),
					]
				);
				Yii::$app->end();
			}


			if (isset($_POST['Tags'])) {

				// Split tag string into array
				$tags = explode(", ", $_POST['Tags']);
				foreach ($tags as $tag) {
					$tagObj = new Tag();
					$tagObj = $tagObj->firstOrCreate($tag);
					$question_tag = new QuestionTag();
					$question_tag->question_id = $question->id;
					$question_tag->tag_id = $tagObj->id;
					$question_tag->save();
				}

			}
			echo json_encode(
				[
					'flag' => false,
					'location' => Url::toRoute(['//questionanswer/question/view', 'id' => $question->getPrimaryKey()]),
				]
			);
			Yii::$app->end();
		}
	}

	protected function implodeAssocArray($array)
	{
		$string = "<div class='errorsQuestion'>";
			if(is_array($array) && !empty(array_filter($array))) {
				foreach ($array as $key => $value) {
					foreach ($value as $item) {
						$string.=  $item . "<br />";
					}
				}
			}
		$string.="</div>";

		return $string;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		return $this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['/questionanswer/question/index']);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$limit = 10;
		$question = new Question;
		$dataProvider=new ActiveDataProvider([
			'query' => Question::find()->andWhere(['post_type' => 'question']),
			'pagination' => [
				'pageSize' => $limit,
			],
		]);

		$getAllQuestion = Question::find()->all();
		$resultSearchData = ArrayHelper::map($getAllQuestion, "id" , "post_title");
//		var_dump($resultSearchData);die;
		return $this->render('index',array(
			'dataProvider'=>$dataProvider,
			'question' => $question,
			'resultSearchData' => json_encode($resultSearchData),
		));
		
	}

	/** 
	 * Find unanswered questions
	 */
	public function actionUnanswered()
	{
		$sql = "SELECT question.id, question.post_title, question.post_text, question.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes
				FROM question
					LEFT JOIN question_votes up ON (question.id = up.post_id AND up.vote_on = 'question' AND up.vote_type = 'up')
					LEFT JOIN question_votes down ON (question.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down')
					LEFT JOIN question answers ON (question.id = answers.question_id AND answers.post_type = 'answer')
				WHERE question.post_type = 'question'
				GROUP BY question.id
				HAVING answers = 0
				ORDER BY score DESC, vote_count DESC, question.created_at DESC
				";

		$limit = 10;
		$dataProvider=new SqlDataProvider([
			'sql' => $sql,
			'pagination' => [
				'pageSize' => $limit,
			],
		]);

		$question = new Question;
		$getAllQuestion = Question::find()->all();
		$resultSearchData = ArrayHelper::getColumn($getAllQuestion, ["id" => "post_title"]);
		return $this->render('index', array(
			'dataProvider'=>$dataProvider,
			'question' => $question,
			'resultSearchData' => json_encode($resultSearchData),
		));

	}

	public function actionPicked()
	{
		$sql = "SELECT question.id, question.post_title, question.post_text, question.post_type, COUNT(*) as tag_count 
				FROM question 
				LEFT JOIN question_tag 
					ON (question.id = question_tag.question_id)
				WHERE
				question.post_type = 'question'
				AND
				question_tag.tag_id IN (
                                        SELECT id as tag_id FROM (
                                            SELECT tag.id
                                            FROM tag, question_votes, question
                                            LEFT JOIN question_tag ON (question.id = question_tag.question_id)
                                            WHERE question_votes.post_id = question.id
                                            AND question_tag.tag_id = tag.id
                                            AND tag.tag != \"\"
                                            AND question_votes.vote_on = \"question\"
                                            AND question_votes.vote_type = \"up\"
                                            AND question_votes.created_by = :user_id

                                            UNION ALL

                                            SELECT tag.id
                                            FROM tag, question_tag LEFT JOIN question ON (question_tag.question_id = question.id)
                                            WHERE question_tag.tag_id = tag.id
                                            AND tag.tag != \"\"
                                            AND question.created_by = :user_id
                                        ) as c
                                        GROUP BY id
                                        ORDER BY COUNT(tag_id) DESC, question.created_at DESC
                                    )
				GROUP BY question.id
				
				ORDER BY tag_count DESC";
		$limit = 10;
		$dataProvider=new SqlDataProvider([
			'sql' => $sql,
			'params' => [':user_id' => Yii::$app->user->id],
			'pagination' => [
				'pageSize' => $limit,
			],
		]);

		$question = new Question;
		$getAllQuestion = Question::find()->all();
		$resultSearchData = ArrayHelper::getColumn($getAllQuestion,[ "id" => "post_title"]);
		return $this->render('index',array(
			'dataProvider'=>$dataProvider,
			'question' => $question,
			'resultSearchData' => json_encode($resultSearchData),
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		return $this->redirect(Url::toRoute(['/questionanswer/question/index']));

		$model= new Question('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Question']))
			$model->attributes=$_GET['Question'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Report content using reportcontent module
	 */
	public function actionReport()
	{

        $this->forcePostRequest();

        $json = array();
        $json['success'] = false;

        // Only run if the reportcontent module is available
        if(isset(Yii::$app->modules['reportcontent'])) {

            $form = new ReportReasonForm();

            if (isset($_POST['ReportReasonForm'])) {
                $_POST['ReportReasonForm'] = Yii::$app->input->stripClean($_POST['ReportReasonForm']);
                $form->attributes = $_POST['ReportReasonForm'];

                if ($form->validate() && Question::model()->findByPk($form->object_id)->canReportPost()) {

                    $report = new ReportContent();
                    $report->created_by = Yii::$app->user->id;
                    $report->reason = $form->reason;
                    $report->object_model = 'Question';
                    $report->object_id = $form->object_id;

                    $report->save();

                    $json['success'] = true;
                }
            }

        }

		echo CJSON::encode($json);
		Yii::$app->end();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Question the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model= Question::findOne($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Question $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
		{
			echo CActiveForm::validate($model);
			Yii::$app->end();
		}
	}

	public function actionGetSearch()
	{
		$findData = CHtml::listData(Question::model()->findAll('post_type="question"'),"id", "post_title");
		echo json_encode($findData);
	}

	public function actionGetLocationOneSelectItem()
	{
		$text = $_POST['text'];

		$question = Question::find()->andFilterWhere(["post_title" => $text ])->one();
		if(!empty($question)) {
			echo Url::toRoute(array('//questionanswer/question/view', 'id' => $question->id));
		}
	}
}
