<?php

Yii::app()->moduleManager->register(array(
    'id' => 'questionanswer',
    'class' => 'application.modules.questionanswer.QuestionAnswerModule',
    'import' => array(
        'application.modules.questionanswer.*',
        'application.modules.questionanswer.models.*',
    ),
    'events' => array(
        array('class' => 'TopMenuWidget', 'event' => 'onInit', 'callback' => array('QuestionAnswerEvents', 'onTopMenuInit')),
    ),
));
?>