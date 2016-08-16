<?php

use yii\helpers\Html;

echo Yii::t('TasksModule.views_activities_TaskFinished', '<i class="fa fa-stack-exchange" style="margin-right: 5px;color: #ffdf2c;vertical-align: middle"></i> {userName} asked {answer}.', array(
    '{userName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>',
    '{answer}' => Html::encode($source->getContentDescription())
));
?>

