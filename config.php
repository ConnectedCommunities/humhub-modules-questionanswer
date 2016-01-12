<?php

use humhub\widgets\TopMenu;
use humhub\modules\questionanswer\models\Question;

return [
    'id' => 'questionanswer',
    'class' => 'humhub\modules\questionanswer\Module',
    'namespace' => 'humhub\modules\questionanswer',
    'events' => [
        [
            'class' => \humhub\widgets\TopMenu::className(),
            'event' => \humhub\widgets\TopMenu::EVENT_INIT,
            'callback' => ['humhub\modules\questionanswer\Events', 'onTopMenuInit'],
        ],
        [
            'class' => \humhub\components\ActiveRecord::className(),
            'event' => \humhub\components\ActiveRecord::EVENT_AFTER_INSERT,
            'callback' => ['humhub\modules\questionanswer\Events', 'onActiveRecordAfterSave'],

        ],
        [
            'class' => \humhub\modules\search\engine\Search::className(),
            'event' => \humhub\modules\search\engine\Search::EVENT_ON_REBUILD,
            'callback' => ['humhub\modules\questionanswer\Events', 'onSearchRebuild'],
        ]
    ],
];
?>