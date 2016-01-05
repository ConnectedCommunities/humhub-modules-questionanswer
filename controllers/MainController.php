<?php

namespace humhub\modules\questionanswer\controllers;

use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\QuestionTag;
use humhub\modules\questionanswer\models\Tag;
use humhub\modules\questionanswer\models\Question;
use Yii;
use humhub\components\Controller;

class MainController extends Controller
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
	 * Controller for viewing a
	 * tag and loading up all questions
	 * from within that tag
	 */
    public function actionTag() {
		
    	error_reporting(E_ALL); 
		ini_set("display_errors", 1);

        $tag = Tag::findOne(['id' => Yii::$app->request->get('id')]);


		// User has just voted on a question
        // TODO: Use castVote()
		/*$questionVotesModel = new QuestionVotes;
	    if(isset($_POST['QuestionVotes']))
	    {
	        $questionVotesModel->attributes=$_POST['QuestionVotes'];
            $questionVotesModel->created_by = Yii::app()->user->id;
        	
	        if($questionVotesModel->validate())
	        {

	        	// TODO: If the user has previously voted on this, drop it 
	        	$previousVote = QuestionVotes::model()->find('post_id=:post_id AND created_by=:user_id', array('post_id' => $questionVotesModel->post_id, 'user_id' => Yii::app()->user->id));
	        	if($previousVote) $previousVote->delete();

	            $questionVotesModel->save();
	            $this->redirect($this->createUrl('//questionanswer/main/index'));
	        }
	    }*/

        return $this->render('tags', array(
        	'tag' => $tag,
        	'questions' => Question::tag_overview($tag->id)
        ));
        
    }
}