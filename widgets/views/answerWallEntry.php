<?php
/**
 * This view represents a wall entry of a polls.
 * Used by PollWallEntryWidget to show Poll inside a wall.
 *
 * @property User $user the user which created this poll
 * @property Poll $poll the current poll
 * @property Space $space the current space
 *
 * @package humhub.modules.polls.widgets.views
 * @since 0.5
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



