<?php
use yii\helpers\Url;
use yii\helpers\Html;
use humhub\libs\Helpers;
?>
<p>
    <a href=""><b>TAG: <?php echo Html::a(Html::encode($tag->tag), Url::toRoute(['/questionanswer/question/tag', 'id' => $tag->id])); ?></b></a>
</p>