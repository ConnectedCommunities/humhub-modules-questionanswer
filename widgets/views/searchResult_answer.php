<?php
use yii\helpers\Url;
use yii\helpers\Html;
use humhub\libs\Helpers;
?>
<p>
    A: <?php echo Html::encode(Helpers::truncateText($answer->post_text, 150)); ?>
</p>