<?php

class QuestionAnswerEvents{
    public static function onTopMenuInit($event){
        $event->sender->addItem(array(
            'label' => 'Q&A',
            'url' => Yii::app()->createUrl('/questionanswer/main/index', array()),
            'icon' => '<i class="fa fa-stack-exchange"></i>',
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'questionanswer'),
        ));
    }
}