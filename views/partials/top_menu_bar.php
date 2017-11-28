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

use humhub\modules\questionanswer\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;


$tags = \humhub\modules\questionanswer\models\Tag::find();

// Apply content container, if used.
if($this->context->contentContainer && $this->context->useGlobalContentContainer == false) {
    $tags->contentContainer($this->context->contentContainer);
}


?>
<div class="panel-heading no-border-bottom">
    <ul class="nav nav-tabs qanda-header-tabs">

        <li class="dropdown<?php if(Yii::$app->controller->action->id == "picked") echo ' active'; ?>">
            <a href="<?php echo Url::createUrl('question/picked'); ?>">Picked for you</a>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "index") echo ' active'; ?>">
            <a href="<?php echo Url::createUrl('question/index'); ?>">Questions</a>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "unanswered") echo ' active'; ?>">
            <?php echo Html::a('Unanswered', Url::createUrl('question/unanswered'), array()); ?>
        </li>
        <li class="dropdown<?php if(Yii::$app->controller->action->id == "tag") echo ' active'; ?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tags <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <?php
                // Get all tags
                $tags = $tags->all();

                if(!$tags) {
                    echo "<li><a href=\"#\" class=\"wallFilter\">No tags found</a></li>";
                } else {
                    foreach($tags as $tag) {
                        echo "<li><a href=\"".Url::createUrl('question/tag', ['id' => $tag->id])."\" class=\"wallFilter\">".$tag->tag."</a></li>";
                    }
                }
                ?>
            </ul>
        </li>
        <?php if(Yii::$app->user->isAdmin()) { ?>
            <li class="dropdown">
                <?php echo Html::a('Admin', Url::createUrl('admin'), array()); ?>
            </li>
        <?php } ?>
        <li class="dropdown pull-right">
            <?php echo Html::a('<i class="fa fa-plus"></i> Ask Question', Url::createUrl('create'), array('class'=>'dropdown-toggle btn btn-community')); ?>
        </li>
    </ul>
</div>