<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
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
?>
<?php
/* @var $this QuestionController */
/* @var $data Question */
?>
<div class="media" >
    <div class="pull-left">
        <div class="vote_control pull-left" style="padding:5px; padding-right:10px; border-right:1px solid #eee; margin-right:10px;">
            <?php 
            $upBtnClass = ""; $downBtnClass = ""; $vote = "";

            // Change the button class to 'active' if the user has voted
            $vote = QuestionVotes::model()->post($data->id)->user(Yii::app()->user->id)->find();
            if($vote) {
                if($vote->vote_type == "up") {
                    $upBtnClass = "active btn-info";
                    $downBtnClass = "";
                } else {
                    $downBtnClass = "active btn-info";
                    $upBtnClass = "";
                }
            }
            
            $this->widget('application.modules.questionanswer.widgets.VoteButtonWidget', array('post_id' => $data->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'class' => $upBtnClass, 'should_open_question' => 0)); 
            $this->widget('application.modules.questionanswer.widgets.VoteButtonWidget', array('post_id' => $data->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'class' => $downBtnClass, 'should_open_question' => 0)); 

            ?>
        </div>
        <!--<a href="" class="pull-left" style="padding-top:5px; padding-right:10px;">
            <img class="media-object img-rounded user-image" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" src="img/default_user.jpg?cacheId=0" width="40" height="40">
        </a>-->
        <?php 
        $stats = Question::model()->stats($data->id); 
        ?>

        <div class="pull-left" style="text-align:center; margin-top:5px; margin-right:8px;">
            <b><?php echo $stats['score']; ?></b>
            <p>votes</p>
        </div>
        <div class="pull-left" style="text-align:center; margin-top:5px;">
            <b><?php echo $stats['answers']; ?></b>
            <p>answers</p>
        </div>

    </div>

    <div class="media-body" style="padding-top:5px; padding-left:10px;">
        <h4 class="media-heading">
        	<?php echo CHtml::link(CHtml::encode($data->post_title), array('view', 'id'=>$data->id)); ?>
        </h4>

        <h5><?php echo CHtml::encode(Helpers::truncateText($data->post_text, 200)); ?></h5>
    </div>
</div>

