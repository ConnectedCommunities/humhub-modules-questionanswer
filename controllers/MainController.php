<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
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
 *
 *
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.org/licences GNU AGPL v3
 *
 */

namespace humhub\modules\questionanswer\controllers;

use humhub\components\Controller;
use humhub\models\Setting;
use humhub\modules\comment\models\Comment;
use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\QuestionVotes;
use yii\helpers\Url;
use humhub\modules\questionanswer\models\Tag;
use Yii;

class MainController extends Controller
{

	public function init() {
        return parent::init();
	}
	

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
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
                'users' => array('@', (Setting::Get('allowGuestAccess', 'authentication_internal')) ? "?" : "@"),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


	/** 
	 * Index
	 * Shows the index page and handles
	 * a vote being cast
	 */
    public function actionIndex()
	{
		
    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 

		// User has just voted on a question
		$questionVotesModel = new QuestionVotes;
	    if(isset($_POST['QuestionVotes']))
	    {
	    	$questionVotesModel->attributes=$_POST['QuestionVotes'];
	    	QuestionVotes::model()->castVote($questionVotesModel, $questionVotesModel->post_id);
            $this->redirect(Url::toRoute('//questionanswer/main/index'));
	    }


        $this->render('index', array(
        	'questions' => Question::model()->overview(),
        ));
        
    }

    /** 
     * Controller action for viewing a questions.
     * Also provides functionality for creating an answer,
     * adding a comment and voting.
     */
    public function actionView() {

    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 
    	
    	$question = Question::findOne(Yii::$app->request->getParam('id'));

    	if(isset($_POST['Answer'])) {
			
			$answerModel = new Answer();
	        $answerModel->attributes=$_POST['Answer'];
	        $answerModel->created_by = Yii::$app->user->id;
	        $answerModel->post_type = "answer";
	        $answerModel->question_id = $question->id;

	        if($answerModel->validate())
	        {
	            $answerModel->save();
				Url::toRoute($this->createUrl('//questionanswer/main/view', array('id' => $question->id)));
	        }
    	}


    	if(isset($_POST['Comment'])) {
        	
        	$commentModel = new Comment();
	        $commentModel->attributes=$_POST['Comment'];
	        $commentModel->created_by = Yii::$app->user->id;
	        $commentModel->post_type = "comment";
	        $commentModel->question_id = $question->id;

	        if($commentModel->validate())
	        {
	            $commentModel->save();
	            $this->redirect(Url::toRoute('//questionanswer/main/view', array('id' => $question->id)));
	        }

    	}

		// User has just voted on a question
	    if(isset($_POST['QuestionVotes']))
	    {

	    	$questionVotesModel = new QuestionVotes;
	    	$questionVotesModel->attributes = $_POST['QuestionVotes'];
	    	QuestionVotes::model()->castVote($questionVotesModel, $question->id);

	    }

    	$this->render('view', array(
    		'author' => $question->user->id,
    		'question' => $question,
    		'answers' => Answer::model()->overview($question->id),
    		'related' => Question::model()->related($question->id),
    	));

    }
    
	public function actionAnswer()
	{
    	// do nothing
	}

	/** 
	 * Method to show the views for 
	 * asking a new question and actually
	 * creating the new question
	 */
	public function actionNew_question()
	{

    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 

	    $model = new Question;
        $model->created_by = Yii::$app->user->id;
        $model->post_type = "question";
	    
	    if(isset($_POST['Question'])) {
	    	
	        $model->attributes=$_POST['Question'];
	        if($model->validate()) {

	        	$model->save();

	        	// Question has been saved, add the tags
				if(isset($_POST['Tags'])) {

					// Split tag string into array 
					$tags = explode(", ", $_POST['Tags']);
					foreach($tags as $tag) {
						$tag = Tag::model()->firstOrCreate($tag);
						$question_tag = new QuestionTag;
						$question_tag->question_id = $model->id;
						$question_tag->tag_id = $tag->id;
						$question_tag->save();
					}

				} else {
					// throw error(?) no tag provided
				}
			    
        	    $this->redirect(Url::toRoute('//questionanswer/main/view', array('id' => $model->id)));
	        }
	    }

	    $this->render('new_question',array('model'=>$model));
	}


	/** 
	 * Method for handling the user
	 * voting on a question or answer
	 */
	public function actionVote()
	{
	    $model=new QuestionVotes;

	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='question-votes-vote-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::$app->end();
	    }
	    */

	    if(isset($_POST['QuestionVotes']))
	    {
	        $model->attributes=$_POST['QuestionVotes'];
            $model->created_by = Yii::$app->user->id;
        	
	        if($model->validate())
	        {
	            // form inputs are valid, do something here
	            $model->save();
	            return;
	        }
	    }
	    $this->render('vote',array('model'=>$model));
	}


	/** 
	 * Controller for viewing a
	 * tag and loading up all questions
	 * from within that tag
	 */
    public function actionTag() {
		
    	error_reporting(E_ALL); 
		ini_set("display_errors", 1);
    	$tag = Tag::findOne(Yii::$app->request->get('id'));

    	// Find all questions with that tag
		$questions = Question::find()->joinWith("tags")->andWhere(['tag_id' => $tag->id])->all();

		// User has just voted on a question
		$questionVotesModel = new QuestionVotes();
	    if(isset($_POST['QuestionVotes']))
	    {
	        $questionVotesModel->attributes=$_POST['QuestionVotes'];
            $questionVotesModel->created_by = Yii::$app->user->id;
        	
	        if($questionVotesModel->validate())
	        {

	        	// TODO: If the user has previously voted on this, drop it 
	        	$previousVote = QuestionVotes::model()->find('post_id=:post_id AND created_by=:user_id', array('post_id' => $questionVotesModel->post_id, 'user_id' => Yii::$app->user->id));
	        	if($previousVote) $previousVote->delete();

	            $questionVotesModel->save();
	            $this->redirect(Url::toRoute('//questionanswer/main/index'));
	        }
	    }


        return $this->render('tags', array(
        	'tag' => $tag,
        	'questions' => Question::tag_overview($tag->id)
        ));
        
    }
}