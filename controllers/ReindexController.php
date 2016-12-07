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

use humhub\modules\content\models\Content;
use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\QuestionTag;
use humhub\modules\questionanswer\models\Tag;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\QuestionSearch;
use humhub\modules\user\models\User;
use Yii;
//use humhub\modules\content\components\ContentContainerController;
use humhub\components\Controller;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * Reindex the question, answer and tag models
 * in Lucene's search index. 
 *
 * Class ReindexController
 * @package humhub\modules\questionanswer\controllers
 */
class ReindexController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className(),
                'adminOnly' => true
            ]
        ];
    }

    /**
     * ReIndex:
     *  - Questions
     *  - Answers
     *  - Comments
     */
    public function actionIndex()
    {
        ini_set('max_execution_time', 300);


        if(isset($_GET['model'])) $getModel = $_GET['model'];
        else $getModel = "";

        switch($getModel) {
            default:
                echo '<p><a href="'.Url::toRoute(['reindex/index', 'model' => 'question']).'">Reindex Questions</a></p>';
                echo '<p><a href="'.Url::toRoute(['reindex/index', 'model' => 'answer']).'">Reindex Answer</a></p>';
                echo '<p><a href="'.Url::toRoute(['reindex/index', 'model' => 'tag']).'">Reindex Tag</a></p>';
                break;

            case "question":
                $this->reindexQuestions();
                break;

            case "answer":
                $this->reindexAnswers();
                break;

            case "tag":
                $this->reindexTags();
                break;
        }


        echo "Reindex complete";
    }

    private function reindexQuestions()
    {
        // Remove all questions from search index then index again
        echo ">>>>>> STARTING QUESTION REINDEX >>>>>>>> \n <br>";
        foreach (Question::find()->all() as $obj) {

            echo "[#".$obj->id."] " . $obj->post_title . " \n <br>";

            // No object_id or object_model, create one
            if($obj->content->object_id == "" && $obj->content->object_model == ""){

                $contentModel = new Content();
                $contentModel->guid = \humhub\libs\UUID::v4();
                $contentModel->object_model = Question::className();
                $contentModel->object_id = $obj->id;
                $contentModel->visibility = 1;
                $contentModel->sticked = 0;
                $contentModel->archived = 0;
                $contentModel->user_id = $obj->created_by;
                $contentModel->created_at = $obj->created_at;
                $contentModel->created_by = $obj->created_by;
                $contentModel->updated_at = $obj->updated_at;
                $contentModel->updated_by = $obj->updated_by;
                $contentModel->save();

            }

            // NOTE: You might need to comment this out the first time then uncomment it after
            //			all the object_model and _id records have been created
            $newObj = Question::findOne(['id' => $obj->id]);
            \Yii::$app->search->delete($newObj);
            \Yii::$app->search->add($newObj);

        }
        echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> \n \n <br> <br>";
    }

    private function reindexAnswers()
    {
        // Remove all answers from search index then index them again
        echo "<br><br><br>>>> STARTING ANSWER REINDEX >>>>>>>><br>";
        foreach (Answer::find()->all() as $obj) {

            echo "[#".$obj->id."] " . substr($obj->post_text, 0, 300) . " \n <br>";

            // No object_id or object_model, create one
            if($obj->content->object_id == "" && $obj->content->object_model == ""){

                $contentModel = new Content();
                $contentModel->guid = \humhub\libs\UUID::v4();
                $contentModel->object_model = Answer::className();
                $contentModel->object_id = $obj->id;
                $contentModel->visibility = 1;
                $contentModel->sticked = 0;
                $contentModel->archived = 0;
                $contentModel->user_id = $obj->created_by;
                $contentModel->created_at = $obj->created_at;
                $contentModel->created_by = $obj->created_by;
                $contentModel->updated_at = $obj->updated_at;
                $contentModel->updated_by = $obj->updated_by;
                $contentModel->save();

            }

            // NOTE: You might need to comment this out the first time then uncomment it after
            //			all the object_model and _id records have been created
            $newObj = Answer::findOne(['id' => $obj->id]);
            \Yii::$app->search->delete($newObj);
            \Yii::$app->search->add($newObj);

        }
        echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><br><br>";

    }


    private function reindexTags()
    {
        // Remove all tags from search index then index them again
        echo ">>>>>> STARTING TAG REINDEX >>>>>>>><br>";
        foreach(Tag::find()->all() as $obj) {

            echo "[#".$obj->id."] " . $obj->tag . " \n <br>";

            // No object_id or object_model, create one
            if($obj->content->object_id == "" && $obj->content->object_model == ""){
                $contentModel = new Content();
                $contentModel->guid = \humhub\libs\UUID::v4();
                $contentModel->object_model = Tag::className();
                $contentModel->object_id = $obj->id;
                $contentModel->visibility = 1;
                $contentModel->sticked = 0;
                $contentModel->archived = 0;
                $contentModel->user_id = 0;
                $contentModel->created_at = time();
                $contentModel->created_by = 0;
                $contentModel->updated_at = time();
                $contentModel->updated_by = 0;

                $containerClass = User::className();
                $contentContainer = $containerClass::findOne(['guid' => Yii::$app->getUser()->guid]);
                $contentModel->container = $contentContainer;

                $contentModel->save();

            }

            // NOTE: You might need to comment this out the first time then uncomment it after
            //			all the object_model and _id records have been created
            $newObj = Tag::findOne(['id' => $obj->id]);
            \Yii::$app->search->delete($newObj);
            \Yii::$app->search->add($newObj);

        }
        echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><br><br><br>";
    }

}
