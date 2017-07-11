<span contenteditable="false">
    <a href="<?php echo \yii\helpers\Url::to(['/search/search', 'SearchForm' => ['keyword' => \humhub\modules\questionanswer\models\Hashtag::strip($hashtag)]]); ?>"
       target="_self"
       class="atwho-user"
       data-richtext-feature data-guid="<?php echo \humhub\modules\questionanswer\models\Hashtag::slug($hashtag); ?>"><?php echo \yii\helpers\Html::encode($hashtag); ?></a>
</span>
