<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
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

class QuestionAnswerEvents{
    /** 
     * Add the Q&A menu item to 
     * the top menu 
     * @param $event
     */
    public static function onTopMenuInit($event){
        $event->sender->addItem(array(
            'label' => 'Q&A',
            'url' => Yii::app()->createUrl('/questionanswer/question/index', array()),
            'icon' => '<i class="fa fa-stack-exchange"></i>',
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'questionanswer'),
        ));
    }


    /**
     * On rebuild of the search index, rebuild all user records
     *
     * @param type $event
     */
    public static function onSearchRebuild($event)
    {
        foreach (Question::model()->findAll() as $obj) {
            HSearch::getInstance()->addModel($obj);
            print "q";
        }

        foreach (Tag::model()->findAll() as $obj) {
            HSearch::getInstance()->addModel($obj);
            print "t";
        }

        foreach (Answer::model()->findAll() as $obj) {
            HSearch::getInstance()->addModel($obj);
            print "a";
        }

        foreach (Comment::model()->findAll() as $obj) {
            HSearch::getInstance()->addModel($obj);
            print "c";
        }
    }


    /** 
     * A question has been created
     * @param type $event
     */    
    public static function onQuestionAfterSave($event) 
    {
        Karma::model()->addKarma('asked', $event->sender->user->id);
    }


    /**
     * An answer has been created
     * @param type $event
     */
    public static function onAnswerAfterSave($event) 
    {
        Karma::model()->addKarma('answered', $event->sender->user->id);
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
                        Karma::model()->addKarma('question_up_vote', $event->sender->created_by);
                    break;

                    case "answer":
                        Karma::model()->addKarma('answer_up_vote', $event->sender->created_by);
                    break;
                }

            break;

            case "accepted_answer":
                Karma::model()->addKarma('accepted_answer', $event->sender->created_by);
            break;

        }        

    }


}