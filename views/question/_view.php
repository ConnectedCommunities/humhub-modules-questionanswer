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

/* @var $this QuestionController */
/* @var $data Question */
use humhub\modules\questionanswer\models\Question;
use humhub\modules\questionanswer\models\QuestionVotes;
use humhub\modules\questionanswer\helpers\Url;
?>
<div class="media" >
    <div class="pull-left">
        <div class="vote_control pull-left">
            <?php 
            $upBtnClass = ""; $downBtnClass = ""; $vote = "";

            // Change the button class to 'active' if the user has voted
            $vote = QuestionVotes::findOne(['post_id' => $data->id, 'created_by' => Yii::$app->user->id]);
            if($vote) {
                if($vote->vote_type == "up") {
                    $upBtnClass = "active btn-info";
                    $downBtnClass = "";
                } else {
                    $downBtnClass = "active btn-info";
                    $upBtnClass = "";
                }
            }

            echo \humhub\modules\questionanswer\widgets\VoteButtonWidget::widget(array('post_id' => $data->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'btn_class' => $upBtnClass, 'should_open_question' => 0));
            echo \humhub\modules\questionanswer\widgets\VoteButtonWidget::widget(array('post_id' => $data->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'btn_class' => $downBtnClass, 'should_open_question' => 0));

            ?>
        </div>
        <!--<a href="" class="pull-left" style="padding-top:5px; padding-right:10px;">
            <img class="media-object img-rounded user-image" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" src="img/default_user.jpg?cacheId=0" width="40" height="40">
        </a>-->
        <?php 
        $stats = Question::stats($data->id);
        ?>


        <div class="pull-left vote_count">
            <b><?php echo $stats['score']; ?></b>
            <p>votes</p>
        </div>
        <div class="pull-left answer_count">
            <b><?php echo $stats['answers']; ?></b>
            <p>answers</p>
        </div>

    </div>

    <div class="media-body" style="padding-top:5px; padding-left:10px;">
        <h4 class="media-heading">
            <?php
            if($data->post_title != "") {
                echo \yii\helpers\Html::a(\yii\helpers\Html::encode($data->post_title), Url::createUrl('view', ['id'=>$data->id]));
            } else {
                echo \yii\helpers\Html::a("...", Url::createUrl('view', ['id'=>$data->id]));
            }
            ?>
        </h4>

        <h5><?php echo \yii\helpers\Html::encode(\humhub\libs\Helpers::truncateText($data->post_text, 200)); ?></h5>
    </div>
</div>

