
<?php if(Yii::app()->user->isAdmin()) { ?>
    <?php 
    $controller = Yii::app()->getController();
    $isQuestion = $controller->getId() === 'question' && $controller->getAction()->getId() === 'admin';
    $isAnswer = $controller->getId() === 'answer' && $controller->getAction()->getId() === 'admin';
    $isComment = $controller->getId() === 'comment' && $controller->getAction()->getId() === 'admin';
    ?>
	<ul class="nav nav-tabs qanda-header-tabs" id="filter">
        <li class="dropdown <?php echo ($isQuestion ? "active" : ""); ?>">
			<?php echo CHtml::link('Questions', Yii::app()->createUrl('//questionanswer/question/admin'), array('style' => 'cursor: pointer;')); ?>
        </li>
		<li class="dropdown <?php echo ($isAnswer ? "active" : ""); ?>">
			<?php echo CHtml::link('Answers', Yii::app()->createUrl('//questionanswer/answer/admin'), array('style' => 'cursor: pointer;')); ?>
        </li>
        <li class="dropdown <?php echo ($isComment ? "active" : ""); ?>">
			<?php echo CHtml::link('Comments', Yii::app()->createUrl('//questionanswer/comment/admin'), array('style' => 'cursor: pointer;')); ?>
        </li>
    </ul>
<?php } ?>

