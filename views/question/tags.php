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

use humhub\libs\Html;
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\QuestionVotes;

humhub\modules\questionanswer\Asset::register($this);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Questions Tagged: <?php echo Html::encode($tag->tag); ?></h3>
            <br>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::toRoute('/questionanswer/question/index'); ?>">Discussion Forums</a></li>
                    <?php if(get_class($container) == \humhub\modules\space\models\Space::class) { ?>
                        <li><a href="<?php echo $container->createUrl('/questionanswer/question/index') ?>"><?php echo $container->name; ?></a></li>
                    <?php } ?>
                    <li class="active">Questions tagged: <?php echo Html::encode($tag->tag); ?></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default qanda-panel">
                    <?php echo $this->render('../partials/top_menu_bar'); ?>
                    <div class="panel-body">

                        <?php foreach ($questions as $question) { ?>
                            <div class="media">
                                <div class="pull-left">
                                    <div class="vote_control pull-left">
                                        <?php
                                        $upBtnClass = ""; $downBtnClass = ""; $vote = "";

                                        // Change the button class to 'active' if the user has voted
                                        $vote = QuestionVotes::findOne(['post_id' => $question['id'], 'created_by' => Yii::$app->user->id]);
                                        if($vote) {
                                            if($vote->vote_type == "up") {
                                                $upBtnClass = "active btn-info";
                                                $downBtnClass = "";
                                            } else {
                                                $downBtnClass = "active btn-info";
                                                $upBtnClass = "";
                                            }
                                        }

                                        echo \humhub\modules\questionanswer\widgets\VoteButtonWidget::widget(array('post_id' => $question['id'], 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'class' => $upBtnClass, 'should_open_question' => 0));
                                        echo \humhub\modules\questionanswer\widgets\VoteButtonWidget::widget(array('post_id' => $question['id'], 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'class' => $downBtnClass, 'should_open_question' => 0));

                                        ?>
                                    </div>
                                    <!--<a href="" class="pull-left" style="padding-top:5px; padding-right:10px;">
                                        <img class="media-object img-rounded user-image" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" src="img/default_user.jpg?cacheId=0" width="40" height="40">
                                    </a>-->
                                    <div class="pull-left vote_count">
                                        <b><?php echo $question['vote_count']; ?></b>
                                        <p>votes</p>
                                    </div>
                                    <div class="pull-left answer_count">
                                        <b><?php echo $question['answers']; ?></b>
                                        <p>answers</p>
                                    </div>

                                </div>

                                <div class="media-body tag-area">
                                    <h4 class="media-heading">
                                        <?php echo \yii\helpers\Html::a(\yii\helpers\Html::encode($question['post_title']), array('question/view', 'id'=>$question['id'])); ?>
                                    </h4>

                                    <h5><?php echo \yii\helpers\Html::encode(\humhub\libs\Helpers::truncateText($question['post_text'], 200)); ?></h5>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end: show content -->