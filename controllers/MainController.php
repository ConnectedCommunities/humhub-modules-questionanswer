<?php

class MainController extends Controller{

	public function init() {
        return parent::init();
	}
	
    public function actionIndex(){
        $this->render('index', array('questions' => Question::model()->findAll(array('order'=>'created_at DESC'))));
    }

    public function actionView() {

    	error_reporting(E_ALL); 
		ini_set("display_errors", 1); 
	    $model = new Question;
    	$answerModel = new Answer;
    	
    	$question = Question::model()->findByPk(Yii::app()->request->getParam('id'));
    	
    	if(isset($_POST['Answer'])) {

	        $answerModel->attributes=$_POST['Answer'];
	        $answerModel->created_by = 1;
	        $answerModel->post_type = "answer";
	        $answerModel->question_id = $question->id;

	        if($answerModel->validate())
	        {
	            // form inputs are valid, do something here
	            $answerModel->save();
	            echo "Saved!";
	            return;
	        }
    	}

    	$this->render('view', array(
    		'question' => $question,
    		'model' => $model,
    		'answerModel' => $answerModel
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
        $model->created_by = 1;
        $model->post_type = "question";
	    
	    if(isset($_POST['Question']))
	    {
	        $model->attributes=$_POST['Question'];
	        if($model->validate())
	        {
	        	$model->save();
	        	$this->redirect(Yii::app()->createUrl('//questionanswer/main/index'));
	            return;
	        }
	    }
	    $this->render('new_question',array('model'=>$model));
	}

}