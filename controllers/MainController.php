<?php

class MainController extends Controller{

	public function init() {
        return parent::init();
	}
	
    public function actionIndex(){
        $this->render('index');
    }

    public function actionAnswer() {
    	$this->render('answer');
    }

	public function actionAsk() {

	    // $model=new Question;

	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='question-ask-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */

	    if(isset($_POST['question']))
	    {
	    	error_reporting(E_ALL); 
			ini_set("display_errors", 1); 

	    	echo "H";

			$model = new Question();
			$model->post_type = "question";
			$model->post_title = $_POST['post_title'];
			$model->post_text = $_POST['post_text'];
			

	    	echo "Yes";
	        $model->attributes=$_POST['question'];
	        print_r($model);
	        if($model->validate())
	        {
	            // form inputs are valid, do something here
	            echo "It worked!";
	            exit();
	            return;
	        }
	    }

	    $this->render('ask', array('model' => ""));
	}

	public function actionNew_question()
	{

	    $model=new Question;

	    if(isset($_POST['Question']))
	    {
	        $model->attributes=$_POST['Question'];
	        if($model->validate())
	        {
	        	$model->save();
	            return;
	        }
	    }
	    $this->render('new_question',array('model'=>$model));
	}

}