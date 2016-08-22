<?php

namespace humhub\modules\questionanswer\controllers;

use humhub\modules\content\controllers\ContentController;
use humhub\modules\questionanswer\models\Answer;
use yii\base\Exception;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use humhub\modules\content\models\Content;
use humhub\components\Controller;
use Yii;

class AnswerController extends Controller
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
				'actions'=>array('index','view'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$answer = new Answer();

		if(isset($_POST['Answer'])) {

			$this->forcePostRequest();

            $answer->load(\Yii::$app->request->post());
            $answer->post_type = "answer";

            if ($answer->validate()) {

                $answer->save();

				\humhub\modules\file\models\File::attachPrecreated($answer, Yii::$app->request->post('fileList'));
                return $this->redirect(array('//questionanswer/question/view','id'=>$answer->question_id));
            }

			return $this->redirect(\Yii::$app->request->referrer);
        }
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

		if(isset($_POST['Answer']))
		{
			$model->load(\Yii::$app->request->post());
			if($model->save())
				$this->redirect($this->createUrl('//questionanswer/question/view', array('id' => $model->question_id)));
		}

		return $this->render('update',array(
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
		$dataProvider=new ActiveDataProvider([
			'query' => Answer::find(),
		]);
		return $this->render('index',array(
			'dataProvider'=> $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Answer('search');
		if(isset($_GET['Answer']))
			$model->load(\Yii::$app->request->get());

		return $this->render('admin', array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Answer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Answer::findOne($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Answer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='answer-form')
		{
			echo ActiveForm::validate($model);
			\Yii::$app->end();
		}
	}
}
