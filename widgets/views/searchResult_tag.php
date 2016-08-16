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

?>

<li>
    <a href="<?php echo Url::toRoute(array('/questionanswer/main/tag', 'id' => $tag->id)); ?>">
        <div class="media">
            <div class="media-body">
                TAG: <strong><?php echo Html::encode($tag->tag); ?> </strong><br>
            </div>
        </div>
    </a>
</li>