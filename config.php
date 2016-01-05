<?php

use humhub\widgets\TopMenu;

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
    ],
];
?>