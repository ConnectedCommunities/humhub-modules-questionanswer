<?php

use yii\helpers\Html;

echo Yii::t('app', '{userDisplayName} likes {contentTitle}', array(
    '{userDisplayName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>',
    '{contentTitle}' => $preview,
));
?>
