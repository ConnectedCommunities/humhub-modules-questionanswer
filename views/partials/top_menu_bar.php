<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

use yii\data\ActiveDataProvider;
?>
<div class="panel-heading">
    <ul class="nav nav-tabs qanda-header-tabs">

        <li class="dropdown<?php if(Yii::$app->controller->action->id == "picked") echo ' active'; ?>">
            <a style="cursor:pointer;" href="<?php echo Url::toRoute('question/picked'); ?>">Picked for you</a>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "index") echo ' active'; ?>">
            <a style="cursor:pointer;" href="<?php echo Url::toRoute('question/index'); ?>">Questions</a>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "unanswered") echo ' active'; ?>">
            <?php echo Html::a('Unanswered', Url::toRoute('question/unanswered'), array()); ?>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "tag") echo ' active'; ?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tags <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <?php
                $tags = \humhub\modules\questionanswer\models\Tag::find()->all();
                if(!$tags) {
                    echo "<li><a href=\"#\" class=\"wallFilter\">No tags found</a></li>";
                } else {
                    foreach($tags as $tag) {
                        echo "<li><a href=\"".Url::toRoute(['question/tag', 'id' => $tag->id])."\" class=\"wallFilter\">".$tag->tag."</a></li>";
                    }
                }
                ?>
            </ul>
        </li>
        <?php if(Yii::$app->user->isAdmin()) { ?>
            <li class="dropdown">
                <?php echo Html::a('Admin', Url::toRoute('admin'), array()); ?>
            </li>
        <?php } ?>
        <li class="dropdown pull-right">
            <?php echo Html::a('<i class="fa fa-plus"></i> Ask Question', Url::toRoute('create'), array('class'=>'dropdown-toggle btn btn-community', 'style'=>"padding:8px;")); ?>
        </li>
    </ul>
</div>