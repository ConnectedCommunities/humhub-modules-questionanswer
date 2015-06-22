<?php

class MainController extends Controller{

	public function init() {
        return parent::init();
	}
	
    public function actionIndex(){
        $this->render('index', array('questions' => Question::model()->findAll(array('order'=>'created_at DESC'))));
    }

    public function actionView() {

	    $model = new Question;
    	
    	$this->render('view', array(
    		'question' => Question::model()->findByPk(Yii::app()->request->getParam('id')),
    		'model' => $model
    	));

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
	        	$model->save();
	        	$this->redirect(Yii::app()->createUrl('//questionanswer/main/index'));
	            return;
	        }
	    }
	    $this->render('new_question',array('model'=>$model));
	}

}