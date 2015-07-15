<?php

class MainController extends Controller{

	public function init() {
        return parent::init();
	}
	
    public function actionIndex(){
		
    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 

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
        	'questions' => Question::model()->overview(),
        ));
        
    }

    public function actionView() {

    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 
    	
    	$question = Question::model()->findByPk(Yii::app()->request->getParam('id'));

    	if(isset($_POST['Answer'])) {
			
			$answerModel = new Answer;
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
        	
        	$commentModel = new Comment;
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
	    if(isset($_POST['QuestionVotes']))
	    {
	    	$questionVotesModel = new QuestionVotes;
	        $questionVotesModel->attributes=$_POST['QuestionVotes'];
            $questionVotesModel->created_by = Yii::app()->user->id;
        	
	        if($questionVotesModel->validate())
	        {


	        	// Is the author "voting" on the accepted answer?
	        	if($question->created_by == $questionVotesModel->created_by && $questionVotesModel->vote_type == "accepted_answer") {

		        	// If the user has previously selected a best answer, drop the old one
		        	$previousAccepted = QuestionVotes::model()->findAcceptedAnswer($question->id);
		        	if($previousAccepted) $previousAccepted->delete();

	        	} else { // no, just a normal up/down vote then

		        	// If the user has previously voted on this, drop it 
		        	$previousVote = QuestionVotes::model()->find('post_id=:post_id AND created_by=:user_id', array('post_id' => $questionVotesModel->post_id, 'user_id' => Yii::app()->user->id));
		        	if($previousVote) $previousVote->delete();

	        	}

	            $questionVotesModel->save();
	            $this->redirect($this->createUrl('//questionanswer/main/view', array('id' => $question->id)));
	        }
	    }

    	$this->render('view', array(
    		'author' => $question->user->id,
    		'question' => $question,
    		'answers' => Answer::model()->overview($question->id),
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

			    if(isset($_POST['Question']))
			    {
			    	
			        $model->attributes=$_POST['Question'];
			        if($model->validate())
			        {
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

		        	    $this->redirect($this->createUrl('//questionanswer/main/view', array('id' => $model->id)));
			        }
			    }
			    
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