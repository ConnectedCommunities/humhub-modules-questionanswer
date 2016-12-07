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
        Answer written<br />
        <?php $this->beginContent('application.modules_core.wall.views.wallLayout', array('object' => $answer)); ?>

        <div class="media">
            <div class="media-body" style="padding-top:5px; padding-left:10px;">
                <h4 class="media-heading">
                    <?php echo CHtml::link(CHtml::encode($question->post_title), array('view', 'id'=>$question->id)); ?>
                </h4>
                <h5><?php echo CHtml::encode(Helpers::truncateText($answer->post_text, 200)); ?></h5>
            </div>
        </div>

        <?php $this->endContent(); ?>

    </div>
</div>



