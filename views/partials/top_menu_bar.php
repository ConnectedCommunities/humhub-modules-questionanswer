<?php

use humhub\modules\questionanswer\models\Tag;

?>
<div class="panel-heading">
    <ul class="nav nav-tabs qanda-header-tabs">
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "picked") echo ' active'; ?>">
            <a style="cursor:pointer;" href="<?php echo Yii::$app->urlManager->createUrl('//questionanswer/question/picked'); ?>">Picked for you</a>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "index") echo ' active'; ?>">
            <a style="cursor:pointer;" href="<?php echo Yii::$app->urlManager->createUrl('//questionanswer/question/index'); ?>">Posts</a>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "unanswered") echo ' active'; ?>">
            <?php echo \yii\helpers\Html::a('Unresponded', Yii::$app->urlManager->createUrl('//questionanswer/question/unanswered'), array()); ?>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "tag") echo ' active'; ?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tags <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <?php
                $tags = Tag::find()->all();
                if(!$tags) {
                    echo "<li><a href=\"#\" class=\"wallFilter\">No tags found</a></li>";
                } else {
                    foreach($tags as $tag) {
                        if(!empty($tag->questionTag->question)) {
                            echo "<li><a href=\"" . yii\helpers\Url::toRoute(array('//questionanswer/main/tag', 'id' => $tag->id)) . "\" class=\"wallFilter\">" . $tag->tag . "</a></li>";
                        }
                    }
                }
                ?>
            </ul>
        </li>
        <?php if(Yii::$app->user->isAdmin()) { ?>
            <li class="dropdown">
                <?php echo \yii\helpers\Html::a('Admin', Yii::$app->urlManager->createUrl('//questionanswer/question/admin'), array()); ?>
            </li>
        <?php } ?>
        <li class="dropdown pull-right" style="display:none;">
            <?php echo \yii\helpers\Html::a('<i class="fa fa-plus"></i> Ask Question', Yii::$app->urlManager->createAbsoluteUrl('//questionanswer/question/create'), array('class'=>'dropdown-toggle btn btn-community', 'style'=>"padding:8px;")); ?>
        </li>
    </ul>
</div>