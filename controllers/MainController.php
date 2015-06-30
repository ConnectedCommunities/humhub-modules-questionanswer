<?php

class MainController extends Controller{

	public function init() {
        return parent::init();
	}
	
    public function actionIndex(){
		
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

        $this->render('index', array(
        	'questions' => Question::model()->findAll(array('order'=>'created_at DESC')),
        	'question_stats' => $question_stats
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

    	$answers = Answer::model()->question($question->id)->answers()->findAll();
    	$rawComments = Comment::model()->question($question->id)->findAll(); // order by question_id, time desc

    	// Map comments into an array with the key matching the answer id
    	$comments = array();
    	foreach($rawComments as $comment) {
    		if($comment->question_id != null) $comments[$comment->parent_id][] = $comment;
    	}

    	$this->render('view', array(
    		'question' => $question,
    		'answers' => $answers,
    		'model' => $model,
    		'answerModel' => $answerModel,
    		'commentModel' => $commentModel,
    		'comments' => $comments
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

}