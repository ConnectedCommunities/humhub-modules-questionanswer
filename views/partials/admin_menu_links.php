<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

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

