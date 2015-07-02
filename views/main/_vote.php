<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'question-votes-_vote-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'post_id',array('type'=>"hidden", 'value' => 1)); ?>
<?php echo $form->hiddenField($model,'vote_on',array('type'=>"hidden", 'value' => 'question')); ?>
<?php echo $form->hiddenField($model,'vote_type',array('type'=>"hidden", 'value' => "down")); ?>
<?php echo CHtml::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
<?php $this->endWidget(); ?>


