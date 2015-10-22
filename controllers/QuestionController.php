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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@', (HSetting::Get('allowGuestAccess', 'authentication_internal')) ? "?" : "@"),
            ),
            array('deny', // deny all users
                'users' => array('*'),
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

        $question = new Question();

        if(isset($_POST['Question'])) {

            $this->forcePostRequest();
            $_POST = Yii::app()->input->stripClean($_POST);

			$question->attributes=$_POST['Question'];
            $question->content->populateByForm();
            $question->post_type = "question";

            if ($question->validate()) {

                $question->save();

                if(isset($_POST['Tags'])) {
                    // Split tag string into array
                    $tags = explode(", ", $_POST['Tags']);
                    foreach($tags as $tag) {
                        $tag = Tag::model()->firstOrCreate($tag);
                        $question_tag = new QuestionTag;
                        $question_tag->question_id = $question->id;
                        $question_tag->tag_id = $tag->id;
                        $question_tag->save();
                    }
                }

                $this->redirect($this->createUrl('//questionanswer/question/view', array('id' => $question->id)));

            } else {
                $this->renderJson(array('errors' => $question->getErrors()), false);
            }

        }

		$this->render('create',array(
			'model'=>$question,
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

		// TODO: Use below. 
		// This will produce the same results as Question::model->overview()
		// our current implementation does a handful of additional queries 
		// from within the view to load up question info
		/*
		$criteria=new CDbCriteria;
		$criteria->select = "question.id, question.post_title, question.post_text, question.post_type, COUNT(DISTINCT answers.id) as answers, (COUNT(DISTINCT up.id) - COUNT(DISTINCT down.id)) as score, (COUNT(DISTINCT up.id) + COUNT(DISTINCT down.id)) as vote_count, COUNT(DISTINCT up.id) as up_votes, COUNT(DISTINCT down.id) as down_votes";

		$criteria->join = "LEFT JOIN question_votes up ON (question.id = up.post_id AND up.vote_on = 'question' AND up.vote_type = 'up')
							LEFT JOIN question_votes down ON (question.id = down.post_id AND down.vote_on = 'question' AND down.vote_type = 'down')
							LEFT JOIN question answers ON (question.id = answers.question_id AND answers.post_type = 'answer')";

		$criteria->group = "question.id";
		$criteria->order = "question.created_at DESC, score DESC, vote_count DESC";

		$dataProvider=new CActiveDataProvider('Question', array(
			'criteria'=>$criteria
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/

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
