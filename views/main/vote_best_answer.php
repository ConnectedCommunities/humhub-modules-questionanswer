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
<?php
if($accepted_answer) {
	$btnClass = "btn-info";
	$text = "Accepted Answer";
} else {
	$btnClass = "btn-default";
	$text = "Mark as Accepted Answer";
} 

if(Yii::app()->user->id == $author) {
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'question-votes-vote_best_answer-form',
		'enableAjaxValidation'=>false,
	)); 

	echo $form->hiddenField($model,'post_id',array('type'=>"hidden", 'value' => $post_id)); 
	echo $form->hiddenField($model,'vote_on',array('type'=>"hidden", 'value' => "answer"));
	echo $form->hiddenField($model,'vote_type',array('type'=>"hidden", 'value' => "accepted_answer")); 

	echo CHtml::tag('button', array('class'=> "btn {$btnClass} btn-sm", 'type'=>'submit', 'style' => 'margin-top:5px;'), '<i class="fa fa-check"></i> ' . $text); 
} else if($accepted_answer) {
	echo "<span class=\"label label-success\" style=\"padding:5px;\"><i class=\"fa fa-check\"></i> $text</span>"; 
	echo "<br />";
}


if(Yii::app()->user->id == $author) {
	$this->endWidget(); 
}
?>
