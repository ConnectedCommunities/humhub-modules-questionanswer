<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-votes-vote_best_answer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'post_id',array('type'=>"hidden", 'value' => $post_id)); ?>
<?php echo $form->hiddenField($model,'vote_on',array('type'=>"hidden", 'value' => "answer")); ?>
<?php echo $form->hiddenField($model,'vote_type',array('type'=>"hidden", 'value' => "accepted_answer")); ?>
<?php echo CHtml::tag('button', array('class'=> "btn btn-info btn-sm", 'type'=>'submit', 'style' => 'margin-top:5px;'), '<i class="fa fa-check"></i> Accept Answer'); ?>
<?php $this->endWidget(); ?>


