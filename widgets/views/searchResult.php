<?php
/**
 * This View shows a post inside the search
 *
 * @property Post $post is the post object
 *
 * @package humhub.modules.post
 * @since 0.5
 */
use yii\helpers\Html;
use humhub\libs\Helpers;
?>

<li>
    <a href="<?php // echo $this->createUrl('//questionanswer/question/view', array('id' => $question->id)); ?>">
        <div class="media">
            <div class="media-body">
                <strong><?php echo Html::encode($question->post_title); ?> </strong><br>
                <span class="content"><?php echo Html::encode(Helpers::truncateText($question->post_text, 150)); ?></span>
                <br />
                <?php foreach($question->tags as $tag) { ?>
                    <span class="label label-default"><?php echo $tag->tag->tag; ?></span>
                <?php } ?>
            </div>
        </div>
    </a>
</li>