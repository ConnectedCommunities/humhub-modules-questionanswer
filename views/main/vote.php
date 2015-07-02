<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'question-votes-_vote-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'post_id',array('type'=>"hidden", 'value' => $post_id)); ?>
<?php echo $form->hiddenField($model,'vote_on',array('type'=>"hidden", 'value' => $vote_on)); ?>
<?php echo $form->hiddenField($model,'vote_type',array('type'=>"hidden", 'value' => $vote_type)); ?>
<?php echo CHtml::tag('button', array('class'=>'btn btn-default btn-xs '. $class, 'type'=>'submit', 'style' => 'margin-top:5px;'), '<i class="fa fa-angle-'.$vote_type.'"></i>'); ?>
<?php $this->endWidget(); ?>


