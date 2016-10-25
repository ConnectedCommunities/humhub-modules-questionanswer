<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */


use humhub\widgets\TopMenu;
use humhub\modules\search\engine\Search;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\QuestionVotes;
use humhub\modules\space\widgets\Sidebar;
use humhub\modules\user\widgets\ProfileSidebar;
use humhub\modules\questionanswer\Events;

include(\Yii::getAlias("@app/modules/questionanswer/models/Question"). ".php");
include(\Yii::getAlias("@app/modules/questionanswer/models/Answer"). ".php");
include(\Yii::getAlias("@app/modules/questionanswer/models/QuestionVotes"). ".php");

return [
    'id' => 'questionanswer',
    'class' => 'humhub\modules\questionanswer\Module',
    'namespace' => 'humhub\modules\questionanswer',
    'events' => array(
        array('class' => TopMenu::className(), 'event' => TopMenu::EVENT_INIT, 'callback' => array('humhub\modules\questionanswer\Events', 'onTopMenuInit')),

        // Question created
        array('class' => Question::className(), 'event' => Question::EVENT_AFTER_INSERT, 'callback' => array('humhub\modules\questionanswer\Events', 'onQuestionAfterSave')),

        // Answer created
        array('class' => Answer::className(), 'event' => Answer::EVENT_AFTER_INSERT, 'callback' => array('humhub\modules\questionanswer\Events', 'onAnswerAfterSave')),

        // Up vote on question, up vote on answer, answer created
        array('class' => QuestionVotes::className(), 'event' => QuestionVotes::EVENT_AFTER_INSERT, 'callback' => array('humhub\modules\questionanswer\Events', 'onQuestionVoteAfterSave')),

        array('class' => Sidebar::className(), 'event' => Sidebar::EVENT_INIT, 'callback' => array('humhub\modules\questionanswer\Events', 'onSidebarSpaces')),

        array('class' => ProfileSidebar::className(), 'event' => ProfileSidebar::EVENT_INIT, 'callback' => array('humhub\modules\questionanswer\Events', 'onSidebarProfiles')),
        array('class' => Search::className(), 'event' => Search::EVENT_ON_REBUILD, 'callback' => array('humhub\modules\questionanswer\Events', 'onSearchRebuild')),
    ),
];
