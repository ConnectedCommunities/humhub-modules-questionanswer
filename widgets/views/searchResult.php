<?php
use yii\helpers\Url;
use yii\helpers\Html;
use humhub\libs\Helpers;
?>
<p>
    <a href=""><b>Q: <?php echo Html::a(Html::encode($question->post_title), Url::toRoute(['/questionanswer/question/view', 'id' => $question->id])); ?></b></a>
</p>
<p>
    <?php echo Html::encode(Helpers::truncateText($question->post_text, 150)); ?>
</p>
<p>
    <?php foreach($question->tags as $tag) { ?>
        <span class="label label-default"><?php echo $tag->tag->tag; ?></span>
    <?php } ?>
</p>