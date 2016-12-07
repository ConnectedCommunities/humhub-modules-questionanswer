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

        
    ),
));
?>