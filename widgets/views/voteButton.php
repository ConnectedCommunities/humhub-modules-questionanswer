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
