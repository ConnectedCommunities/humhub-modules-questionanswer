<?php

namespace humhub\modules\questionanswer\controllers;
use humhub\components\Controller;
use humhub\modules\questionanswer\models\QuestionVotes;
use humhub\modules\questionanswer\models\Answer;

class VoteController extends Controller
{

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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new QuestionVotes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['QuestionVotes']))
		{
			$model->attributes=$_POST['QuestionVotes'];

			// TODO: I'd like to figure out a way to instantiate the model 
			//			dynamically. I think they might do that with 
			//			the 'activity' module. For now this will do.
			switch($model->vote_on) {
				case "question":
					$question_id = $model->post_id;
				break;

				case "answer":
					$obj = Answer::findOne($model->post_id);
					$question_id = $obj->question_id;
				break;

			}

			if(QuestionVotes::castVote($model, $question_id)) {
				// TODO: Change answers to have a should_open_question value of 1, temp fix below.
				if($_POST['QuestionVotes']['should_open_question'] || $model->vote_on == "answer") {
					$this->redirect(array('//questionanswer/question/view','id'=>$question_id));
				} else {
					$this->redirect(array('//questionanswer/question/index'));
				}

			}


		}

		//should never get here
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

		if(isset($_POST['QuestionVotes']))
		{
			$model->attributes=$_POST['QuestionVotes'];
			if($model->save())
				$this->redirect(array('//questionanswer/question/view','id'=>$model->post_id));
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new QuestionVotes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['QuestionVotes']))
			$model->attributes=$_GET['QuestionVotes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return QuestionVotes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=QuestionVotes::findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param QuestionVotes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-votes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
