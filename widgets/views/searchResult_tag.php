<?php
/**
 * This View shows a post inside the search
 *
 * @property Post $post is the post object
 *
 * @package humhub.modules.post
 * @since 0.5
 */
?>

<li>
    <a href="<?php echo $this->createUrl('//questionanswer/main/tag', array('id' => 1)); ?>">
        <div class="media">
            <div class="media-body">
                TAG: <strong><?php echo CHtml::encode($tag->tag); ?> </strong><br>
            </div>
        </div>
    </a>
</li>