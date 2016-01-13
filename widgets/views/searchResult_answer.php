<?php
use yii\helpers\Url;
use yii\helpers\Html;
use humhub\libs\Helpers;

$question = $answer->question;
?>
<p>
    <a href=""><b>Q: <?php echo Html::a(Html::encode($question->post_title), Url::toRoute(['/questionanswer/question/view', 'id' => $question->id])); ?></b></a>
</p>
<p>
    <span class="content" style="border-left:2px solid #ccc; padding-top:2px; padding-bottom:2px; padding-left:5px; margin-left: 5px;">
        A: <?php echo Html::a(Html::encode(Helpers::truncateText($answer->post_text, 150)), Url::toRoute(['/questionanswer/question/view', 'id' => $question->id])); ?>
    </span>
</p>
