<?php

namespace humhub\modules\questionanswer\controllers;

use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\QuestionTag;
use humhub\modules\questionanswer\models\Tag;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\QuestionSearch;
use humhub\modules\user\models\User;
use Yii;
//use humhub\modules\content\components\ContentContainerController;
use humhub\components\Controller;
use yii\helpers\Url;

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
                'guestAllowedActions' => ['index', 'view']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    /*public function actions()
    {
        return array(
            'stream' => array(
                'class' => \humhub\modules\content\components\actions\ContentContainerStream::className(),
                'mode' => \humhub\modules\content\components\actions\ContentContainerStream::MODE_NORMAL,
                'contentContainer' => $this->getUser()
            ),
        );
    }*/


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);

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

            $question->load(Yii::$app->request->post());
            $question->post_type = "question";

            $containerClass = User::className();
            $contentContainer = $containerClass::findOne(['guid' => Yii::$app->getUser()->guid]);
            $question->content->container = $contentContainer;

            if ($question->validate()) {

                $question->save();

                if(isset($_POST['Tags'])) {
                    // Split tag string into array
                    $tags = explode(", ", $_POST['Tags']);
                    foreach($tags as $tag) {

                        $tag = Tag::firstOrCreate($tag);
                        $question_tag = new QuestionTag();
                        $question_tag->question_id = $question->id;
                        $question_tag->tag_id = $tag->id;
                        $question_tag->save();
                    }
                }


                $this->redirect(Url::toRoute(['question/view', 'id' => $question->id]));

            }

        }

		return $this->render('create',array(
			'model'=>$question,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		
		$id = Yii::$app->request->get('id');
		$model = Question::findOne(['id' => $id]);

		$model->content->object_model = Question::class;
		$model->content->object_id = $model->id;

		$containerClass = User::className();
		$contentContainer = $containerClass::findOne(['guid' => Yii::$app->getUser()->guid]);
		$model->content->container = $contentContainer;

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		// TODO: Use below. 
		// This will produce the same results as Question::model->overview()
		// our current implementation does a handful of additional queries 
		// from within the view to load up question info
		/*
		$criteria=new CDbCriteria;
		$criteria->select = "question.id, question.post_title, question.post_text, question.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes";

		$criteria->join = "LEFT JOIN question_votes up ON (question.id = up.post_id AND up.vote_on = 'question' AND up.vote_type = 'up')
							LEFT JOIN question_votes down ON (question.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down')
							LEFT JOIN question answers ON (question.id = answers.question_id AND answers.post_type = 'answer')";

		$criteria->group = "question.id";
		$criteria->order = "question.created_at DESC, score DESC, vote_count DESC";

		$dataProvider=new CActiveDataProvider('Question', array(
			'criteria'=>$criteria
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/

		/*$dataProvider=new CActiveDataProvider('Question', array(
			'criteria'=>array(
				'order'=>'created_at DESC',
			)
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/

        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'created_at' => [
                    'default' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('index', array(
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => Question::find()
        ));



    }

	/** 
	 * Find unanswered questions
	 */
	public function actionUnanswered()
	{

		$criteria=new CDbCriteria;
		$criteria->select = "question.id, question.post_title, question.post_text, question.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes";

		$criteria->join = "LEFT JOIN question_votes up ON (question.id = up.post_id AND up.vote_on = 'question' AND up.vote_type = 'up')
							LEFT JOIN question_votes down ON (question.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down')
							LEFT JOIN question answers ON (question.id = answers.question_id AND answers.post_type = 'answer')";

		$criteria->group = "question.id";
		$criteria->having = "answers = 0";
		$criteria->order = "score DESC, vote_count DESC, question.created_at DESC";

		$dataProvider=new CActiveDataProvider('Question', array(
			'criteria'=>$criteria
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function actionPicked()
	{
		$criteria=new CDbCriteria;
        $criteria->select = "question.id, question.post_title, question.post_text, question.post_type, COUNT(*) as tag_count";

		$criteria->join = "LEFT JOIN question_tag ON (question.id = question_tag.question_id)";

        $criteria->addCondition('question_tag.tag_id IN (
                                        SELECT id as tag_id FROM (
                                            SELECT tag.id
                                            FROM tag, question_votes, question
                                            LEFT JOIN question_tag ON (question.id = question_tag.question_id)
                                            WHERE question_votes.post_id = question.id
                                            AND question_tag.tag_id = tag.id
                                            AND tag.tag != ""
                                            AND question_votes.vote_on = "question"
                                            AND question_votes.vote_type = "up"
                                            AND question_votes.created_by = :user_id

                                            UNION ALL

                                            SELECT tag.id
                                            FROM tag, question_tag LEFT JOIN question ON (question_tag.question_id = question.id)
                                            WHERE question_tag.tag_id = tag.id
                                            AND tag.tag != ""
                                            AND question.created_by = :user_id
                                        ) as c
                                        GROUP BY id
                                        ORDER BY COUNT(tag_id) DESC, question.created_at DESC
                                    )');
        $criteria->params = array(
            ':user_id'=> Yii::app()->user->id
        );

		$criteria->group = "question.id";
		$criteria->order = "tag_count DESC";

		$dataProvider=new CActiveDataProvider('Question', array(
            'criteria'=>$criteria
		));


		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Question('search');
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
        if(isset(Yii::app()->modules['reportcontent'])) {

            $form = new ReportReasonForm();

            if (isset($_POST['ReportReasonForm'])) {
                $_POST['ReportReasonForm'] = Yii::app()->input->stripClean($_POST['ReportReasonForm']);
                $form->attributes = $_POST['ReportReasonForm'];

                if ($form->validate() && Question::model()->findByPk($form->object_id)->canReportPost()) {

                    $report = new ReportContent();
                    $report->created_by = Yii::app()->user->id;
                    $report->reason = $form->reason;
                    $report->object_model = 'Question';
                    $report->object_id = $form->object_id;

                    $report->save();

                    $json['success'] = true;
                }
            }

        }

		echo CJSON::encode($json);
		Yii::app()->end();
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
		$model=Question::findOne(['id' => $id]);
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
			Yii::app()->end();
		}
	}
}
