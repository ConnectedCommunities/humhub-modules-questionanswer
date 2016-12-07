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
<div class="panel panel-default">
    <div class="panel-body">

        <?php $this->beginContent('application.modules_core.wall.views.wallLayout', array('object' => $question)); ?>

        <div class="media">
            <div class="pull-right" style="padding-right:15px">

                <?php
                $stats = Question::model()->stats($question->id);
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

            <div class="media-body" style="padding-top:5px; padding-left:5px;">
                <div class="content">
                    <b><?php echo CHtml::link(CHtml::encode($question->post_title), $question::model()->getUrl(array('id'=>$question->id))); ?></b><br />
                    <?php echo CHtml::encode(Helpers::truncateText($question->post_text, 250)); ?>
                    <?php echo CHtml::link("read more <i class=\"fa fa-share\"></i>", $question::model()->getUrl(array('id'=>$question->id))); ?>
                </div>
            </div>
        </div>

        <?php $this->endContent(); ?>

    </div>
</div>



