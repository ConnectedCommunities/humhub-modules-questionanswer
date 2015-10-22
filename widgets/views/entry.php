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

        <b><?php echo $question->post_title; ?></b><br />
        <?php echo $question->post_text; ?>
        <?php $this->endContent(); ?>

    </div>
</div>
