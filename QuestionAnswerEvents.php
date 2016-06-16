<?php

class QuestionAnswerEvents{
    /** 
     * Add the Q&A menu item to 
     * the top menu 
     * @param $event
     */
    public static function onTopMenuInit($event){
        $event->sender->addItem(array(
            'label' => 'Knowledge',
            'url' => Yii::app()->createUrl('/questionanswer/question/picked', array()),
            'icon' => '<i class="fa fa-stack-exchange"></i>',
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'questionanswer'),
            'sortOrder' => 10,
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

        foreach (QAComment::model()->findAll() as $obj) {
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

    public static function onSidebarSpaces($event)
    {
        $event->sender->widget('application.modules.questionanswer.widgets.KnowledgeTour');
    }

    public static function onSidebarProfiles($event)
    {
        $event->sender->widget('application.modules.questionanswer.widgets.KnowledgeTour');
    }
}