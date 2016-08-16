<?php



use humhub\widgets\TopMenu;
use humhub\modules\search\engine\Search;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\QuestionVotes;
use humhub\modules\space\widgets\Sidebar;
use humhub\modules\user\widgets\ProfileSidebar;

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
