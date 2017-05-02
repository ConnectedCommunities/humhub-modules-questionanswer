<div class="panel panel-default qanda-panel">
    <div class="panel-heading">
        <?php echo $group; ?>
    </div>
    <div class="list-group">
        <?php foreach($categories as $category) { ?>
            <a href="<?php echo $category['link']; ?>" class="list-group-item">
                <b class="list-group-item-heading"><?php echo $category['name']; ?></b>
                <p class="list-group-item-text"><?php echo $category['description']; ?></p>
            </a>
            <small>
                <ul>
                    <?php

                    $questions = \humhub\modules\questionanswer\models\Question::find()
                        ->contentContainer($category['space'])
                        ->andFilterWhere(['post_type' => 'question'])
                        ->orderBy('created_at DESC')
                        ->limit(3)
                        ->all();

                    foreach($questions as $q) {
                        echo "<li>";
                        echo \yii\helpers\Html::a(\yii\helpers\Html::encode($q['post_title']), \humhub\modules\questionanswer\helpers\Url::createUrl('view', [
                            'id'=> $q['id'],
                            'sguid' => $category['space']->guid
                        ]));
                        echo "</li>";
                    }
                    ?>

                </ul>
            </small>
        <?php } ?>
    </div>
</div>