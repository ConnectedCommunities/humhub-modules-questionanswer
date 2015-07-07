<?php

class MainController extends Controller{

	public function init() {
        return parent::init();
	}
	
    public function actionIndex(){
		
    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 

		// Query to get the question stats
		$question_stats_command = Yii::app()->db->createCommand()
		    ->select('question_id, post_type, COUNT(*) as count')
		    ->from('question q')
		    ->where('post_type != "question"')
		    ->group('question_id, post_type');

		// Map question stats into an array with the key as the id
		$question_stats = array();
		foreach($question_stats_command->queryAll() as $stat) {
			$question_stats[$stat['question_id']][$stat['post_type']] = $stat['count'];
		}

		// Query the user's vote history
		$question_vote_stats_command = Yii::app()->db->createCommand()
			->select('post_id, created_by, vote_on, vote_type, count(*) as count')
			->from('question_votes qv') 
			->where('vote_on = "question"')
			->group('post_id, vote_type');

		// Create an array containing the questions the user has voted on
		$user_voted_on = array();

		// Store users votes so we can show them what they voted on
		$user_vote_history = array();

		// Map question vote stats into an array with the keu as the id
		$question_vote_stats = array();

		// Keep a total of votes
		$total = 0;

		foreach($question_vote_stats_command->queryAll() as $stat) {
			
			if(!isset($question_vote_stats[$stat['post_id']][$stat['vote_on']]['total']))
				$question_vote_stats[$stat['post_id']][$stat['vote_on']]['total'] = $stat['count'];
			else 
				$question_vote_stats[$stat['post_id']][$stat['vote_on']]['total'] += $stat['count'];

			
			$total = $total + $stat['count'];

			$question_vote_stats[$stat['post_id']][$stat['vote_on']][$stat['vote_type']] = $stat['count'];
			$question_vote_stats[$stat['post_id']][$stat['vote_on']]['total'] = $total;
			
			if(!in_array($stat['post_id'], $user_voted_on) && $stat['created_by'] == Yii::app()->user->id) {
				$user_voted_on[] = $stat['post_id'];
			}

			if($stat['created_by'] == Yii::app()->user->id) {
				$user_vote_history[$stat['post_id']][$stat['vote_on']] = $stat['vote_type'];
			}
		}

		// User has just voted on a question
		$questionVotesModel = new QuestionVotes;
	    if(isset($_POST['QuestionVotes']))
	    {
	        $questionVotesModel->attributes=$_POST['QuestionVotes'];
            $questionVotesModel->created_by = Yii::app()->user->id;
        	
	        if($questionVotesModel->validate())
	        {

	        	// TODO: If the user has previously voted on this, drop it 
	        	$previousVote = QuestionVotes::model()->find('post_id=:post_id AND created_by=:user_id', array('post_id' => $questionVotesModel->post_id, 'user_id' => Yii::app()->user->id));
	        	if($previousVote) $previousVote->delete();

	            $questionVotesModel->save();
	            $this->redirect($this->createUrl('//questionanswer/main/index'));
	        }
	    }

        $this->render('index', array(
        	'questions' => Question::model()->findAll(array('order'=>'created_at DESC')),
        	'question_stats' => $question_stats,
        	'question_vote_stats' => $question_vote_stats,
        	'user_vote_history' => $user_vote_history,
        	'user_voted_on' => $user_voted_on
        ));
    }

    public function actionView() {

    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 
	    
	    $model = new Question;
    	$answerModel = new Answer;
    	$commentModel = new Comment;

    	$question = Question::model()->findByPk(Yii::app()->request->getParam('id'));
    	
    	if(isset($_POST['Answer'])) {

	        $answerModel->attributes=$_POST['Answer'];
	        $answerModel->created_by = Yii::app()->user->id;
	        $answerModel->post_type = "answer";
	        $answerModel->question_id = $question->id;

	        if($answerModel->validate())
	        {
	            $answerModel->save();
	            $this->redirect($this->createUrl('//questionanswer/main/view', array('id' => $question->id)));
	        }
    	}


    	if(isset($_POST['Comment'])) {
	        
	        $commentModel->attributes=$_POST['Comment'];
	        $commentModel->created_by = Yii::app()->user->id;
	        $commentModel->post_type = "comment";
	        $commentModel->question_id = $question->id;

	        if($commentModel->validate())
	        {
	            $commentModel->save();
	            $this->redirect($this->createUrl('//questionanswer/main/view', array('id' => $question->id)));
	        }

    	}

		// User has just voted on a question
		$questionVotesModel = new QuestionVotes;
	    if(isset($_POST['QuestionVotes']))
	    {
	        $questionVotesModel->attributes=$_POST['QuestionVotes'];
            $questionVotesModel->created_by = Yii::app()->user->id;
        	
	        if($questionVotesModel->validate())
	        {

	        	// TODO: If the user has previously voted on this, drop it 
	        	$previousVote = QuestionVotes::model()->find('post_id=:post_id AND created_by=:user_id', array('post_id' => $questionVotesModel->post_id, 'user_id' => Yii::app()->user->id));
	        	if($previousVote) $previousVote->delete();

	            $questionVotesModel->save();
	            $this->redirect($this->createUrl('//questionanswer/main/index'));
	        }
	    }

    	$answers = Answer::model()->question($question->id)->answers()->findAll();
    	$rawComments = Comment::model()->question($question->id)->findAll(); // order by question_id, time desc

    	// Map comments into an array with the key matching the answer id
    	$comments = array();
    	foreach($rawComments as $comment) {
    		if($comment->question_id != null) $comments[$comment->parent_id][] = $comment;
    	}


		// Query the user's vote history
		$question_vote_stats_command = Yii::app()->db->createCommand()
			->select('post_id, created_by, vote_on, vote_type, count(*) as count')
			->from('question_votes qv') 
			->group('post_id, vote_type');

		// Create an array containing the questions the user has voted on
		$user_voted_on = array();

		// Store users votes so we can show them what they voted on
		$user_vote_history = array();

		// Map question vote stats into an array with the keu as the id
		$question_vote_stats = array();

		foreach($question_vote_stats_command->queryAll() as $stat) {
			
			$question_vote_stats[$stat['post_id']][$stat['vote_on']][$stat['vote_type']] = $stat['count'];
			
			if(!isset($question_vote_stats[$stat['post_id']][$stat['vote_on']]['total']))
				$question_vote_stats[$stat['post_id']][$stat['vote_on']]['total'] = $stat['count'];
			else 
				$question_vote_stats[$stat['post_id']][$stat['vote_on']]['total'] += $stat['count'];

			
			if(!in_array($stat['post_id'], $user_voted_on) && $stat['created_by'] == Yii::app()->user->id) {
				$user_voted_on[] = $stat['post_id'];
			}

			if($stat['created_by'] == Yii::app()->user->id) {
				$user_vote_history[$stat['post_id']][$stat['vote_on']] = $stat['vote_type'];
			}
		}

    	$this->render('view', array(
    		'author' => '',
    		'question' => $question,
    		'answers' => $answers,
    		'model' => $model,
    		'answerModel' => $answerModel,
    		'commentModel' => $commentModel,
    		'comments' => $comments,
        	'question_vote_stats' => $question_vote_stats,
        	'user_vote_history' => $user_vote_history,
        	'user_voted_on' => $user_voted_on
    	));

    }
    
	public function actionAnswer()
	{
    	// do nothing
	}

	public function actionNew_question()
	{

    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 

	    $model = new Question;
        $model->created_by = Yii::app()->user->id;
        $model->post_type = "question";
	    
	    if(isset($_POST['Question']))
	    {
	        $model->attributes=$_POST['Question'];
	        if($model->validate())
	        {
	        	$model->save();
        	    $this->redirect($this->createUrl('//questionanswer/main/view', array('id' => $model->id)));
	        }
	    }

	    $this->render('new_question',array('model'=>$model));
	}


	public function actionVote()
	{
	    $model=new QuestionVotes;

	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='question-votes-vote-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */

	    if(isset($_POST['QuestionVotes']))
	    {
	        $model->attributes=$_POST['QuestionVotes'];
            $model->created_by = Yii::app()->user->id;
        	
	        if($model->validate())
	        {
	            // form inputs are valid, do something here
	            $model->save();
	            return;
	        }
	    }
	    $this->render('vote',array('model'=>$model));
	}
}