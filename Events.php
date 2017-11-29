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

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param type $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Q&A",
            'url' => Url::to(['/questionanswer/setting']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-stack-exchange"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'questionanswer' && Yii::$app->controller->id == 'setting'),
            'sortOrder' => 510,
        ));
    }

    public static function onTopMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Q&A",
            'icon' => '<i class="fa fa-stack-exchange"></i>',
            'url' => Url::to(['/questionanswer/question/index']),
            'sortOrder' => 350,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'questionanswer'),
        ));
    }

    public static function onSpaceMenuInit($event)
    {
        if ($event->sender->space !== null && $event->sender->space->isModuleEnabled('questionanswer')) {
            $event->sender->addItem(array(
                'label' => "Q&A",
                'group' => 'modules',
                'url' => $event->sender->space->createUrl('//questionanswer/question/index'),
                'icon' => '<i class="fa fa-stack-exchange"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'questionanswer'),
            ));
        }
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
        if(isset(Yii::$app->modules['karma'])) {
            Karma::addKarma('asked', $event->sender->user->id, $event->sender, true);
        }
    }

    /**
     * An answer has been created
     * @param type $event
     */
    public static function onAnswerAfterSave($event)
    {
        if(isset(Yii::$app->modules['karma'])) {
            Karma::addKarma('answered', $event->sender->user->id, $event->sender, true);
        }
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
                        if(isset(Yii::$app->modules['karma'])) {
                            Karma::addKarma('question_up_vote', $event->sender->question->created_by, $event->sender->question);
                        }
                    break;

                    case "answer":
                        if(isset(Yii::$app->modules['karma'])) {
                            Karma::addKarma('answer_up_vote', $event->sender->answer->created_by, $event->sender->answer);
                        }
                    break;

                }

                break;

            case "accepted_answer":

                if(isset(Yii::$app->modules['karma'])) {
                    Karma::addKarma('accepted_answer', $event->sender->answer->created_by, $event->sender->answer);
                }

            break;

        }

    }

}