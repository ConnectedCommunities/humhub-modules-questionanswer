<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.org/licences
 */

namespace humhub\modules\questionanswer;

use humhub\modules\questionanswer\models\QAComment;
use humhub\modules\questionanswer\models\Tag;
use humhub\modules\questionanswer\widgets\KnowledgeTour;
use Symfony\Component\Config\Definition\Exception\Exception;
use Yii;

use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\Answer;
use humhub\models\Setting;
use humhub\modules\karma\models\Karma;
use humhub\modules\search\engine\Search;

class Events extends \yii\base\Object
{
    /** 
     * Add the Q&A menu item to 
     * the top menu 
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $event->sender->addItem(array(
            'label' => 'Knowledge',
            'url' => \Yii::$app->urlManager->createUrl('/questionanswer/question/picked', array()),
            'icon' => '<i class="fa fa-stack-exchange"></i>',
            'isActive' => (\Yii::$app->controller->module && \Yii::$app->controller->module->id == 'questionanswer'),
            'sortOrder' => 10,
        ));
    }


    /**
     * A question has been created
     * @param type $event
     */    
    public static function onQuestionAfterSave($event) 
    {
        $karma = new Karma();
        $karma->addKarma('asked', \Yii::$app->user->id);
    }

    /**
     * On rebuild of the search index, rebuild all space records
     *
     * @param type $event
     */
    public static function onSearchRebuild($event)
    {
        foreach (Question::find()->all() as $obj) {
            Yii::$app->search->add($obj);
        }

        foreach (Answer::find()->all() as $obj) {
            Yii::$app->search->add($obj);
        }

        foreach (Tag::find()->all() as $obj) {
            Yii::$app->search->add($obj);
        }
    }

    /**
     * An answer has been created
     * @param type $event
     */
    public static function onAnswerAfterSave($event) 
    {
        $karma = new Karma();
        $karma->addKarma('answered', \Yii::$app->user->id);
    }


    /**
     * A question has been voted on 
     * This method will determine what type
     * of vote has been cast and what karma to give.
     * 
     * Key Votes:
     * - up vote on question
     * - up vote on answer
     * - marked as best answer
     *
     * @param type $event
     */
    public static function onQuestionVoteAfterSave($event) 
    {
        $karma = new Karma();
        switch($event->sender->vote_type) {
            case "up":
                
                // Only vote on questions and answers
                switch($event->sender->vote_on) {
                    case "question":
                        $karma->addKarma('question_up_vote', $event->sender->created_by);
                    break;

                    case "answer":
                        $karma->addKarma('answer_up_vote', $event->sender->created_by);
                    break;
                }

            break;

            case "accepted_answer":
                $karma->addKarma('accepted_answer', $event->sender->created_by);
            break;

        }        

    }

    public static function onSidebarSpaces($event)
    {
        $event->sender->addWidget(KnowledgeTour::className(), array(), array('sortOrder' => 10));
    }

    public static function onSidebarProfiles($event)
    {
        $event->sender->addWidget(KnowledgeTour::className(), array(), array('sortOrder' => 90));
    }
}
