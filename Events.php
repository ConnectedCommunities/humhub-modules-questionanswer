<?php

namespace humhub\modules\questionanswer;

use humhub\modules\content\models\Content;
use humhub\modules\karma\models\Karma;
use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\QuestionVotes;
use humhub\modules\user\models\forms\AccountRegister;
use humhub\modules\email_whitelist\models\EmailWhitelist;
use Yii;
use yii\helpers\Url;

class Events extends \yii\base\Object
{

    public static function onTopMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Q&A",
            'icon' => '<i class="fa fa-stack-exchange"></i>',
            'url' => Url::to(['/questionanswer/question/index']),
            'sortOrder' => 200,
        ));
    }

    /**
     * Catch and dispatch events for AfterSave
     *
     * This approach isn't preferable but it seems
     * like the ability to tap into the afterSave event
     * from Events has been removed. This will do as a
     * temporary fix.
     *
     * @param $event
     */
    public static function onActiveRecordAfterSave($event)
    {
        switch(get_class($event->sender)) {

            case Question::className():
                self::onQuestionAfterSave($event);
                break;

            case Answer::className():
                self::onAnswerAfterSave($event);
                break;

            case QuestionVotes::className():
                self::onQuestionVoteAfterSave($event);
                break;

        }

    }

    /**
     * A question has been created
     * @param type $event
     */
    public static function onQuestionAfterSave($event)
    {


//        foreach (Content::find()->all() as $content) {
//            $contentObject = $content->getPolymorphicRelation();
//            if ($contentObject instanceof \humhub\modules\search\interfaces\Searchable) {
//                Yii::$app->search->add($contentObject);
//            }
//        }

        Karma::addKarma('asked', $event->sender->user->id);
//        foreach (Question::find()->all() as $obj) {
//            \Yii::$app->search->add($obj);
//        }
    }

    /**
     * An answer has been created
     * @param type $event
     */
    public static function onAnswerAfterSave($event)
    {
        Karma::addKarma('answered', $event->sender->user->id);
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

        switch($event->sender->vote_type) {
            case "up":

                // Only vote on questions and answers
                switch($event->sender->vote_on) {
                    case "question":
                        Karma::addKarma('question_up_vote', $event->sender->created_by);
                        break;

                    case "answer":
                        Karma::addKarma('answer_up_vote', $event->sender->created_by);
                        break;
                }

                break;

            case "accepted_answer":
                Karma::addKarma('accepted_answer', $event->sender->created_by);
                break;

        }

    }

}