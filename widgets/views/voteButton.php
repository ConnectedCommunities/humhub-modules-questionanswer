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
<?php
    if ($vote_type='up'){
        echo CHtml::tag('button', array('class'=> $btnClass . " btn-like " . $class, 'type'=>'submit', 'title' => 'like'), '<i class="fa fa-thumbs-o-'.$vote_type.'"></i>');
    }else{
        echo CHtml::tag('button', array('class'=> $btnClass . " btn-like " . $class, 'type'=>'submit', 'title' => 'dislike'), '<i class="fa fa-thumbs-o-'.$vote_type.'"></i>');
    }
?>
<?php $this->endWidget(); ?>
