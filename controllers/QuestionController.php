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

namespace humhub\modules\questionanswer\controllers;

use humhub\models\Setting;
use humhub\modules\content\models\Content;
use humhub\modules\property\notifications\NewPropertyQuestion;
use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\Category;
use humhub\modules\questionanswer\models\Comment;
use humhub\modules\questionanswer\models\QuestionTag;
use humhub\modules\questionanswer\models\Tag;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\QuestionSearch;
use humhub\modules\reportcontent\models\ReportContent;
use humhub\modules\reportcontent\models\ReportReasonForm;
use humhub\modules\space\behaviors\SpaceModelModules;
use humhub\modules\user\models\User;
use Yii;
use humhub\modules\content\components\ContentContainerController;
use humhub\components\Controller;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\HttpException;

class QuestionController extends ContentContainerController
{

    /**
     * When set to true, content from all spaces
     * is combined into one view on the front page.
     *
     * When set to false, a Space acts as a category.
     * It removes the ability to post globally. The front
     * page changes to show the available categories.
     */
	public $useGlobalContentContainer = true;


    /**
     * We want the sidebar hidden,
     * this module has it's own sidebars
     *
     * @var bool
     */
	public $hideSidebar = true;

    /**
     * Handle initialisation.
     *
     * This module works globally and within a Space container
     * We do this so we can work around not having a content container.
     */
	public function init() {

        // Use content container set in settings, global by default
        if(Yii::$app->getModule('questionanswer')->settings->get('useGlobalContentContainer') == null || Yii::$app->getModule('questionanswer')->settings->get('useGlobalContentContainer') == 1) {
            $this->useGlobalContentContainer = true;
        } else {
            $this->useGlobalContentContainer = false;
        }

        // Expect exception from Content Container on global index page
        try {
            parent::init();
        } catch(HttpException $e) {
            // Do nothing.
        }

	}
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
     * Lists all models.
     */
    public function actionIndex()
    {

        $query = Question::find()
            ->andFilterWhere(['post_type' => 'question'])
            ->orderBy('created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        // Pass the content container to the query when available and not using the global content container
        if($this->contentContainer) {
            $query->contentContainer($this->contentContainer);
        }

        // Return the aggregated view when useGlobalContentContainer == false AND no content container found
        if(!$this->useGlobalContentContainer && !$this->contentContainer && !Yii::$app->request->get('mode') == "global") {
            return $this->render('aggregated_index', array(
                'groups' => Category::all(),
            ));
        }

        return $this->render('index', array(
            'contentContainer' => $this->contentContainer,
            'dataProvider' => $dataProvider,
            'searchModel' => $query,
            'model' => Question::find()
        ));

    }

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

            if($this->contentContainer) {
                $question->content->setContainer($this->contentContainer);
                $contentContainer = $this->contentContainer;
            } else {
                $containerClass = User::className();
                $contentContainer = $containerClass::findOne(['guid' => Yii::$app->getUser()->guid]);
                $question->content->container = $contentContainer;
            }


            if ($question->validate()) {

				// Save and Index the `content` object the search engine
				// NOTE: You could probably do this by adding in container->visibility yourself
				// NOTE2: it's also worth looking at doing this the right way and making Q&A a module
				//			which can be enabled on Spaces and Users.
				// 		This will free us from needing to do work arounds like below :)
				\humhub\modules\content\widgets\WallCreateContentForm::create($question, $contentContainer);
				$question->save();

                // Attach files
                $question->fileManager->attach(Yii::$app->request->post('fileList'));

                if(isset($_POST['Tags'])) {
                    // Split tag string into array
                    $tags = explode(", ", $_POST['Tags']);
                    foreach($tags as $tag) {
                        $tag = Tag::firstOrCreate($tag, $contentContainer);
						$question_tag = new QuestionTag();
                        $question_tag->question_id = $question->id;
                        $question_tag->tag_id = $tag->id;
                        $question_tag->save();
                    }
                }


                $this->redirect($question->getUrl());

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
			$this->redirect($model->getUrl());
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
	 * Find unanswered questions
	 */
	public function actionUnanswered()
	{

		$criteria = Question::find();
		$criteria->select("question.id, question.post_title, question.post_text, question.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes");
		$criteria->from(['content', 'question']);
		$criteria->join('LEFT JOIN', 'question_votes up', "question.id = up.post_id AND up.vote_on = 'question' AND up.vote_type='up'");
		$criteria->join('LEFT JOIN', 'question_votes down', "question.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down'");
		$criteria->join('LEFT JOIN', 'question answers', "question.id = answers.question_id AND answers.post_type = 'answer'");
		$criteria->where([
			'question.post_type' => 'question'
		]);

		// Apply content filter to results
		if($this->contentContainer && $this->useGlobalContentContainer == false) {
            $criteria->from(['content', 'contentcontainer', 'question']);
            $criteria->andWhere('contentcontainer.id = content.contentcontainer_id');
            $criteria->andWhere(["like", "contentcontainer.class", "humhub\\modules\\space\\models\\Space"]);
            $criteria->andWhere([
                "contentcontainer.pk" => $this->contentContainer->id,
            ]);

			$criteria->andWhere('content.object_id = question.id');
			$criteria->andWhere(['like', 'content.object_model', "humhub\\modules\\questionanswer\\models\\Question"]);

		}

		$criteria->groupBy("question.id");
		$criteria->having("answers = 0");
		$criteria->orderBy("score DESC, vote_count DESC, question.created_at DESC");

		$dataProvider = new ActiveDataProvider([
			'query' => $criteria,
		]);

		return $this->render('index',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function actionPicked()
	{

		// Apply content filter to results
		if($this->contentContainer && $this->useGlobalContentContainer == false) {
            $criteria = "AND contentcontainer.id = content.contentcontainer_id 
                        AND contentcontainer.class LIKE 'humhub\\\\\\\\modules\\\\\\\\space\\\\\\\\models\\\\\\\\Space'
                        AND contentcontainer.pk = " . $this->contentContainer->id;
            $criteriaFrom = ", contentcontainer";
		} else {
            $criteria = "";
            $criteriaFrom = "";
		}

		$sql = 'SELECT question.id, question.post_title, question.post_text, question.post_type, COUNT(*) as tag_count
				FROM content ' . $criteriaFrom . ', question
				LEFT JOIN question_tag ON (question.id = question_tag.question_id)
				WHERE (content.object_id = question.id AND content.object_model LIKE "humhub\\\\\\\\modules\\\\\\\\questionanswer\\\\\\\\models\\\\\\\\Question" '. $criteria .')
				AND question_tag.tag_id IN (
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
				)
				';



		$foo = Yii::$app->db->createCommand($sql)->bindValue('user_id',  Yii::$app->user->id)->getSql();
		$bar = Question::findBySql($sql, ['user_id' => Yii::$app->user->id]);

		$dataProvider = new ActiveDataProvider([
			'query' => $bar,
		]);

		return $this->render('index',array(
			'dataProvider'=>$dataProvider,
			'contentContainer'=>$this->contentContainer,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

		$query = Question::find()
			->andFilterWhere(['post_type' => 'question'])
			->orderBy('created_at DESC');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		// Pass the content container to the query when available and not using the global content container
		if($this->contentContainer && $this->useGlobalContentContainer == false) {
			$query->contentContainer($this->contentContainer);
		}

		return $this->render('admin', array(
			'dataProvider' => $dataProvider,
			'searchModel' => $query,
			'model' => Question::find()
		));



	}

	/**
	 * Report content using reportcontent module
	 */
	public function actionReport()
	{

		$this->forcePostRequest();

		Yii::$app->response->format = 'json';

		$json = array();
		$json['success'] = false;

		// Only run if the reportcontent module is available
		if(isset(Yii::$app->modules['reportcontent'])) {

			$form = new ReportReasonForm();
			if ($form->load(Yii::$app->request->post()) && $form->validate() && Question::findOne(['id' => $form->object_id])->canReportPost()) {
				$report = new ReportContent();
				$report->created_by = Yii::$app->user->id;
				$report->reason = $form->reason;
				$report->object_model = Question::className();
				$report->object_id = $form->object_id;

				if ($report->save()) {
					$json['success'] = true;
				}
			}

		}
		return $json;

	}


	/**
	 * Controller for viewing a
	 * tag and loading up all questions
	 * from within that tag
	 */
	public function actionTag() {

		$tag = Tag::findOne(['id' => Yii::$app->request->get('id')]);

		// Apply content filter to results
		if($this->contentContainer && $this->useGlobalContentContainer == false) {
			$container = $this->contentContainer;
		} else {
			$container = null;
		}


		return $this->render('tags', array(
			'tag' => $tag,
            'container' => $container,
			'questions' => Question::tag_overview($tag->id, $container)
		));

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
