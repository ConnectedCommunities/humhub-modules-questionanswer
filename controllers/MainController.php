<?php

class MainController extends Controller{

	public function init() {
        return parent::init();
	}
	
    public function actionIndex(){
        $this->render('index', array('questions' => Question::model()->findAll(array('order'=>'created_at DESC'))));
    }

    public function actionAnswer() {
    	$this->render('answer');
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
	        	echo "Saved";
	        	$model->save();
	            return;
	        }
	    }
	    $this->render('new_question',array('model'=>$model));
	}

}