<?php
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
        'parent_id',
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
