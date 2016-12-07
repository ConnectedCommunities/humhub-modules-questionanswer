<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
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
            'class' => humhub\modules\space\widgets\Menu::className(),
            'event' => humhub\modules\space\widgets\Menu::EVENT_INIT,
            'callback' => ['humhub\modules\questionanswer\Events', 'onSpaceMenuInit']
        ],
        [
            'class' => \humhub\modules\admin\widgets\AdminMenu::className(),
            'event' => \humhub\modules\admin\widgets\AdminMenu::EVENT_INIT,
            'callback' => ['humhub\modules\questionanswer\Events', 'onAdminMenuInit']
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