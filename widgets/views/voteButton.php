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
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'question-votes-_vote-form',
    'enableAjaxValidation'=>false,
    'action' => Yii::app()->createUrl('//questionanswer/vote/create')
)); ?>
<?php
if(!isset($btnClass)) {
	$btnClass = "btn btn-default btn-xs";
}
?>
<?php echo $form->hiddenField($model,'should_open_question',array('type'=>"hidden", 'value' => $should_open_question)); ?>
<?php echo $form->hiddenField($model,'post_id',array('type'=>"hidden", 'value' => $post_id)); ?>
<?php echo $form->hiddenField($model,'vote_on',array('type'=>"hidden", 'value' => $vote_on)); ?>
<?php echo $form->hiddenField($model,'vote_type',array('type'=>"hidden", 'value' => $vote_type)); ?>
<?php echo CHtml::tag('button', array('class'=> $btnClass . " " . $class, 'type'=>'submit', 'style' => 'margin-top:5px;'), '<i class="fa fa-angle-'.$vote_type.'"></i>'); ?>
<?php $this->endWidget(); ?>
