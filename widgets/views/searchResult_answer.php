<?php
/**
 * This View shows a post inside the search
 *
 * @property Post $post is the post object
 *
 * @package humhub.modules.post
 * @since 0.5
 */

use yii\helpers\Url;
use yii\helpers\Html;
use humhub\libs\Helpers;

?>
<li>
    <a href="<?php echo Url::toRoute(array('/questionanswer/question/view', 'id' => $question['id'])); ?>">
        <div class="media">
            <div class="media-body">
                <strong><?php echo Html::encode($question['post_title']); ?> </strong><br>
                <span class="content" style="border-left:2px solid #ccc; padding-top:2px; padding-bottom:2px; padding-left:5px; margin-left: 5px;"><?php echo Html::encode(Helpers::truncateText($answer->post_text, 150)); ?></span>
                <br />
            </div>
        </div>
    </a>
</li>