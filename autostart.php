<?php

Yii::app()->moduleManager->register(array(
    'id' => 'questionanswer',
    'class' => 'application.modules.questionanswer.QuestionAnswerModule',
    'import' => array(
        'application.modules.questionanswer.*',
        'application.modules.questionanswer.models.*',

        'application.modules.karma.*',
        'application.modules.karma.models.*',
        'application.modules.karma.widgets.*',

    ),
    'events' => array(
        array('class' => 'TopMenuWidget', 'event' => 'onInit', 'callback' => array('QuestionAnswerEvents', 'onTopMenuInit')),
        array('class' => 'HSearch', 'event' => 'onRebuild', 'callback' => array('QuestionAnswerEvents', 'onSearchRebuild')),
        
        // Question created
        array('class' => 'Question', 'event' => 'onAfterSave', 'callback' => array('QuestionAnswerEvents', 'onQuestionAfterSave')),

        // Answer created
        array('class' => 'Answer', 'event' => 'onAfterSave', 'callback' => array('QuestionAnswerEvents', 'onAnswerAfterSave')),

        // Up vote on question, up vote on answer, answer created
        array('class' => 'QuestionVotes', 'event' => 'onAfterSave', 'callback' => array('QuestionAnswerEvents', 'onQuestionVoteAfterSave')),

        array('class' => 'SpaceSidebarWidget', 'event' => 'onInit', 'callback' => array('QuestionAnswerEvents', 'onSidebarSpaces')),

        array('class' => 'ProfileSidebarWidget', 'event' => 'onInit', 'callback' => array('QuestionAnswerEvents', 'onSidebarProfiles')),
    ),
));
?>