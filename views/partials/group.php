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
                            ->orderBy('pinned DESC, created_at DESC')
                            ->limit(6)
                            ->all();
                        
                        ?>

                        <?php foreach($questions as $q) { ?>
                            <?php
                            $url = \humhub\modules\questionanswer\helpers\Url::createUrl('view', [
                                'id'=> $q['id'],
                                'sguid' => $category['space']->guid
                            ])
                            ?>

                            <a href="<?php echo $url; ?>" class="list-group-item">
                                <?php if($q['pinned']) echo "<small><i class=\"glyphicon glyphicon-pushpin\"></i></small>"; ?>
                                <b class="list-group-item-heading"><?php echo \yii\helpers\Html::encode($q['post_title']); ?></b>
                            </a>
                        <?php } ?>

                    </ul>
                </small>
            <?php } ?>
        <?php } ?>
    </div>
</div>