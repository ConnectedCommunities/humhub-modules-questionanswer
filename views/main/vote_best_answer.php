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
