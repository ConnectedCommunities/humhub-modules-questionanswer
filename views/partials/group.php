<div class="panel panel-default qanda-panel">
    <div class="panel-heading">
        <a href="<?php echo $link; ?>"><?php echo $group; ?></a>
        <a href="<?php echo $createLink; ?>" class="pull-right btn btn-sm btn-default"><i class="fa fa-plus"></i> Ask Question</a>
    </div>
    <div class="list-group">
        <?php foreach($categories as $category) { ?>
            <?php if(is_array($category)) { ?>
                <?php if($category['subCategory']) { ?>
                <a href="<?php echo $category['link']; ?>" class="list-group-item">
                    <b class="list-group-item-heading"><?php echo $category['name']; ?></b>
                    <p class="list-group-item-text"><?php echo $category['description']; ?></p>
                </a>
                <?php } ?>
                <small>
                    <ul>
                        <?php

                        $questions = \humhub\modules\questionanswer\models\Question::find()
                            ->contentContainer($category['space'])
                            ->andFilterWhere(['post_type' => 'question'])
                            ->orderBy('created_at DESC')
                            ->limit(6)
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
        <?php } ?>
    </div>
</div>