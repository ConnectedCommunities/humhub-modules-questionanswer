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

use humhub\modules\questionanswer\models\Question;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="panel panel-default">
    <div class="panel-body">

        <div class="media">
            <div class="pull-right" style="padding-right:15px">

                <?php
                $stats = Question::stats($question->id);
                ?>

                <div class="pull-left" style="text-align:center; margin-top:5px; margin-right:8px;">
                    <b><?php echo (int) $stats['score']; ?></b>
                    <p>likes</p>
                </div>
                <div class="pull-left" style="text-align:center; margin-top:5px; margin-right:8px;">
                    <b><?php echo (int) Question::getViewQuestion($question->id); ?></b>
                    <p>views</p>
                </div>
                <div class="pull-left" style="text-align:center; margin-top:5px;">
                    <b><?php echo (int) $stats['answers']; ?></b>
                    <p>responses</p>
                </div>
            </div>

            <div class="media-body" style="padding-top:5px; padding-left:5px;">
                <div class="content">
                    <b><?php echo Html::a(Html::encode($question->post_title), Url::toRoute(array('/questionanswer/question/view', 'id'=>$question->id))); ?></b><br />
                    <?php echo Html::encode(\humhub\libs\Helpers::truncateText($question->post_text, 250)); ?>
                    <?php echo Html::a("read more <i class=\"fa fa-share\"></i>", Url::toRoute(array('/questionanswer/question/view', 'id'=>$question->id))); ?>
                </div>
            </div>
        </div>


    </div>
</div>



