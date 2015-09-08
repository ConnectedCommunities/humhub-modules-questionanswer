<?php

class QuestionController extends Controller
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'unanswered'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		$this->render('view',array(

    		'author' => $model->user->id,
    		'question' => $model,
    		'answers' => Answer::model()->overview($model->id),
    		'related' => Question::model()->related($model->id),

			'model'=> $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{


	    $model = new Question;
        $model->created_by = Yii::app()->user->id;
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
			    
        	    $this->redirect($this->createUrl('//questionanswer/question/view', array('id' => $model->id)));
	        }
	    }



		// $model=new Question;

		// // Uncomment the following line if AJAX validation is needed
		// // $this->performAjaxValidation($model);

		// if(isset($_POST['Question']))
		// {
		// 	$model->attributes=$_POST['Question'];
		// 	if($model->save())
		// 		$this->redirect(array('view','id'=>$model->id));
		// }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
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
		$dataProvider=new CActiveDataProvider('Question', array(
			'criteria'=>array(
				'order'=>'created_at DESC',
			)
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/** 
	 * Find unanswered questions
	 */
	public function actionUnanswered()
	{
		$criteria=new CDbCriteria;
		$criteria->select = "question.id, question.post_title, question.post_text, question.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes";
		// $criteria->with = array('tags');
		// $criteria->condition = "tags.question_id = question.id";
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Question the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Question::model()->findByPk($id);
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
