<div class="panel-heading">
    <ul class="nav nav-tabs qanda-header-tabs">
        <li class="dropdown<?php if(Yii::app()->controller->action->id == "picked") echo ' active'; ?>">
            <a style="cursor:pointer;" href="<?php echo Yii::app()->createUrl('//questionanswer/question/picked'); ?>">Picked for you</a>
        </li>
        <li class="dropdown<?php if(Yii::app()->controller->action->id == "index") echo ' active'; ?>">
            <a style="cursor:pointer;" href="<?php echo Yii::app()->createUrl('//questionanswer/question/index'); ?>">Questions</a>
        </li>
        <li class="dropdown<?php if(Yii::app()->controller->action->id == "unanswered") echo ' active'; ?>">
            <?php echo CHtml::link('Unanswered', Yii::app()->createUrl('//questionanswer/question/unanswered'), array()); ?>
        </li>
        <li class="dropdown<?php if(Yii::app()->controller->action->id == "tag") echo ' active'; ?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tags <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <?php
                $tags = Tag::model()->findAll();
                if(!$tags) {
                    echo "<li><a href=\"#\" class=\"wallFilter\">No tags found</a></li>";
                } else {
                    foreach($tags as $tag) {
                        echo "<li><a href=\"".Yii::app()->createUrl('//questionanswer/main/tag', array('id' => $tag->id))."\" class=\"wallFilter\">".$tag->tag."</a></li>";
                    }
                }
                ?>
            </ul>
        </li>
        <?php if(Yii::app()->user->isAdmin()) { ?>
            <li class="dropdown">
                <?php echo CHtml::link('Admin', Yii::app()->createUrl('//questionanswer/question/admin'), array()); ?>
            </li>
        <?php } ?>
        <li class="dropdown pull-right" style="display:none;">
            <?php echo CHtml::link('<i class="fa fa-plus"></i> Ask Question', Yii::app()->createAbsoluteUrl('//questionanswer/question/create'), array('class'=>'dropdown-toggle btn btn-community', 'style'=>"padding:8px;")); ?>
        </li>
    </ul>
</div>