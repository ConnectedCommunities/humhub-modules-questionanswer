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

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'options' => ['width' => '40px'],
            'format' => 'raw',
            'value' => function($data) {
                return $data->id;
            },
        ],
        'question_id',
        'post_text',
        'post_type',
        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'options' => ['width' => '80px'],
            'buttons' => [
                'view' => function($url, $model) {
                    return Html::a('<i class="fa fa-search"></i>', Url::toRoute(['question/view', 'id' => $model->question_id]), ['class' => 'btn btn-primary btn-xs tt']);
                },
                'update' => function($url, $model) {
                    return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['update', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                },
                'delete' => function($url, $model) {
                    return Html::a('<i class="fa fa-times"></i>', Url::toRoute(['delete', 'id' => $model->id]), ['class' => 'btn btn-danger btn-xs tt']);
                }
            ],
        ],
    ]
]); ?>
