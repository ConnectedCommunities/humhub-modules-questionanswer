<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace humhub\modules\questionanswer\controllers;

use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\Comment;
use humhub\modules\questionanswer\models\QuestionTag;
use humhub\modules\questionanswer\models\Tag;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\CommentSearch;
use humhub\modules\user\models\User;
use Yii;
//use humhub\modules\content\components\ContentContainerController;
use humhub\components\Controller;
use yii\helpers\Url;

class CommentController extends Controller
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		return $this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Comment();

		if(isset($_POST['Comment']))
		{

            $model->load(Yii::$app->request->post());
            $model->post_type = "comment";
			$model->created_by = Yii::$app->user->id;

            if ($model->validate()) {
                $model->save();
                $this->redirect($model->getUrl());
            }

		}

	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$id = Yii::$app->request->get('id');
		$model = Comment::findOne(['id' => $id]);
		//$model->content->object_model = Comment::class;
		//$model->content->object_id = $model->id;

		$containerClass = User::className();
		$contentContainer = $containerClass::findOne(['guid' => Yii::$app->getUser()->guid]);
		//$model->content->container = $contentContainer;

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
			$this->redirect($model->getUrl());
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
	 * Manages all models
	 */
	public function actionAdmin()
	{
		$searchModel = new CommentSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('../question/admin', array(
			'dataProvider'  => $dataProvider,
			'searchModel'   => $searchModel,
			'model'         => Comment::find()
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Comment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Comment::findOne(['id' => $id]);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}



	/**
	 * Performs the AJAX validation.
	 * @param Comment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
