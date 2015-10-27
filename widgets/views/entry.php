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
                <h4 class="media-heading">
                    <?php echo CHtml::link(CHtml::encode($question->post_title), array('view', 'id'=>$question->id)); ?>
                </h4>
                <h5>
                    <?php echo CHtml::encode(Helpers::truncateText($question->post_text, 250)); ?>
                    <?php echo CHtml::link("read more <i class=\"fa fa-share\"></i>", array('view', 'id'=>$question->id)); ?>
                </h5>
            </div>
        </div>

        <?php $this->endContent(); ?>

    </div>
</div>



