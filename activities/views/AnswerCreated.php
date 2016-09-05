<?php

use yii\helpers\Html;
?>
<div class="answer-activity">
    <?php
        echo Yii::t('app', '<i class="fa fa-stack-exchange color-qanda" style="margin-right: 5px;color: #fdc015;vertical-align: middle"></i>' . '{userName} answered {answer}.', array(
            '{userName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>',
            '{answer}' => Html::encode($source->getContentDescription())
        ));
    ?>
</div>
