<?php

use yii\helpers\Html;
?>
<div class="question-activity">
    <?php
        echo Yii::t('app', '<i class="fa fa-stack-exchange" style="margin-right: 5px;color: #ffdf2c;vertical-align: middle"></i> {userName} asked {answer}.', array(
            '{userName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>',
            '{answer}' => Html::encode($source->getContentDescription())
        ));
    ?>
</div>
