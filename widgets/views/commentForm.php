<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'comment-comment-form',
    'enableAjaxValidation'=>false,
    'action' => Yii::app()->createUrl('//questionanswer/comment/create')
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->error($model,'post_text'); ?>
<?php echo $form->textArea($model,'post_text',array('id' => "contentForm_answersText", 'rows' => '2', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Add comment...")); ?>
<?php echo $form->hiddenField($model,'question_id',array('type'=>"hidden", 'value' => $question_id)); ?>
<?php echo $form->hiddenField($model,'parent_id',array('type'=>"hidden", 'value' => $parent_id)); ?>
<?php
echo CHtml::hiddenField("containerGuid", Yii::app()->user->guid);
echo CHtml::hiddenField("containerClass",  get_class(new User()));
?>
<?php echo CHtml::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
<?php $this->endWidget(); ?>