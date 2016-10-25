<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace humhub\modules\questionanswer\controllers;

use humhub\components\Controller;
use humhub\modules\questionanswer\models\QuestionVotes;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use humhub\modules\questionanswer\models\Answer;
use Yii;

class VoteController extends Controller
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model= new QuestionVotes();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['QuestionVotes']))
		{
			$model->load(Yii::$app->request->post());

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

				if($_POST['QuestionVotes']['should_open_question'] == true) {
					$this->redirect(array('//questionanswer/question/view','id'=>$question_id));
				} else {
					$this->redirect(Yii::$app->request->referrer);
				}

			}


		}

		return $this->render('create',array(
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
		$model=QuestionVotes::model()->findByPk($id);
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

	public static function countLikes($question_id)
	{
	}
}
